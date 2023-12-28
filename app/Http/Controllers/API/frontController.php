<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\giftContent;
use App\Models\giftCreate;
use App\Models\giftGetLog;
use App\Models\giftGroup;
use App\Models\MsgBoard;
use App\Models\PreregUser;
use App\Models\serial_item;
use App\Models\serial_number;
use App\Models\serial_number_cate;
use App\Models\serial_number_getlog;
use App\Models\transfer_user;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class frontController extends Controller
{
    // 序號兌換
    public function exchange(Request $request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $setDay = date('Y-m-d h:i:s');
        $check = frontController::getUser($_COOKIE['StrID']);
        // 確認帳號
        if ($check->data < 0) {
            return response()->json([
                'status' => -99,
            ]);
        }

        // 確認序號
        $check_number = serial_number::where('number', $request->number)->first();
        // 確認輸入正確
        if (!$check_number) {
            return response()->json([
                'status' => -98,
            ]);
        }
        // 序號已使用
        if ($check_number->status == 'Y') {
            return response()->json([
                'status' => -97,
            ]);
        }

        // 序號在可使用時間內
        $check_number_cate = serial_number_cate::where('type', $check_number->type)->first();
        if ($setDay < $check_number_cate['start_date'] || $setDay > $check_number_cate['end_date']) {
            return response()->json([
                'status' => -96,
            ]);
        }
        // 檢查是否已參加過活動
        $checkAlreadyJoin = serial_number_getlog::where('serial_cate_id', $check_number_cate['id'])->where('user', $_COOKIE['StrID'])->first();
        if ($checkAlreadyJoin) {
            return response()->json([
                'status' => -95,
            ]);
        }
        // 一對一資料更新
        if ($check_number_cate->all_for_one == 'N') {
            $check_number->status = 'Y';
            $check_number->user_id = $_COOKIE['StrID'];
            $check_number->user_ip = $real_ip;
            $check_number->save();
        } else {
            $count = serial_number_getlog::where('serial_cate_id', $check_number_cate['id'])->count();
            if ($check_number_cate->remainder < $count) {
                return response()->json([
                    'status' => -94,
                ]);
            }
        }
        $send = frontController::sendItem($_COOKIE['StrID'], $check_number_cate['id'], $request->number, $real_ip);
        // 派獎
        return response()->json([
            'status' => 1,
        ]);
    }
    // 獲取玩家資訊
    private function getUser($user_id)
    {
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $user_id);
        $result = $res->getBody();
        $result = json_decode($result);
        return $result;

    }
    // 序號送獎
    private function sendItem($user, $cate, $number, $ip)
    {
        $getItem = serial_item::where('cate_id', $cate)->get();

        foreach ($getItem as $value) {
            $count_number_log = serial_number_getlog::count();
            $tranNo = 'number-' . $cate . '-' . $count_number_log . date('YmdHis');
            $client = new Client();
            $data = [
                "userId" => $user,
                "itemIdx" => $value['itemIdx'],
                "itemOpt" => $value['itemOpt'],
                "durationIdx" => $value['durationIdx'],
                "prdId" => $value['prdId'],
                'tranNo' => $tranNo,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item/cash', [
                'headers' => $headers,
                'json' => $data,
            ]);

            $newLog = new serial_number_getlog();
            $newLog->user = $user;
            $newLog->number = $number;
            $newLog->serial_cate_id = $cate;
            $newLog->ip = $ip;
            $newLog->tranNo = $tranNo;
            $newLog->save();
        }
    }
    // 領獎專區
    public function gift(Request $request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $check = frontController::getUser($_COOKIE['StrID']);
        // 確認帳號
        if ($check->data < 0) {
            return response()->json([
                'status' => -97,
            ]);
        }

        $setDay = Carbon::now();

        // 確認時間
        $check_gift_group = giftGroup::where('id', $request->gift_id)->first();
        $check_gift = giftCreate::where('id', $check_gift_group['gift_id'])->first();
        if ($setDay < $check_gift['start'] || $setDay > $check_gift['end']) {
            return response()->json([
                'status' => -98,
            ]);
        }
        // 確認是否領過,排除可重複領取的
        $repeat = [16, 17, 18, 19, 28, 30, 31,36,37,38,39];

        if (!in_array($request->gift_id, $repeat)) {
            $check = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->first();
            if ($check) {
                return response()->json([
                    'status' => -99,
                ]);
            }
        }
        // 以下領獎邏輯撰寫
        // 2024每日最速傳說
        if($request->gift_id == 39){
            {
                $client = new Client(['verify' => false]);
                $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' .  $_COOKIE['StrID']);
                $result = $res->getBody();
                $result = json_decode($result);
                $setDay = Carbon::now()->format('Ymd');
                $client = new Client();
                $data = [
                    "startDate" => '20231226',
                    "endDate" => $setDay,
                    "userNum" => $result->data->userNum,
                ];
        
                $headers = [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ];
        
                $res = $client->request('POST', 'http://c1twapi.global.estgames.com/cash/getCashConsumptionLogDetail', [
                    'headers' => $headers,
                    'json' => $data,
                ]);
                $result = $res->getBody();
                $result = json_decode($result);
                $total = 0;
                $setArray = [20231226,20231227,20231228,20231229,20231230,20231231,20240101];
                $vipItem = ['練功幫手','奪寶大師','白金服務','白金之翼','練功大師'];
                $already_buy = [];
                foreach($setArray as $value){
                    if(isset($result->data->list->{$value})){
                        foreach($result->data->list->{$value} as $value_2){
                            if( $value_2->logName == 'consumption'){
                                $add = true;
                                // 檢查是否VIP道具
                                foreach($vipItem as $value_3){
                                    if(strpos($value_2->itemName,$value_3) !== false){
                                        $add = false;
                                        break;
                                    }
                                }
                                if($add == true){
                                    $total+=$value_2->cashAmount;
                                }
                            }
                        }
                    }            
                }
                if($total < 24){
                    return response()->json([
                        'status' => -90,
                    ]);
                }else{
                    $checkTodayGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
                    if ($checkTodayGet) {
                        return response()->json([
                            'status' => -99,
                        ]);
                    }else{
                        $check_bouns = giftGetLog::where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count();
                        if($check_bouns<30){
                            frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, 20975364, 0, 1288, 5);
                        }
                    }
                }
            }
        }
        // 2024遨龍代幣
        if($request->gift_id ==38)    
        {
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' .  $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => '20231226',
                "endDate" => $setDay,
                "userNum" => $result->data->userNum,
            ];
    
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];
    
            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/cash/getCashConsumptionLogDetail', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $total = 0;
            $setArray = [20231226,20231227,20231228,20231229,20231230,20231231,20240101];
            $vipItem = ['練功幫手','奪寶大師','白金服務','白金之翼','練功大師'];
            $already_buy = [];
            foreach($setArray as $value){
                if(isset($result->data->list->{$value})){
                    foreach($result->data->list->{$value} as $value_2){
                        if( $value_2->logName == 'consumption'){
                            $add = true;
                            // 檢查是否VIP道具
                            foreach($vipItem as $value_3){
                                if(strpos($value_2->itemName,$value_3) !== false){
                                    $add = false;
                                    break;
                                }
                            }
                            if($add == true){
                                $total+=$value_2->cashAmount;
                            }
                        }
                    }
                }            
            }
            // 計算100領一次
            $canGet = floor($total / 100);
            // 計算共領了多少,並判斷是否能繼續領
            $already_get_count = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->sum('count');
    
            if ($already_get_count >= $canGet) {
                return response()->json([
                    'status' => -90,
                ]);
            } else {
                // 計算此次領取量
                $thisTimeGet = $canGet - $already_get_count;
                // 道具堆疊問題,超過999使用以下,因門檻低,道具數量多,則除999並且扣除再額外發送餘數
                if ($thisTimeGet > 999) {
                    $totalRound = floor($thisTimeGet / 999);
                    $remainder = $thisTimeGet % 999;
                    for ($i = 0; $i < $totalRound; $i++) {
                        frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, 4190113540, 0, 1288, 999);
                    }
                    $itemOpt = 4198148 + ($remainder - 1) * 4194304;
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, $itemOpt, 0, 1288, $remainder);
                    return response()->json([
                        'status' => 1,
                    ]);
                } else {
                    // 道具堆疊問題,未滿999使用以下
                    $itemOpt = 4198148 + ($thisTimeGet - 1) * 4194304;
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, $itemOpt, 0, 1288, $thisTimeGet);
                    return response()->json([
                        'status' => 1,
                    ]);
    
                }
            }
        }
        //2024的祝福
        if($request->gift_id ==37)
        {
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' .  $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => '20231226',
                "endDate" => $setDay,
                "userNum" => $result->data->userNum,
            ];
    
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];
    
            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/cash/getCashConsumptionLogDetail', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $total = 0;
            $setArray = [20231226,20231227,20231228,20231229,20231230,20231231,20240101];
            $vipItem = ['練功幫手','奪寶大師','白金服務','白金之翼','練功大師','力量晶石'];
            $already_buy = [];
            foreach($setArray as $value){
                if(isset($result->data->list->{$value})){
                    foreach($result->data->list->{$value} as $value_2){
                        if( $value_2->logName == 'consumption'){
                            $add = true;
                            // 檢查是否VIP道具
                            foreach($vipItem as $value_3){
                                if(strpos($value_2->itemName,$value_3) !== false){
                                    $add = false;
                                    break;
                                }
                            }
                            if($add == true){
                                if(!in_array($value_2->itemName,$already_buy)){
                                    array_push($already_buy,$value_2->itemName);
                                    $total+=$value_2->itemPrice;
                                }
                            }
                        }
                    }
                }            
            }
            // 計算10領一次
            $canGet = floor($total / 10);
            $already_get_count = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->sum('count');
            if ($already_get_count >= $canGet) {
                return response()->json([
                    'status' => -90,
                ]);
            } else {
                // 計算此次領取量
                $thisTimeGet = $canGet - $already_get_count;
                // 道具堆疊問題,超過999使用以下,因門檻低,道具數量多,則除999並且扣除再額外發送餘數
                if ($thisTimeGet > 999) {
                    $totalRound = floor($thisTimeGet / 999);
                    $remainder = $thisTimeGet % 999;
                    for ($i = 0; $i < $totalRound; $i++) {
                        frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip,33560062, 999, 0, 1288, 999);
                    }
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip,33560062, $remainder, 0, 1288, $remainder);
                    return response()->json([
                        'status' => 1,
                    ]);
                } else {
                    // 道具堆疊問題,未滿999使用以下
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip,33560062, $thisTimeGet, 0, 1288, $thisTimeGet);
                    return response()->json([
                        'status' => 1,
                    ]);
    
                }
            }
        }
        //再戰2024
        if($request->gift_id ==36){
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => '20231226',
                "endDate" => $setDay,
                "userNum" => $result->data->userNum,
            ];
    
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];
    
            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/cash/getCashConsumptionLogDetail', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $total = 0;
            $setArray = [20231226,20231227,20231228,20231229,20231230,20231231,20240101];
            $vipItem = ['練功幫手','奪寶大師','白金服務','白金之翼','練功大師'];
            foreach($setArray as $value){
                if(isset($result->data->list->{$value})){
                    foreach($result->data->list->{$value} as $value_2){
                        if( $value_2->logName == 'consumption'){
                            $add = true;
                            // 檢查是否VIP道具
                            foreach($vipItem as $value_3){
                                if(strpos($value_2->itemName,$value_3) !== false){
                                    $add = false;
                                    break;
                                }
                            }
                            if($add == true){
                                $total += $value_2->cashAmount;
                            }
                        }
                    }
                }            
            }
            // 計算500領一次
            $canGet = floor($total / 500);
            $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if ($canGet <= $alreadyGet) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        } 
        // 12/13 - 01/02 MyCard「 I'm 饋Card」
        if ($request->gift_id == 34) {
                    $client = new Client();
                    $data = [
                        'user_id' => $_COOKIE['StrID'],
                        'start' => $check_gift['start'],
                        'end' => $check_gift['end'],
                        'proCode' => 'E8180',
                    ];
        
                    $headers = [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ];
        
                    $res = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record', [
                        'headers' => $headers,
                        'json' => $data,
                    ]);
                    $result = $res->getBody();
                    $result = json_decode($result);
                    $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->first();
                    if ($result == 0 || $alreadyGet) {
                        return response()->json([
                            'status' => -90,
                        ]);
                    }
        }
        // 聖誕感恩大回饋-百元儲值回饋幣(可重複領)
        if ($request->gift_id == 30) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => '2023-12-01',
                'end' => '2023-12-26',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com/cbo/get_change_point', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $canGet = floor($result / 100);
            // 計算共領了多少,並判斷是否能繼續領
            $already_get_count = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->sum('count');

            if ($already_get_count >= $canGet) {
                return response()->json([
                    'status' => -90,
                ]);
            } else {
                // 計算此次領取量
                $thisTimeGet = $canGet - $already_get_count;
                // 道具堆疊問題,超過999使用以下,因門檻低,道具數量多,則除999並且扣除再額外發送餘數
                if ($thisTimeGet > 999) {
                    $totalRound = floor($thisTimeGet / 999);
                    $remainder = $thisTimeGet % 999;
                    for ($i = 0; $i < $totalRound; $i++) {
                        frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, 4190113426, 0, 1288, 999);
                    }
                    $itemOpt = 4198034 + ($remainder - 1) * 4194304;
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, $itemOpt, 0, 1288, $remainder);
                    return response()->json([
                        'status' => 1,
                    ]);
                } else {
                    // 道具堆疊問題,未滿999使用以下
                    $itemOpt = 4198034 + ($thisTimeGet - 1) * 4194304;
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, $itemOpt, 0, 1288, $thisTimeGet);
                    return response()->json([
                        'status' => 1,
                    ]);

                }
            }
        }
        // 聖誕感恩大回饋-改版預備每日禮(一天領一次)
        if ($request->gift_id == 31) {
            
            return response()->json([
                'status' => -98,
            ]);

            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => date('Y-m-d 00:00:00'),
                'end' =>  date('Y-m-d 23:59:59'),
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com/cbo/get_change_point', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            if ($result > 0) {
                $checkTodayGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
                if ($checkTodayGet) {
                    return response()->json([
                        'status' => -99,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }

        // OTP綁定禮
        if ($request->gift_id == 29) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com/cbo/get_member', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            // 如果沒綁就不滿足條件
            if ($result->google2fa_active == 0) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 1031~1114改版回饋儲值禮
        if ($request->gift_id == 20 || $request->gift_id == 21 || $request->gift_id == 22 || $request->gift_id == 23 || $request->gift_id == 24 || $request->gift_id == 25 || $request->gift_id == 26 || $request->gift_id == 27) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => '2023-10-31',
                'end' => '2023-11-15',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com/cbo/get_change_point', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            switch ($request->gift_id) {
                case 20:
                    $need = 1;
                    break;
                case 21:
                    $need = 150;
                    break;
                case 22:
                    $need = 500;
                    break;
                case 23:
                    $need = 1000;
                    break;
                case 24:
                    $need = 3000;
                    break;
                case 25:
                    $need = 6000;
                    break;
                case 26:
                    $need = 10000;
                    break;
                case 27:
                    $need = 20000;
                    break;
            }
            if ($result < $need) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 1031~1114改版回饋儲值禮(該項目可重複領)
        if ($request->gift_id == 28) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => '2023-10-31',
                'end' => '2023-11-15',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com/cbo/get_change_point', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);

            $canGet = floor($result / 1000);
            $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if ($canGet <= $alreadyGet) {
                return response()->json([
                    'status' => -90,
                ]);
            } else {
                $amount = $canGet - $alreadyGet;
                for ($i = 1; $i <= $amount; $i++) {
                    frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip);
                }
                return response()->json([
                    'status' => 1,
                ]);
            }
        }
        // MYCARD本月主打星
        if ($request->gift_id == 19) {
            $client = new Client();
            $data_1 = [
                'user_id' => $_COOKIE['StrID'],
                'start' => '2023-11-1',
                'end' => '2023-12-11',
                'proCode' => 'E8092',
            ];

            $headers_1 = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res_1 = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record', [
                'headers' => $headers_1,
                'json' => $data_1,
            ]);
            $result_1 = $res_1->getBody();
            $result_1 = json_decode($result_1);

            $client = new Client();
            $data_2 = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2023-12-11',
                'proCode' => 'E8094',
            ];

            $headers_2 = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res_2 = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record', [
                'headers' => $headers_2,
                'json' => $data_2,
            ]);
            $result_2 = $res_2->getBody();
            $result_2 = json_decode($result_2);

            $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if (($result_1 + $result_2) <= $alreadyGet) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // MyCard全通路加碼回饋活動
        if ($request->gift_id == 18) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => $check_gift['end'],
                'proCode' => 'E8048',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if ($result <= $alreadyGet) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 全家限定MyCard加碼
        if ($request->gift_id == 17) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => $check_gift['end'],
                'proCode' => 'E8014',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if ($result <= $alreadyGet) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 7-ELEVEN限定MyCard加碼
        if ($request->gift_id == 16) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => $check_gift['end'],
                'proCode' => 'E8013',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            $alreadyGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if ($result <= $alreadyGet) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 黑色契約-事前預約活動
        if ($request->gift_id == 12 || $request->gift_id == 15) {
            $check = PreregUser::where('user_id', $_COOKIE['StrID'])->first();
            // $check = PreregUser::where('user_id', 'jacky0996')->first();
            if (!$check) {
                return response()->json([
                    'status' => -90,
                ]);
            }
            if ($request->gift_id == 12) {
                if ($check['mobile'] == '' || $check['mobile'] == null || !$check['mobile']) {
                    return response()->json([
                        'status' => -90,
                    ]);
                }
            }
            if ($request->gift_id == 15) {
                $MsgBoardCheck = MsgBoard::where('user_id', $_COOKIE['StrID'])->first();
                // $MsgBoardCheck = MsgBoard::where('user_id', 'jacky0996')->first();
                if (!$MsgBoardCheck) {
                    return response()->json([
                        'status' => -90,
                    ]);
                }
            }
        }

        // 老玩家限定-會員轉移專屬禮
        if ($request->gift_id == 11) {
            $check = transfer_user::where('user_id', $_COOKIE['StrID'])->first();
            if (!$check) {
                return response()->json([
                    'status' => -90,
                ]);
            }
            if ($check['cabal_id'] == '' || $check['cabal_id'] == null) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 歡慶開服．儲值有禮
        if ($request->gift_id == 4 || $request->gift_id == 5 || $request->gift_id == 6 || $request->gift_id == 7 || $request->gift_id == 8 || $request->gift_id == 9 || $request->gift_id == 10) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2023-10-21',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com/cbo/get_change_point', [
                'headers' => $headers,
                'json' => $data,
            ]);
            $result = $res->getBody();
            $result = json_decode($result);
            switch ($request->gift_id) {
                case 4:
                    $need = 1;
                    break;
                case 5:
                    $need = 150;
                    break;
                case 6:
                    $need = 500;
                    break;
                case 7:
                    $need = 1000;
                    break;
                case 8:
                    $need = 3000;
                    break;
                case 9:
                    $need = 6000;
                    break;
                case 10:
                    $need = 10000;
                    break;
            }
            if ($result < $need) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }

        // 以上領獎邏輯撰寫

        // 無誤就派獎
        // frontController::giftSendItem('jacky0996', $request->gift_id, $real_ip);
        frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip);
        return response()->json([
            'status' => 1,
        ]);

    }
    // 領獎專區送獎
    private function giftSendItem($user, $gift_id, $ip)
    {
        $getItem = giftContent::where('gift_group_id', $gift_id)->get();
        foreach ($getItem as $value) {
            $count_number_log = giftGetLog::count();
            $tranNo = 'gift-' . $gift_id . '-' . $count_number_log . date('YmdHis');
            $client = new Client();
            $data = [
                "userId" => $user,
                "itemIdx" => $value['itemIdx'],
                "itemOpt" => $value['itemOpt'],
                "durationIdx" => $value['durationIdx'],
                "prdId" => $value['prdId'],
                'tranNo' => $tranNo,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item/cash', [
                'headers' => $headers,
                'json' => $data,
            ]);
            // 撰寫紀錄
            $newLog = new giftGetLog();
            $newLog->user = $user;
            $newLog->gift = $gift_id;
            $newLog->gift_item = $value['title'];
            $newLog->ip = $ip;
            $newLog->tranNo = $tranNo;
            $newLog->save();
        }
    }
    // 自定義參數派獎
    private function custom_send_item($user, $gift_id, $ip, $itemIdx, $itemOpt, $durationIdx, $prdId, $count)
    {
        $getItem = giftContent::where('gift_group_id', $gift_id)->first();
        $count_number_log = giftGetLog::count();
        $tranNo = 'gift-' . 0 . '-' . $count_number_log . date('YmdHis');
        $client = new Client();
        $data = [
            "userId" => $user,
            "itemIdx" => $itemIdx,
            "itemOpt" => $itemOpt,
            "durationIdx" => $durationIdx,
            "prdId" => $prdId,
            'tranNo' => $tranNo,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item/cash', [
            'headers' => $headers,
            'json' => $data,
        ]);
        // 撰寫紀錄
        if($gift_id == 39 && $count == 5){
            $getItem['title'] = '加贈5枚2024遨龍代幣';
        }
        $newLog = new giftGetLog();
        $newLog->user = $user;
        $newLog->gift = $gift_id;
        $newLog->gift_item = $getItem['title'];
        $newLog->ip = $ip;
        $newLog->tranNo = $tranNo;
        $newLog->count = $count;
        $newLog->save();
    }
    // public function free_send_item()
    // {

    //     // $getItem = giftContent::where('gift_group_id', $gift_id)->get();
    //     $array = ['jacky0996', 'maik780102', 'billy1993a', 'mariofunm2', 's26994318', 'nmes1696', 'sakutofu1128', 'mm2212365', 'hdes93214a', 'a0985505067', 'syuan800523', 'jumpsquare0724', 'q2325025', 'eyes7463', 'karta404539', 'turtle800523', 'nay121800360', 'j84572004', 'mirror1225', 'q0932960355', 'zhouhank0957', 'edcsf95123', 'nay121800351', 'leo19921203', 'hk090909', 'jong630214', 'therock33440011', 'a5527440', 'hazy2000', 'wenzhe0804', 'zz600425zz', 'qa930087', 'k3617531', 'a28123125', 'allen7537', 'coco4498', 'folee101', 'k0824412', 'kendal7478', 'qaz333513', 'qq20009044', 'charel1218', 'tw00610060', 'cityhunterman520', 'l134872393', 'as4545532', 'like2044', 'a59003111', 'abc0939330488', 'do10212000', 'wdy0413605', 'chu780611', 'loveai6z83', 'maik780102jp', 'cc0923871883', 'aas1108saa', 'ivanpun0710', 'z22287941', 'asd565599', 'andy52057q', 'mika520520', 'jpkid20000', 's0965phaa', 'abc125556', 'img52wacai', 'vic212410', 'loveomg220', 'zxc841212', 'q95304025', 'zmxncbv0302', 'a0808967', 'eee220046111', 'bill83620', 'black168', 'a7867575', 'kyhuang0907', 'd32893540', 'aspirin0929', 'a0983960837', 'a0931056202', 'lewismok92', 'ztsc84131', 'dragonmice7', 'semile513513', 'rose0378', 'l0962072575', 'momo72886', 'marswinnie521', 'a62604029', 'zx44564567', 'kevin800403', 'wei19870421', 'dumpiling52031', 'samiazuk1964', 'snoppy0717', 'as0922529137', 'bigpig1991', 'cbgvf70885', 'love8154623', 'f45001232', 'hero1020', 'xcbaz882650', 'power456852', 'mobetaw75483', 'gucci0812', 'nctui510322', 'a35713076', 'a7582422', 'j8001177', 'tony9453', 'cyh851218', 'pig89006', 'a123556601', 'hiuire123', 'sheng2023', 'power810301', 'tom333498', 'yes23556', 'qqw6595626', 'who179896', 'cr4zymist', 'jason40402p', 'a0a6aa14', 'jie0988072177', 't2648371', 'a55778964', 'han840530', 'mye23054', 'phosen05339', 'bloodend623739', 'kitt643960', 'zx0936300132', 'stillpull0430', 'stormbao1', 'dream87108', 'erica26845', 'a0987437629', 'zax0624zax', 'end252003', 'aaa014134', 'andylien2002', 'eantom3325', 'foxonthegrass728', 'peja741852', 'hillx1011', 's0908531922', 'ssss20405', 'a0919273003', 'hao111318', 'obob79226', 'bincry030', 'jooers00', 'a123452594', 'azx22724531', 'shit4ock', 'chr90817', 'ccc8667351', 'iloveyou0927', 'a3296040', 'camille5200', 'aaf4858634', 'dd92nn11', 'jun0907781627', 'smalldog98', 't00293088', 'as580904925889', 'o199705241', 'df4722h111n', 'mkll7802', 'cyhae92216', 'alan10609', 's6533125', 'gaexpa156344', 'wsx85271', 'skince852', 'love811227', 'heyhey5978', 'wenhui1754', 'wuxu1127', 'yanc7lol', 'a456159753', 'zxc19880909', 'love19871225', 'b78945134', 'steve401401', 'lf20654123', 'ben049550', 'trabe79719', 'love01016', 'qaz571121', 'zxc011035', 'ts02066238', 'mocca951', 'undying2060', 'q27091533850', 'r5215love', 'bear51697', 'z5869096', 'a7512393', 'a9037023h', 'liberty052', 'z6986379', 'a0918150070', 'asd59706236', 'yihshiou21', 'ping8868', 'jerryhung8338', 'aaaa800276', 'aa830911', 'jack818818', 'bill1358', 'ayu11506', 'zhan19980814', 'rong1688', 'jack82731pk', 'z0915606711', 'zk579qwe', 'a654159753', 'hamster051', 'assam1231', 'kuskus900628', 'joezxc620914', 'kennychen1977', 'mjbpjcmt1', 'a121723578', 'qwe222423', 'eric0749', 's58806098', 'smallfe0623', 'ahyang91', 'as00597805', 'skyyong8', 'leo60110131347'];
    //     foreach ($array as $value) {
    //         $count_number_log = giftGetLog::count();
    //         $tranNo = 'gift-' . 0 . '-' . $count_number_log . date('YmdHis');
    //         $client = new Client();
    //         $data = [
    //             "userId" => $value,
    //             "itemIdx" => 7203,
    //             "itemOpt" => 300,
    //             "durationIdx" => 0,
    //             "prdId" => 1288,
    //             'tranNo' => $tranNo,
    //         ];

    //         $headers = [
    //             'Content-Type' => 'application/json',
    //             'Accept' => 'application/json',
    //         ];

    //         $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item/cash', [
    //             'headers' => $headers,
    //             'json' => $data,
    //         ]);
    //         // 撰寫紀錄
    //         $newLog = new giftGetLog();
    //         $newLog->user = $value;
    //         $newLog->gift = 0;
    //         $newLog->gift_item = 'Discord頻道全面啟動';
    //         $newLog->ip = '127.0.0.1';
    //         $newLog->tranNo = $tranNo;
    //         $newLog->save();
    //     }
    // }

    // public function free_send_item()
    // {

    //     $count_number_log = giftGetLog::count();
    //     $tranNo = 'gift-' . 0 . '-' . $count_number_log . date('YmdHis');
    //     $client = new Client();
    //     $data = [
    //         "userId" => 'jacky0996',
    //         "itemIdx" => 632,
    //         "itemOpt" => 0,
    //         "durationIdx" => 0,
    //         "prdId" => 1288,
    //         'tranNo' => $tranNo,
    //     ];

    //     $headers = [
    //         'Content-Type' => 'application/json',
    //         'Accept' => 'application/json',
    //     ];

    //     $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item/cash', [
    //         'headers' => $headers,
    //         'json' => $data,
    //     ]);
    // }
    public function free_send_item(Request $request)
    {
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' .  $request->user_id);
        $result = $res->getBody();
        $result = json_decode($result);
        $setDay = Carbon::now()->format('Ymd');
        $client = new Client();
        $data = [
            "startDate" => '20231226',
            "endDate" => $setDay,
            "userNum" => $result->data->userNum,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/cash/getCashConsumptionLogDetail', [
            'headers' => $headers,
            'json' => $data,
        ]);
        $result = $res->getBody();
        $result = json_decode($result);
        $total = 0;
        $setArray = [20231226,20231227,20231228,20231229,20231230,20231231,20240101];
        $vipItem = ['練功幫手','奪寶大師','白金服務','白金之翼','練功大師'];
        $already_buy = [];
        foreach($setArray as $value){
            if(isset($result->data->list->{$value})){
                foreach($result->data->list->{$value} as $value_2){
                    if( $value_2->logName == 'consumption'){
                        $add = true;
                        // 檢查是否VIP道具
                        foreach($vipItem as $value_3){
                            if(strpos($value_2->itemName,$value_3) !== false){
                                $add = false;
                                break;
                            }
                        }
                        if($add == true){
                            $total+=$value_2->cashAmount;
                        }
                    }
                }
            }            
        }
        if($total < 24){
            return response()->json([
                'status' => -90,
            ]);
        }else{
            $checkTodayGet = giftGetLog::where('user', $request->user_id)->where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
            if ($checkTodayGet) {
                return response()->json([
                    'status' => -99,
                ]);
            }else{
                $check_bouns = giftGetLog::where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count();
                if($check_bouns<30){
                    frontController::custom_send_item($request->user_id, $request->gift_id, $real_ip, 5657, 20975364, 0, 1288, 5);
                }
            }
        }
    }

}
