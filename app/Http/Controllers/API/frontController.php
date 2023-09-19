<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\serial_item;
use App\Models\serial_number;
use App\Models\serial_number_cate;
use App\Models\giftContent;
use App\Models\giftGroup;
use App\Models\giftCreate;
use App\Models\giftGetLog;
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

        $setDay = date('Y-m-d h:i:s');
        $check = frontController::getUser($_COOKIE['StrID']);
        // 確認帳號
        if (!$check->data->userNum) {
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
            dd($setDay, $check_number_cate);
            return response()->json([
                'status' => -96,
            ]);
        }
        // 一對一資料更新
        if ($check_number_cate->all_for_one == 'N') {
            $send = frontController::sendItem($check->data->userNum, $check_number_cate['id']);
            dd('123');
            $check_number->status = 'Y';
            $check_number->user_id = $_COOKIE['StrID'];
            $check_number->user_ip = $real_ip;
            $check_number->save();
            // 派獎
            return response()->json([
                'status' => -96,
            ]);
        }
        //
        dd();
    }
    public function gift(Request $request){
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $setDay = date('Y-m-d h:i:s');
        $check = giftGetLog::where('user',$_COOKIE['StrID'])->first();

        dd($request);

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

    private function sendItem($user, $cate)
    {
        $getItem = serial_item::where('cate_id', $cate)->get();
        foreach ($getItem as $value) {
            $client = new Client();
            $data = [
                "userNum" => $user,
                "tranNo" => $value['tranNo'],
                "itemIdx" => $value['itemIdx'],
                "itemOpt" => $value['itemOpt'],
                "durationIdx" => $value['durationIdx'],
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/game/give/item', [
                'headers' => $headers,
                'json' => $data,
            ]);

            $result = $res->getBody();
            $result = json_decode($result);
            dd($result);
        }
    }
}
