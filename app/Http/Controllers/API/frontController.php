<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\giftContent;
use App\Models\giftCreate;
use App\Models\giftGetLog;
use App\Models\giftGroup;
use App\Models\serial_item;
use App\Models\serial_number;
use App\Models\serial_number_cate;
use App\Models\serial_number_getlog;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class frontController extends Controller
{
    public function exchange(Request $request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        $_COOKIE['StrID'] = 'jacky0996';

        $setDay = date('Y-m-d h:i:s');
        // $check = frontController::getUser($_COOKIE['StrID']);
        // // 確認帳號
        // if (!$check->data->userNum) {
        //     return response()->json([
        //         'status' => -99,
        //     ]);
        // }

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
        $url = 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $user_id;
        $client = new Client();
        $res = $client->request('GET', $url);
        $result = $res->getBody();
        $result = json_decode($result);
        return $result;
    }

    private function sendItem($user, $cate, $number, $ip)
    {
        $getItem = serial_item::where('cate_id', $cate)->get();

        foreach ($getItem as $value) {
            $client = new Client();
            $data = [
                "userId" => $user,
                "itemIdx" => $value['itemIdx'],
                "itemOpt" => $value['itemOpt'],
                "durationIdx" => $value['durationIdx'],
                "prdId" => $value['prdId'],
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
            $newLog->save();
        }
    }

    public function gift(Request $request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        $setDay = date('Y-m-d h:i:s');
        // 已領過
        $check = giftGetLog::where('user', $_COOKIE['StrID'])->where('gift', $request->gift_id)->first();
        if ($check) {
            return response()->json([
                'status' => -99,
            ]);
        }
        // 確認時間
        $check_gift_group = giftGroup::where('id', $request->gift_id)->first();
        $check_gift = giftCreate::where('id', $check_gift_group['gift_id'])->first();
        if ($setDay < $check_gift['start'] || $setDay > $check_gift['end']) {
            return response()->json([
                'status' => -98,
            ]);
        }

        frontController::giftSendItem($_COOKIE['StrID'], $request->gift_id, $real_ip);
        return response()->json([
            'status' => 1,
        ]);

    }

    private function giftSendItem($user, $gift_id, $ip)
    {
        $getItem = giftContent::where('gift_group_id', $gift_id)->get();
        foreach ($getItem as $value) {
            $client = new Client();
            $data = [
                "userId" => $user,
                "itemIdx" => $value['itemIdx'],
                "itemOpt" => $value['itemOpt'],
                "durationIdx" => $value['durationIdx'],
                "prdId" => $value['prdId'],
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item/cash', [
                'headers' => $headers,
                'json' => $data,
            ]);

            $newLog = new giftGetLog();
            $newLog->user = $user;
            $newLog->gift = $gift_id;
            $newLog->gift_item = $value['title'];
            $newLog->ip = $ip;
            $newLog->save();
        }
    }

}
