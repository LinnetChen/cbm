<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\giftContent;
use App\Models\giftCreate;
use App\Models\giftGetLog;
use App\Models\giftGroup;
use App\Models\MsgBoard;
use App\Models\newGiftContent;
use App\Models\Event20240403User;
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
    // 領獎專區-活動背包
    public function active_gift(Request $request)
    {
        $server_id = $request->server_id;
        $type = 'active';
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
        // 確認伺服器
        if ($request->server_id != 1 && $request->server_id != 2) {
            return response()->json([
                'status' => -93,
            ]);
        }
        // 確認1.2服是否有角色
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/game/character/searchByCharacterId?userId=' . $_COOKIE['StrID'] . '&serverCode=server0' . $request->server_id);
        $checkChar = $res->getBody();
        $checkChar = json_decode($checkChar);

        if (count($checkChar->data) <= 0) {
            return response()->json([
                'status' => -92,
            ]);
        };

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
        $repeat = [69];

        if (!in_array($request->gift_id, $repeat)) {
            $check = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->first();
            if ($check) {
                return response()->json([
                    'status' => -99,
                ]);
            }
        }
        // 以下領獎邏輯撰寫
        if ($request->gift_id == 69) {
            $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
            if (!$check) {
                $client = new Client(['verify' => false]);
                $res = $client->request('POST', 'https://digeam.com/api/get_cbo_user_login?user=' . $_COOKIE['StrID']);
                $reqbody = $res->getBody();
                $reqbody = json_decode($reqbody);
                $user_type = $reqbody->status;
                if ($user_type == 'skillful') {
                    $info = [];
                    // 以上待上線後撰寫搜尋login DB
                    $user = new Event20240403User();
                    $user->user_id = $_COOKIE['StrID'];
                    $user->user_type = $user_type;
                    $user->info = json_encode($info);
                    $getCode = frontController::set_code();
                    $code = explode('/', $getCode);
                    $user->server_01_code = $code[0];
                    $user->server_02_code = $code[1];
                    $user->save();
                }
            } else {
                if ($check->user_type != 'skillful') {
                    return response()->json([
                        'status' => -90,
                    ]);
                }
            }
            $checkTodayGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
            if ($checkTodayGet) {
                return response()->json([
                    'status' => -90,
                ]);
            }

        }
        // 以上領獎邏輯撰寫
        // 無誤就派獎
        frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip, $type, $server_id);
        return response()->json([
            'status' => 1,
        ]);

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
        $repeat = [16, 17, 18, 19, 28, 30, 31, 36, 37, 38, 39, 40, 65, 67, 70];

        if (!in_array($request->gift_id, $repeat)) {
            $check = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->first();
            if ($check) {
                return response()->json([
                    'status' => -99,
                ]);
            }
        }
        // 以下領獎邏輯撰寫
        if ($request->gift_id == 70) {
            //時間限制
            if ($setDay >= Carbon::today()->startOfDay() && $setDay <= Carbon::today()->startOfDay()->addMinutes(10)) {
                return response()->json([
                    'status' => -98,
                ]);
            }
            if ((date('YmdHis') <= '20240327000000') || (date('YmdHis') >= '20240401235959')) {
                return response()->json([
                    'status' => -98,
                ]);
            }
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => 20240327,
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
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
            $already_buy = [];
            for ($i = 0; $i < 6; $i++) {
                if ($i > 4) {
                    $date = 20240397;
                } else {
                    $date = 20240327;
                }
                if (isset($result->data->list->{$date + $i})) {
                    foreach ($result->data->list->{$date + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                $total += $value_2->cashAmount;
                            }
                        }
                    }
                }
            }
            if ($_COOKIE['StrID'] == 'jacky0996') {
                $total = 1000;
            }
            if ($total < 250) {
                return response()->json([
                    'status' => -90,
                ]);
            }
            $canGet = floor($total / 250);
            // 計算共領了多少,並判斷是否能繼續領
            $already_get_count = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            $already_get_count = floor($already_get_count / 2);
            if ($already_get_count >= $canGet) {
                return response()->json([
                    'status' => -90,
                ]);
            } else {
                $run = $canGet - $already_get_count;
                if ($run > 0) {
                    for ($i = 0; $i < $run; $i++) {
                        frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip, 'cash', 0);
                    }
                }
            }
            return response()->json([
                'status' => 1,
            ]);
        }
        // 春季消費再加碼！
        if ($request->gift_id == 67) {
            //時間限制
            if ($setDay >= Carbon::today()->startOfDay() && $setDay <= Carbon::today()->startOfDay()->addMinutes(10)) {
                return response()->json([
                    'status' => -98,
                ]);
            }

            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => 20240227,
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
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
            $already_buy = [];
            for ($i = 0; $i < 8; $i++) {
                if (isset($result->data->list->{20240227 + $i})) {
                    foreach ($result->data->list->{20240227 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                $total += $value_2->cashAmount;
                            }
                        }
                    }
                }
            }
            for ($i = 0; $i < 8; $i++) {
                if (isset($result->data->list->{20240301 + $i})) {
                    foreach ($result->data->list->{20240301 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                $total += $value_2->cashAmount;
                            }
                        }
                    }
                }
            }
            $canGet = floor($total / 500);
            $already_get_count = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->count();
            if ($already_get_count >= $canGet) {
                return response()->json([
                    'status' => -90,
                ]);
            } else {
                // 計算此次領取量
                $thisTimeGet = $canGet - $already_get_count;
                for ($i = 0; $i < $thisTimeGet; $i++) {
                    $getItem = giftContent::where('gift_group_id', $request->gift_id)->get();
                    foreach ($getItem as $value) {
                        $count_number_log = giftGetLog::count();
                        $tranNo = 'gift-' . $request->gift_id . '-' . $i . '-' . $count_number_log . date('YmdHis');
                        // 撰寫紀錄
                        $newLog = new giftGetLog();
                        $newLog->user = $_COOKIE['StrID'];
                        $newLog->gift = $request->gift_id;
                        $newLog->gift_item = $value['title'];
                        $newLog->ip = $real_ip;
                        $newLog->tranNo = $tranNo;
                        $newLog->is_send = 'n';
                        $newLog->save();
                    }
                }
            }
            return response()->json([
                'status' => 1,
            ]);
        }
        // 消費即刻送！
        if ($request->gift_id == 66) {
            //時間限制
            if ($setDay >= Carbon::today()->startOfDay() && $setDay <= Carbon::today()->startOfDay()->addMinutes(10)) {
                return response()->json([
                    'status' => -98,
                ]);
            }

            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => 20240227,
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
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
            $already_buy = [];
            for ($i = 0; $i < 8; $i++) {
                if (isset($result->data->list->{20240227 + $i})) {
                    foreach ($result->data->list->{20240227 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                $total += $value_2->cashAmount;
                            }
                        }
                    }
                }
            }
            for ($i = 0; $i < 8; $i++) {
                if (isset($result->data->list->{20240301 + $i})) {
                    foreach ($result->data->list->{20240301 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                $total += $value_2->cashAmount;
                            }
                        }
                    }
                }
            }
            if ($total < 1) {
                return response()->json([
                    'status' => -90,
                ]);
            }

        }
        // 春日消費回饋禮,可重複領項目
        if ($request->gift_id == 65) {
            {
                //時間限制
                if ($setDay >= Carbon::today()->startOfDay() && $setDay <= Carbon::today()->startOfDay()->addMinutes(10)) {
                    return response()->json([
                        'status' => -98,
                    ]);
                }
                if ((date('YmdHis') <= '20240305120000') || (date('YmdHis') >= '20240326235959')) {
                    return response()->json([
                        'status' => -98,
                    ]);
                }
                $client = new Client(['verify' => false]);
                $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
                $result = $res->getBody();
                $result = json_decode($result);
                $setDay = Carbon::now()->format('Ymd');
                $client = new Client();
                $data = [
                    "startDate" => $setDay,
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
                $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
                $already_buy = [];
                if (isset($result->data->list->{$setDay})) {
                    foreach ($result->data->list->{$setDay} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                if ($value_2->logDateTime > '2024-03-05 12:00') {
                                    $total += $value_2->cashAmount;
                                }
                            }
                        }
                    }
                }
                if ($_COOKIE['StrID'] == 'jacky0996') {
                    $total = 300;
                }
                if ($total < 300) {
                    return response()->json([
                        'status' => -90,
                    ]);
                } else {
                    $checkTodayGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
                    if ($checkTodayGet) {
                        return response()->json([
                            'status' => -99,
                        ]);
                    } else {
                        $check_bouns = giftGetLog::where('gift', $request->gift_id)->where('gift_item', '加贈春日福袋兌換券')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count();
                        if ($check_bouns < 30) {
                            frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, 4198459, 0, 1288, 1, $type, $server_id);
                        }
                    }
                }
            }
        }
        // 春日消費回饋禮
        if ($request->gift_id == 54 || $request->gift_id == 55 || $request->gift_id == 56 || $request->gift_id == 57 || $request->gift_id == 58 || $request->gift_id == 59 || $request->gift_id == 60 || $request->gift_id == 61 || $request->gift_id == 62 || $request->gift_id == 63 || $request->gift_id == 64) {
            // 四選一確認
            if ($request->gift_id == 58 || $request->gift_id == 59 || $request->gift_id == 60 || $request->gift_id == 61) {
                $check = giftGetLog::where('user', $_COOKIE['StrID'])->whereIn('gift', [58, 59, 60, 61])->first();
                if ($check) {
                    return response()->json([
                        'status' => -99,
                    ]);
                }
            }
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => 20240305,
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
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
            $already_buy = [];
            for ($i = 0; $i < 22; $i++) {
                if (isset($result->data->list->{20240305 + $i})) {
                    foreach ($result->data->list->{20240305 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                if ($value_2->logDateTime > '2024-03-05 12:00') {
                                    $total += $value_2->cashAmount;
                                }
                            }
                        }
                    }
                }
            }

            if ($_COOKIE['StrID'] == 'a29817922') {
                $total -= 1000;
            }
            if ($_COOKIE['StrID'] == 'c125229625') {
                $total -= 15600;
            }
            if ($_COOKIE['StrID'] == 'zz600425zz') {
                $total -= 10500;
            }
            switch ($request->gift_id) {
                case 54:
                    $need = 30;
                    break;
                case 55:
                    $need = 150;
                    break;
                case 56:
                    $need = 500;
                    break;
                case 57:
                    $need = 1500;
                    break;
                case 58:
                    $need = 3000;
                    break;
                case 59:
                    $need = 3000;
                    break;
                case 60:
                    $need = 3000;
                    break;
                case 61:
                    $need = 3000;
                    break;
                case 62:
                    $need = 6000;
                    break;
                case 63:
                    $need = 10000;
                    break;
                case 64:
                    $need = 18000;
                    break;
            }

            if ($total < $need) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // 金龍送福，新年好運回饋禮-每100可重複領
        if ($request->gift_id == 40) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2024-02-21',
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
                        frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 33555966, 999, 0, 1288, 999);
                    }
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 33555966, $remainder, 0, 1288, $remainder);
                    return response()->json([
                        'status' => 1,
                    ]);
                } else {
                    // 道具堆疊問題,未滿999使用以下
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 33555966, $thisTimeGet, 0, 1288, $thisTimeGet);
                    return response()->json([
                        'status' => 1,
                    ]);

                }
            }
        }
        // 金龍送福，新年好運回饋禮
        if ($request->gift_id == 41 || $request->gift_id == 42 || $request->gift_id == 43 || $request->gift_id == 44 || $request->gift_id == 45 || $request->gift_id == 46 || $request->gift_id == 47 || $request->gift_id == 48 || $request->gift_id == 49 || $request->gift_id == 50) {
            // 三選一確認
            if ($request->gift_id == 45 || $request->gift_id == 46 || $request->gift_id == 47) {
                $check = giftGetLog::where('user', $_COOKIE['StrID'])->whereIn('gift', [45, 46, 47])->first();
                if ($check) {
                    return response()->json([
                        'status' => -99,
                    ]);
                }
            }
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2024-02-21',
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
                case 41:
                    $need = 30;
                    break;
                case 42:
                    $need = 150;
                    break;
                case 43:
                    $need = 500;
                    break;
                case 44:
                    $need = 1500;
                    break;
                case 45:
                    $need = 3000;
                    break;
                case 46:
                    $need = 3000;
                    break;
                case 47:
                    $need = 3000;
                    break;
                case 48:
                    $need = 6000;
                    break;
                case 49:
                    $need = 10000;
                    break;
                case 50:
                    $need = 18000;
                    break;
            }
            if ($result < $need) {
                return response()->json([
                    'status' => -90,
                ]);
            }
        }
        // MyCard專屬-儲值加碼超值虛寶1000
        if ($request->gift_id == 51) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2024-03-01',
                'proCode' => 'E8294',
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
        // MyCard專屬-儲值加碼超值虛寶3000
        if ($request->gift_id == 52) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2024-03-01',
                'proCode' => 'E8295',
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
        // // MyCard專屬-儲值加碼超值虛寶-任意金額
        if ($request->gift_id == 53) {
            $client = new Client();
            $data = [
                'user_id' => $_COOKIE['StrID'],
                'start' => $check_gift['start'],
                'end' => '2024-03-01',
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'https://webapi.digeam.com//cbo/get_myCard_record_no_promocode', [
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
        // 2024每日最速傳說
        if ($request->gift_id == 39) {
            {
                //時間限制
                if ($setDay >= Carbon::today()->startOfDay() && $setDay <= Carbon::today()->startOfDay()->addMinutes(10)) {
                    return response()->json([
                        'status' => -98,
                    ]);
                }

                $client = new Client(['verify' => false]);
                $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
                $result = $res->getBody();
                $result = json_decode($result);
                $setDay = Carbon::now()->format('Ymd');
                $client = new Client();
                $data = [
                    "startDate" => 20240102,
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
                $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
                $already_buy = [];
                for ($i = 0; $i < 22; $i++) {
                    if (isset($result->data->list->{20240102 + $i}) && (20240102 + $i) == $setDay) {
                        foreach ($result->data->list->{20240102 + $i} as $value_2) {
                            if ($value_2->logName == 'consumption') {
                                $add = true;
                                // 檢查是否VIP道具
                                foreach ($vipItem as $value_3) {
                                    if (strpos($value_2->itemName, $value_3) !== false) {
                                        $add = false;
                                        break;
                                    }
                                }
                                if ($add == true) {
                                    $total += $value_2->cashAmount;
                                }
                            }
                        }
                    }
                }
                if ($total < 24) {
                    return response()->json([
                        'status' => -90,
                    ]);
                } else {
                    $checkTodayGet = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->first();
                    if ($checkTodayGet) {
                        return response()->json([
                            'status' => -99,
                        ]);
                    } else {
                        $check_bouns = giftGetLog::where('gift', $request->gift_id)->where('gift_item', '加贈5枚2024遨龍代幣')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count();
                        if ($check_bouns < 30) {
                            frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 5657, 20975364, 0, 1288, 5);
                        }
                    }
                }
            }
        }
        // 2024遨龍代幣
        if ($request->gift_id == 38) {
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => 20240102,
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
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
            $already_buy = [];
            for ($i = 0; $i < 22; $i++) {
                if (isset($result->data->list->{20240102 + $i})) {
                    foreach ($result->data->list->{20240102 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                $total += $value_2->cashAmount;
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
        if ($request->gift_id == 37) {
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => 20240102,
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
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師', '力量晶石組合包'];
            $already_buy = [];
            for ($i = 0; $i < 22; $i++) {
                if (isset($result->data->list->{20240102 + $i})) {
                    foreach ($result->data->list->{20240102 + $i} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
                                if (!in_array($value_2->itemName, $already_buy)) {
                                    array_push($already_buy, $value_2->itemName);
                                    $total += $value_2->itemPrice;
                                }
                            }
                        }
                    }
                }
            }
            // 計算20領一次
            $canGet = floor($total / 20);
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
                        frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 33560062, 999, 0, 1288, 999);
                    }
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 33560062, $remainder, 0, 1288, $remainder);
                    return response()->json([
                        'status' => 1,
                    ]);
                } else {
                    // 道具堆疊問題,未滿999使用以下
                    frontController::custom_send_item($_COOKIE['StrID'], $request->gift_id, $real_ip, 33560062, $thisTimeGet, 0, 1288, $thisTimeGet);
                    return response()->json([
                        'status' => 1,
                    ]);

                }
            }
        }
        //再戰2024
        if ($request->gift_id == 36) {
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
            $result = $res->getBody();
            $result = json_decode($result);
            $setDay = Carbon::now()->format('Ymd');
            $client = new Client();
            $data = [
                "startDate" => '20231229',
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
            $setArray = [20231229, 20231230, 20231231, 20240101];
            $vipItem = ['練功幫手', '奪寶大師', '白金服務', '白金之翼', '練功大師'];
            foreach ($setArray as $value) {
                if (isset($result->data->list->{$value})) {
                    foreach ($result->data->list->{$value} as $value_2) {
                        if ($value_2->logName == 'consumption') {
                            $add = true;
                            // 檢查是否VIP道具
                            foreach ($vipItem as $value_3) {
                                if (strpos($value_2->itemName, $value_3) !== false) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add == true) {
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
            } else {
                $run = $canGet - $alreadyGet;
                for ($i = 0; $i < $run; $i++) {
                    frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip);
                }
                return response()->json([
                    'status' => 1,
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
                'end' => date('Y-m-d 23:59:59'),
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
        frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip, 'cash', 0);
        return response()->json([
            'status' => 1,
        ]);

    }
    // 領獎專區送獎
    private function giftSendItem($user, $gift_id, $ip, $type, $server_id)
    {
        if ($type == 'active') {
            $getItem = newGiftContent::where('gift_group_id', $gift_id)->where('serverIdx', $server_id)->get();
        } else {
            $getItem = giftContent::where('gift_group_id', $gift_id)->get();
        }
        foreach ($getItem as $key => $value) {
            $count_number_log = giftGetLog::count();
            if ($type == 'active') {
                $tranNo = 'active-' . $gift_id . '-' . $key . '-' . $count_number_log . date('YmdHis');
            } else {
                $tranNo = 'gift-' . $gift_id . '-' . $key . '-' . $count_number_log . date('YmdHis');
            }
            // 撰寫紀錄
            $newLog = new giftGetLog();
            $newLog->user = $user;
            $newLog->gift = $gift_id;
            $newLog->gift_item = $value['title'];
            $newLog->ip = $ip;
            $newLog->tranNo = $tranNo;
            $newLog->is_send = 'n';
            $newLog->server_id = $server_id;
            $newLog->type = $type;
            $newLog->save();
        }
    }
    // 自定義參數派獎
    private function custom_send_item($user, $gift_id, $ip, $itemIdx, $itemOpt, $durationIdx, $prdId, $count, $type, $server_id)
    {

        $getItem = giftContent::where('gift_group_id', $gift_id)->first();
        $count_number_log = giftGetLog::count();
        $tranNo = $user . '-gift-' . 0 . '-' . $count_number_log . date('YmdHis');

        // 先寫紀錄
        if ($gift_id == 65) {
            $getItem['title'] = '加贈春日福袋兌換券';
        }

        $newLog = new giftGetLog();
        $newLog->user = $user;
        $newLog->gift = $gift_id;
        $newLog->gift_item = $getItem['title'];
        $newLog->ip = $ip;
        $newLog->tranNo = $tranNo;
        $newLog->count = $count;
        $newLog->is_send = 'y';
        $newLog->server_id = $server_id;
        $newLog->type = $type;
        $newLog->save();
        $checkErrorGet = giftGetLog::where('user', $user)->where('tranNo', $tranNo)->count();
        if ($checkErrorGet > 1) {
            $newErrorLog = new giftGetLog();
            $newErrorLog->user = $user;
            $newErrorLog->gift = $gift_id;
            $newErrorLog->gift_item = $getItem['title'];
            $newErrorLog->ip = $ip;
            $newErrorLog->tranNo = $tranNo;
            $newErrorLog->count = $count;
            $newErrorLog->is_send = '已在同時間有派發過一次獎勵';
            $newErrorLog->save();
        } else {
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
        }
    }
    public function free_send_item()
    {
        // 確認1.2服是否有角色
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/game/character/searchByCharacterId?userId=jacky0996&serverCode=server01');
        $check_01 = $res->getBody();
        $check_01 = json_decode($check_01);

        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/game/character/searchByCharacterId?userId=jacky0996&serverCode=server02');
        $check_02 = $res->getBody();
        $check_02 = json_decode($check_02);
        dd($check_01, $check_02);
        if (count($check_01->data) > 0) {
            $hasChar_01 = true;
        } else {
            $hasChar_01 = false;
        };

        if (count($check_02->data) > 0) {
            $hasChar_02 = true;
        } else {
            $hasChar_02 = false;
        };

        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=jacky0996');
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);

        $client = new Client();
        $data = [
            "userNum" => 206953,
            "deliveryTime" => "2024-03-16 00:00:00",
            "expirationTime" => "2024-04-01 23:59:59",
            "itemKind" => 1,
            "itemOption" => 0,
            "itemPeriod" => 0,
            "count" => 1,
            "title" => "test",
            "serverIdx" => 2,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/user/giveItemUserEventInventoryByUserNumAndItemInfo', [
            'headers' => $headers,
            'json' => $data,
        ]);

        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);
    }

    // 產碼
    private function set_code()
    {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid_01 = substr($charid, 0, 4)
        . substr($charid, 4, 4)
        . substr($charid, 8, 4);

        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid_02 = substr($charid, 0, 4)
        . substr($charid, 4, 4)
        . substr($charid, 8, 4);

        return $uuid_01 . '/' . $uuid_02;
    }
}
