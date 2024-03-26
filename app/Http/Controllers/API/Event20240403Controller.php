<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event240403BindingLog;
use App\Models\event240403GetLog;
use App\Models\Event20240403User;
use Illuminate\Http\Request;

class Event20240403Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'login') {
            $result = Event20240403Controller::login($request);
        } elseif ($request->type == 'qualify') {
            $result = Event20240403Controller::qualify($request);
        } elseif ($request->type == 'binding') {
            $result = Event20240403Controller::binding($request);
        } elseif ($request->type == 'send_gift') {
            $result = Event20240403Controller::send_gift($request);
        } elseif ($request->type == 'gift') {
            $result = Event20240403Controller::gift($request);
        } elseif ($request->type == 'wing_gift') {
            $result = Event20240403Controller::wing_gift($request);
        } else {
            return 0;
        }

        return $result;
    }
    // 判斷登入
    private function login($request)
    {
        if (!$_COOKIE['StrID']) {
            return response()->json([
                'status' => -99,
            ]);
        }
        // 確認是否有資料
        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        if ($check) {

        } else {
            // 第一次進入頁面,判斷玩家類型
            // 以下待上線後撰寫搜尋login DB
            $user_type = 'skillful';
            $info = [];
            // 以上待上線後撰寫搜尋login DB
            $user = new Event20240403User();
            $user->user_id = $_COOKIE['StrID'];
            $user->user_type = $user_type;
            $user->info = json_encode($info);
            if ($user_type == 'skillful') {
                $getCode = Event20240403Controller::set_code();
                $code = explode('/', $getCode);
                $user->server_01_code = $code[0];
                $user->server_02_code = $code[1];
            }
            $user->save();
        }
        $user = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        return response()->json([
            'status' => 1,
        ]);
    }
    private function qualify($request)
    {
        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }
        $info = json_decode($check['info']);
        if (count($info) >= 3) {
            return response()->json([
                'status' => -98,
            ]);
        } else {
            return response()->json([
                'status' => 1,
            ]);
        }
    }
    // 綁定
    private function binding($request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        $info = json_decode($check['info']);
        if (count($info) >= 3) {
            return response()->json([
                'status' => -99,
            ]);
        }
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }
        // 確認是否被綁定
        $checkAlreadyUse = Event240403BindingLog::where('binding', $request->binding)->first();
        if ($checkAlreadyUse) {
            return response()->json([
                'status' => -98,
            ]);
        }
        // 確認綁定碼是否正確
        if ($request->server_id == 'server01') {
            $checkBinding = Event20240403User::where('server_01_code', $request->binding)->where('user_type', 'skillful')->first();
        } else if ($request->server_id == 'server02') {
            $checkBinding = Event20240403User::where('server_02_code', $request->binding)->where('user_type', 'skillful')->first();
        } else {
            return response()->json([
                'status' => -96,
            ]);
        }
        if (!$checkBinding) {
            return response()->json([
                'status' => -97,
            ]);
        }
        // 確認伺服器
        if ($request->server_id == 'server00') {
            return response()->json([
                'status' => -96,
            ]);
        } elseif ($request->server_id != 'server01' && $request->server_id != 'server02') {
            return response()->json([
                'status' => -96,
            ]);
        }

        $info[count($info)] = $request->binding;
        $check->info = $info;
        $check->save();

        $newBindingLog = new Event240403BindingLog();
        $newBindingLog->user = $_COOKIE['StrID'];
        $newBindingLog->server_id = $request->server_id;
        $newBindingLog->binding = $request->binding;
        $newBindingLog->ip = $real_ip;
        $newBindingLog->save();

        return response()->json([
            'status' => 1,
        ]);
    }
    // 立即領獎
    private function send_gift($request)
    {

    }
    // 立即領獎
    private function gift($request)
    {

    }
    // 綁定
    private function wing_gift($request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        // 非新手或回歸玩家
        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $_COOKIE['StrID']);
        $result = $res->getBody();
        $result = json_decode($result);
        // 確認是否有登入過
        if ($result->data < 0) {
            return response()->json([
                'status' => -98,
            ]);
        }
        // 未登入
        if (!($_COOKIE['StrID'])) {
            return response()->json([
                'status' => -96,
            ]);
        }
        // 判斷是否購買過
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
        $result = $res->getBody();
        $result = json_decode($result);
        $setDay = Carbon::now()->format('Ymd');
        $client = new Client();
        $data = [
            "startDate" => 20240326,
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
        $vipItem = ['白金之翼(30日)'];
        $buy = false;
        for ($i = 0; $i < 6; $i++) {
            if (isset($result->data->list->{20240326 + $i})) {
                foreach ($result->data->list->{20240326 + $i} as $value_2) {
                    if ($buy == true) {
                        break;
                    }
                    if ($value_2->logName == 'consumption') {
                        // 檢查是否VIP道具
                        foreach ($vipItem as $value_3) {
                            if (strpos($value_2->itemName, $value_3) !== false) {
                                $buy = true;
                                break;
                            }
                        }
                    }
                }
            }
        }
        for ($i = 0; $i < 31; $i++) {
            if (isset($result->data->list->{20240401 + $i})) {
                foreach ($result->data->list->{20240401 + $i} as $value_2) {
                    if ($buy == true) {
                        break;
                    }
                    if ($value_2->logName == 'consumption') {
                        // 檢查是否VIP道具
                        foreach ($vipItem as $value_3) {
                            if (strpos($value_2->itemName, $value_3) !== false) {
                                $buy = true;
                                break;
                            }
                        }
                    }
                }
            }
        }
        if ($buy == false) {
            return response()->json([
                'status' => -98,
            ]);
        } else {
            // $client = new Client();
            // $data = [
            //     "userId" => $user,
            //     "itemIdx" => $itemIdx,
            //     "itemOpt" => 1190,
            //     "durationIdx" => $durationIdx,
            //     "prdId" => $prdId,
            //     'tranNo' => $tranNo,
            // ];
            $newGetLog = new event240403GetLog();
            $newGetLog->user = $_COOKIE['StrID'];
            $newGetLog->ip = $real_ip;
            $newGetLog->server_id = 0;
            $newGetLog->gift = 'VIP啟動道具：白金之翼(30日';
            $newGetLog->save();

            $info = json_decode($check['info']);
            if (count($info) > 0) {
                foreach ($info as $value) {
                    $findUser = Event20240403User::where('server_01_code', $value)->orWhere('server_02_code', $value)->first();
                    if ($findUser) {
                        $client = new Client();
                        $data = [
                            "masterId" => 126,
                            "userId" => $findUser['user_id'],
                        ];
                        $headers = [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ];
                        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/coupon/master/give', [
                            'headers' => $headers,
                            'json' => $data,
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 1,
            ]);
        }

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
