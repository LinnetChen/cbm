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
        $repeat = [16, 17, 18];

        if (!in_array($request->gift_id, $repeat)) {
            $check = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->first();
            if ($check) {
                return response()->json([
                    'status' => -99,
                ]);
            }
        }
        // 以下領獎邏輯撰寫

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
    // public function free_send_item()
    // {

    //     // $getItem = giftContent::where('gift_group_id', $gift_id)->get();
    //     $array = ['jacky0996', 'gn00450329', 'hebg1225', 'wojiaodu2'];
    //     foreach ($array as $value) {
    //         $count_number_log = giftGetLog::count();
    //         $tranNo = 'gift-' . 0 . '-' . $count_number_log . date('YmdHis');
    //         $client = new Client();
    //         $data = [
    //             "userId" => $value,
    //             "itemIdx" => 5658,
    //             "itemOpt" => 3349,
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
    //         $newLog->gift_item = '20231019道具補發-儲值10000';
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
    //         "itemIdx" => 33559014,
    //         "itemOpt" => 1190,
    //         "durationIdx" => 13,
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

}
