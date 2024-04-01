<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event240403BindingLog;
use App\Models\event240403GetLog;
use App\Models\Event20240403User;
use App\Models\giftGetLog;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
        } elseif ($request->type == 'skill_get_gift') {
            $result = Event20240403Controller::skill_get_gift($request);
        } else {
            return 0;
        }

        return $result;
    }
    // 判斷登入
    private function login($request)
    {
        if (isset($request->user)) {
            $_COOKIE['StrID'] = $request->user;
        }

        if (!isset($_COOKIE['StrID'])) {
            return response()->json([
                'status' => -99,
            ]);
        }
        // 確認是否有資料
        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        if ($check) {
            $client = new Client(['verify' => false]);
            $res = $client->request('POST', 'https://digeam.com/api/get_cbo_user_login?user=' . $_COOKIE['StrID']);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);
            $user_type = $reqbody->status;
            if ($check->user_type == 'not_player' && $check->user_type != $user_type) {
                $check->user_type = $user_type;
                $check->user_type->save();
                $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
            }
        } else {
            // 第一次進入頁面,判斷玩家類型
            // 以下待上線後撰寫搜尋login DB
            $client = new Client(['verify' => false]);
            $res = $client->request('POST', 'https://digeam.com/api/get_cbo_user_login?user=' . $_COOKIE['StrID']);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);
            $user_type = $reqbody->status;
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
    // private function qualify($request)
    // {

    //     $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
    //     if ($check['user_type'] == 'skillful') {
    //         return response()->json([
    //             'status' => -99,
    //         ]);
    //     }
    //     $info = json_decode($check['info']);
    //     if (count($info) >= 3) {
    //         return response()->json([
    //             'status' => -98,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 1,
    //         ]);
    //     }
    // }
    // 綁定
    private function binding($request)
    {

        if (isset($request->user)) {
            $_COOKIE['StrID'] = $request->user;
        }

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        // 還不是玩家
        if ($check['user_type'] == 'not_player') {
            return response()->json([
                'status' => -90,
            ]);
        }

        $info = json_decode($check['info']);
        if (count($info) >= 3) {
            return response()->json([
                'status' => -99,
            ]);
        }

        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -94,
            ]);
        }
        // 確認是否被綁定
        $checkAlreadyUse = Event240403BindingLog::where('binding', $request->binding_id)->first();
        if ($checkAlreadyUse) {
            return response()->json([
                'status' => -98,
            ]);
        }
        // 確認綁定碼是否正確
        $checkBinding = Event20240403User::where('server_01_code', $request->binding_id)->orWhere('server_02_code', $request->binding_id)->first();
        if (!$checkBinding) {
            return response()->json([
                'status' => -97,
            ]);
        }
        // 確認該玩家以被綁定過
        $check_skill = Event240403BindingLog::wherein('binding', [$checkBinding->server_01_code, $checkBinding->server_02_code])->first();
        if ($check_skill) {
            return response()->json([
                'status' => -98,
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
        $checkBinding->save();
        $info[count($info)] = $request->binding_id;
        $check->info = $info;
        $check->save();

        $newBindingLog = new Event240403BindingLog();
        $newBindingLog->user = $_COOKIE['StrID'];
        $newBindingLog->server_id = $request->server_id;
        $newBindingLog->binding = $request->binding_id;
        $newBindingLog->ip = $real_ip;
        $newBindingLog->save();

        Event20240403Controller::binding_gift($_COOKIE['StrID'], $request->binding_id, $real_ip);

        return response()->json([
            'status' => 1,
        ]);
    }
    // 立即領獎
    // private function send_gift($request)
    // {
    //     $send_result = ['n', 'n', 'n', 'n', 'n'];
    //     $check_gift_record_1 = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift01')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::tomorrow()->format('Y-m-d 23:59:59')])->first();
    //     $check_gift_record_2 = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift02')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::tomorrow()->format('Y-m-d 23:59:59')])->first();
    //     $check_gift_record_3 = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift03')->first();
    //     $check_gift_record_4 = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift04')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::tomorrow()->format('Y-m-d 23:59:59')])->first();
    //     $check_gift_record_5 = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift05')->first();
    //     $check_gift_record_6 = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift06')->first();
    //     if ($check_gift_record_1) {
    //         $send_result[0] = 'y';
    //     }
    //     if ($check_gift_record_2) {
    //         $send_result[1] = 'y';
    //     }
    //     if ($check_gift_record_3) {
    //         $send_result[2] = 'y';
    //     }
    //     if ($check_gift_record_4) {
    //         $send_result[3] = 'y';
    //     }
    //     if ($check_gift_record_5) {
    //         $send_result[4] = 'y';
    //     }
    //     if ($check_gift_record_6) {
    //         $send_result[5] = 'y';
    //     }
    //     return response()->json([
    //         'status' => 1,
    //         'send_result ' => $send_result,
    //     ]);
    // }
    // 立即領獎
    private function gift($request)
    {
        if (isset($request->user)) {
            $_COOKIE['StrID'] = $request->user;
        }

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        $hasGuild = false;
        $send = false;
        $login = false;
        $max_level = 0;

        // 非新手或回歸玩家
        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        // 還不是玩家
        if ($check['user_type'] == 'not_player') {
            return response()->json([
                'status' => -90,
            ]);
        }
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }
        // 確認伺服器
        if ($request->server_id == 'server00') {
            return response()->json([
                'status' => -97,
            ]);
        } elseif ($request->server_id != 'server01' && $request->server_id != 'server02') {
            return response()->json([
                'status' => -97,
            ]);
        }
        // 確認是否有角色
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/game/character/searchByCharacterId?userId=' . $_COOKIE['StrID'] . '&serverCode=' . $request->server_id);
        $check_char = $res->getBody();
        $check_char = json_decode($check_char);
        if (count($check_char->data) <= 0) {
            return response()->json([
                'status' => -96,
            ]);
        } else {
            foreach ($check_char->data as $value) {
                if (json_encode($value->guildName) != 'null') {
                    $hasGuild = true;
                }
                if (json_encode($value->lev) > $max_level) {
                    $max_level = json_encode($value->lev);
                }
            }
        }

        // 確認是否登入
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
        $check_login = $res->getBody();
        $check_login = json_decode($check_login);
        if ($check_login->data->Login == 1) {
            $login = 1;
        }
        // 確認消費

        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=' . $_COOKIE['StrID']);
        $result = $res->getBody();
        $result = json_decode($result);
        $client = new Client();
        $data = [
            "startDate" => Carbon::yesterday()->format('Ymd'),
            "endDate" => Carbon::now()->format('Ymd'),
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
        if (!isset($result->data->list->{Carbon::now()->format('Ymd')}) && !isset($result->data->list->{Carbon::yesterday()->format('Ymd')})) {
            $buy = false;
        } else {
            foreach ($result->data->list->{Carbon::now()->format('Ymd')} as $value) {
                if ($value['logDate'] == Carbon::now()->format('Ymd')) {
                    if ($value['logDateTime'] > Carbon::now()->format('Y-m-d 06:00')) {
                        $buy = true;
                    }
                }
                if ($value['logDate'] == Carbon::yesterday()->format('Ymd')) {
                    if ($value['logDateTime'] > Carbon::yesterday()->format('Y-m-d 06:00')) {
                        $buy = true;
                    }
                }
            }
        }

        // 邏輯撰寫
        if ($request->gift_id == 'gift01') {
            $check_gift_record = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift01')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::tomorrow()->format('Y-m-d 23:59:59')])->first();
            if ($check_gift_record) {
                return response()->json([
                    'status' => -95,
                ]);
            } else {
                $send = true;
                $count = 30;
                $title = '簽到';
            }
        } elseif ($request->gift_id == 'gift02') {
            $check_gift_record = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift02')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 06:00:00'), Carbon::tomorrow()->format('Y-m-d 05:59:59')])->first();
            if ($check_gift_record) {
                return response()->json([
                    'status' => -95,
                ]);
            } else {
                if ($login == true) {
                    $send = true;
                    $count = 10;
                    $title = '保持在線';
                }
            }
        } elseif ($request->gift_id == 'gift03') {
            $check_gift_record = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift03')->first();
            if ($check_gift_record) {
                return response()->json([
                    'status' => -95,
                ]);
            } else {
                if ($hasGuild == true) {
                    $send = true;
                    $count = 30;
                    $title = '加入公會';
                }
            }
        } elseif ($request->gift_id == 'gift04') {
            $check_gift_record = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift04')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 06:00:00'), Carbon::tomorrow()->format('Y-m-d 05:59:59')])->first();
            if ($check_gift_record) {
                return response()->json([
                    'status' => -95,
                ]);
            } else {
                if ($buy == true) {
                    $send = true;
                    $count = 50;
                    $title = '消費';
                } else {
                    return response()->json([
                        'status' => -98,
                    ]);
                }
            }
        } elseif ($request->gift_id == 'gift05') {
            $check_gift_record = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift05')->first();
            if ($check_gift_record) {
                return response()->json([
                    'status' => -95,
                ]);
            } else {
                if ($max_level >= 100) {
                    $send = true;
                    $count = 50;
                    $title = '達到100級';
                } else {
                    return response()->json([
                        'status' => -98,
                    ]);
                }
            }
        } elseif ($request->gift_id == 'gift06') {
            $check_gift_record = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'gift06')->first();
            if ($check_gift_record) {
                return response()->json([
                    'status' => -98,
                ]);
            } else {
                if ($max_level >= 170) {
                    $send = true;
                    $count = 80;
                    $title = '達到170級';
                } else {
                    return response()->json([
                        'status' => -98,
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => -99,
            ]);
        }

        if ($send == true) {
            if ($request->server_id == 'server01') {
                $server = 1;
            } else {
                $server = 2;
            }

            $a = Event20240403Controller::skill_get_gift($_COOKIE['StrID'], $request->gift_id, $real_ip);
            $newGetLog = new event240403GetLog();
            $newGetLog->user = $_COOKIE['StrID'];
            $newGetLog->ip = $real_ip;
            $newGetLog->server_id = $request->server_id;
            $newGetLog->gift = $request->gift_id;
            $newGetLog->save();

            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $_COOKIE['StrID']);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);

            $client = new Client();
            $data = [
                "userNum" => $reqbody->data,
                "deliveryTime" => "2024-03-01 00:00:00",
                "expirationTime" => "2024-04-30 12:00:00",
                "itemKind" => 5657,
                "itemOption" => 4198552 + ($count - 1) * 4194304,
                "itemPeriod" => 0,
                "count" => 1,
                "title" => $title,
                "serverIdx" => $server,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/user/giveItemUserEventInventoryByUserNumAndItemInfo', [
                'headers' => $headers,
                'json' => $data,
            ]);

            return response()->json([
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'status' => -99,
            ]);
        }
    }
    // 白金之翼
    private function wing_gift($request)
    {

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        // 非新手或回歸玩家
        $check = Event20240403User::where('user_id', $_COOKIE['StrID'])->first();
        // 還不是玩家
        if ($check['user_type'] == 'not_player') {
            return response()->json([
                'status' => -90,
            ]);
        }
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
        $check_get = event240403GetLog::where('user', $_COOKIE['StrID'])->where('gift', 'VIP啟動道具：白金之翼(30日')->first();
        if ($check_get) {
            return response()->json([
                'status' => -97,
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
        $vipItem = ['白金之翼30日'];
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

            $count_number_log = giftGetLog::count();
            $tranNo = 'event-' . $count_number_log . date('YmdHis');

            $client = new Client();
            $data = [
                "userId" => $_COOKIE['StrID'],
                "itemIdx" => 33559014,
                "itemOpt" => 1190,
                "durationIdx" => 17,
                "prdId" => 1288,
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
                        $newGetLog = new event240403GetLog();
                        $newGetLog->user = $findUser['user_id'];
                        $newGetLog->ip = 0;
                        $newGetLog->server_id = 0;
                        $newGetLog->gift = '白金之翼(30日)75折折扣券';
                        $newGetLog->save();

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
    private function binding_gift($user_id, $bind, $ip)
    {
        // 派送此次獎勵
        // 派獎給新手/回歸玩家
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $user_id);
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);
        $new_Item =
            [
            ['item' => 'GM的祝福(Lv3)聖水 x 10', 'id' => 33559694, 'option' => 10],
            ['item' => '指令藥水(特大) x 5', 'id' => 33560906, 'option' => 5],
            ['item' => '活力聖水 x 10', 'id' => 6434, 'option' => 10],
        ];

        for ($i = 0; $i < 3; $i++) {
            $get_server = Event240403BindingLog::where('user', $user_id)->where('binding', $bind)->first();
            if ($get_server == 'server01') {
                $server_id = 1;
            } else {
                $server_id = 2;
            }
            $newGetLog = new event240403GetLog();
            $newGetLog->user = $user_id;
            $newGetLog->ip = $ip;
            $newGetLog->server_id = 0;
            $newGetLog->gift = '新手/回歸玩家綁定禮-' . $new_Item[$i]['item'];
            $newGetLog->save();

            $client = new Client();
            $data = [
                "userNum" => $reqbody->data,
                "deliveryTime" => "2024-03-01 00:00:00",
                "expirationTime" => "2024-05-07 23:59:59",
                "itemKind" => $new_Item[$i]['id'],
                "itemOption" => $new_Item[$i]['option'],
                "itemPeriod" => 0,
                "count" => 1,
                "title" => $new_Item[$i]['item'],
                "serverIdx" => $server_id,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/user/giveItemUserEventInventoryByUserNumAndItemInfo', [
                'headers' => $headers,
                'json' => $data,
            ]);
        }

        // 派獎給活耀玩家
        $findUserskillful = Event20240403User::where('server_01_code', $bind)->orWhere('server_02_code', $bind)->first();
        if ($bind == $findUserskillful->server_01_code) {
            $server = 1;
        } else {
            $server = 2;
        }
        $skillful_Item =
            [
            ['item' => 'GM的祝福(Lv4)聖水 x 10', 'id' => 33560062, 'option' => 10],
            ['item' => '指令藥水(特大) x 5', 'id' => 33560906, 'option' => 5],
            ['item' => '神秘寶箱(稀有) x 2', 'id' => 33560451, 'option' => 2],
        ];
        // 搜尋綁定活耀玩家
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $findUserskillful->user_id);
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);
        for ($i = 0; $i < 3; $i++) {
            $newGetLog = new event240403GetLog();
            $newGetLog->user = $findUserskillful->user_id;
            $newGetLog->ip = $ip;
            $newGetLog->server_id = $server;
            $newGetLog->gift = '新手/回歸玩家綁定禮-' . $skillful_Item[$i]['item'];
            $newGetLog->save();

            $client = new Client();
            $data = [
                "userNum" => $reqbody->data,
                "deliveryTime" => "2024-03-01 00:00:00",
                "expirationTime" => "2024-05-07 23:59:59",
                "itemKind" => $skillful_Item[$i]['id'],
                "itemOption" => $skillful_Item[$i]['option'],
                "itemPeriod" => 0,
                "count" => 1,
                "title" => $skillful_Item[$i]['item'],
                "serverIdx" => $server,
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/user/giveItemUserEventInventoryByUserNumAndItemInfo', [
                'headers' => $headers,
                'json' => $data,
            ]);
        }

        // 確認玩家是否有領過白金之翼,有領過則補送coupon給後來綁定的玩家
        $check_vip = event240403GetLog::where('user', $user_id)->where('gift', 'VIP啟動道具：白金之翼(30日')->first();
        if ($check_vip) {
            $check = Event20240403User::where('user_id', $user_id)->first();
            $info = json_decode($check->info);
            foreach ($info as $value) {
                // 查找序號隸屬的活耀玩家
                $findUser = Event20240403User::where('server_01_code', $value)->orWhere('server_02_code', $value)->first();
                $check_already_get = event240403GetLog::where('user', $findUser['user_id'])->where('gift', '白金之翼(30日)75折折扣券')->first();
                if (!$check_already_get) {
                    $newGetLog = new event240403GetLog();
                    $newGetLog->user = $findUser['user_id'];
                    $newGetLog->ip = 0;
                    $newGetLog->server_id = 0;
                    $newGetLog->gift = '白金之翼(30日)75折折扣券';
                    $newGetLog->save();

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
    }
    private function skill_get_gift($user_id, $gift_id, $ip)
    {
        $check = Event20240403User::where('user_id', $user_id)->first();
        $info = json_decode($check['info']);
        // 先查看有沒有送的必要
        if (count($info) > 0) {
            switch ($gift_id) {
                case 'gift01';
                    $count = 15;
                    $title = '綁定玩家-簽到獎勵';
                    break;
                case 'gift02';
                    $count = 5;
                    $title = '綁定玩家-保持在線​';
                    break;
                case 'gift03';
                    $count = 15;
                    $title = '綁定玩家-加入公會';
                    break;
                case 'gift04';
                    $count = 25;
                    $title = '綁定玩家-消費​';
                    break;
                case 'gift05';
                    $count = 25;
                    $title = '綁定玩家-達到100級​';
                    break;
                case 'gift06';
                    $count = 40;
                    $title = '綁定玩家-達到170級​';
                    break;
            }
            foreach ($info as $value) {
                $findUserskillful = Event20240403User::where('server_01_code', $value)->orWhere('server_02_code', $value)->first();
                if ($findUserskillful) {
                    if ($findUserskillful->server_01_code == $value) {
                        $server = 1;
                    } else {
                        $server = 2;
                    }

                    $newGetLog = new event240403GetLog();
                    $newGetLog->user = $findUserskillful->user_id;
                    $newGetLog->ip = $ip;
                    $newGetLog->server_id = 'server0' . $server;
                    $newGetLog->gift = $gift_id . '-skill';
                    $newGetLog->save();

                    $client = new Client(['verify' => false]);
                    $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $findUserskillful->user_id);
                    $reqbody = $res->getBody();
                    $reqbody = json_decode($reqbody);
                    $client = new Client();
                    $data = [
                        "userNum" => $reqbody->data,
                        "deliveryTime" => "2024-03-01 00:00:00",
                        "expirationTime" => "2024-04-30 12:00:00",
                        "itemKind" => 5657,
                        "itemOption" => 4198552 + ($count - 1) * 4194304,
                        "itemPeriod" => 0,
                        "count" => 1,
                        "title" => $title,
                        "serverIdx" => $server,
                    ];

                    $headers = [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ];

                    $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/user/giveItemUserEventInventoryByUserNumAndItemInfo', [
                        'headers' => $headers,
                        'json' => $data,
                    ]);
                }
            }
        }
    }
}
