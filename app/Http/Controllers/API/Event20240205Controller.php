<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event240123_getlog;
use App\Models\Event240123_item;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Event20240205Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'login') {
            $result = Event20240205Controller::login($request);
        } else if ($request->type == 'pray') {
            $result = Event20240205Controller::pray($request);
        } else if ($request->type == 'bless') {
            $result = Event20240205Controller::bless($request);
        } else if ($request->type == 'history') {
            $result = Event20240205Controller::history($request);
        }
        return $result;
    }
    private function login($request)
    {
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
            ]);
        }
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $request->user);
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);
        if ($reqbody->data > 0) {
            $user_gameid = $reqbody->data;

            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/cash/get?userNum=' . $user_gameid);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);

            if ($reqbody->data) {
                $point = $reqbody->data->cash+$reqbody->data->cashBonus;
            } else {
                $point = 0;
            }
        } else {
            $point = 0;
        }
        return response()->json([
            'status' => 1,
            'point' => $point,
        ]);
    }
    // 免費
    private function pray($request)
    {
        // 沒登入
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
            ]);
        }
        $check_already = Event240123_getlog::where('user', $request->user)->where('type','pray')->whereBetween('created_at', [Carbon::now()->format('Y-m-d 10:00:00'), Carbon::now()->format('Y-m-d 10:59:59')])->first();
        if ($check_already) {
            return response()->json([
                'status' => -97,
            ]);
        }
        $setDay = Carbon::now()->format('Ymd');

        $client = new Client();
        $data = [
            "fromDate" => $setDay,
            "toDate" => $setDay,
            "userId" => $request->user,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/event/user/getUserLoginMinuteByDateRange', [
            'headers' => $headers,
            'json' => $data,
        ]);
        $result = $res->getBody();
        $result = json_decode($result);
        // 登入時間不夠
        if ($result->code == -1) {
            return response()->json([
                'status' => -98,
                'accumulated' => 0,
            ]);
        } else if ($result->code == 0 && $result->data < 60) {
            return response()->json([
                'status' => -98,
                'accumulated' => $result->data,
            ]);
        }

        $send = Event20240205Controller::sendCoupon($request, 'pray');
        return $send;
    }
    // 付費
    private function bless($request)
    {
        // 沒登入
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
            ]);
        }
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $request->user);
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);
        if ($reqbody->data > 0) {
            $user_gameid = $reqbody->data;

            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/cash/get?userNum=' . $user_gameid);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);

            if ($reqbody->data) {
                $point = $reqbody->data->cash;
            } else {
                $point = 0;
            }
        } else {
            $point = 0;
        }
        // 點數不足
        if ($point < 30) {
            return response()->json([
                'status' => -98,
            ]);
        }
        $send = Event20240205Controller::sendCoupon($request, 'bless');
        return $send;
    }
    // 發送優惠券
    private function sendCoupon($request, $type)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        if ($type == 'pray') {
            $item = Event240123_item::where('pray_probability', '!=', 0)->get();
        } else {
            $item = Event240123_item::get();
        }

        $min = 0;
        $max = 100;
        for ($i = 1; $i <= 10000; $i++) {
            $target = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        }
        $item_probability_count = 0;
        foreach ($item as $key => $value) {
            if ($type == 'pray') {
                $item_probability_count += $value['pray_probability'];
            } else {
                $item_probability_count += $value['probability'];
            }
            if ($item_probability_count > $target) {
                $get = $value;
                break;
            };
        }
        $client = new Client();
        $data = [
            "masterId" => $get['master_id'],
            "userId" => $request->user,
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        $res = $client->request('POST', 'http://c1twapi.global.estgames.com/coupon/master/give', [
            'headers' => $headers,
            'json' => $data,
        ]);

        // 免費道具設定
        if ($type == 'pray') {
            $setDay = Carbon::now()->format('YmdHis');
            // if ($setDay > '20240206000000' && $setDay < '20240206235959') {
            //     $item = '貝拉德里克斯的加護x10';
            //     $itemIdx = 6500;
            //     $itemOpt = 10;
            //     $duration = 0;
            // } elseif ($setDay > '20240207000000' && $setDay < '20240207235959') {
            //     $item = '喇叭x10';
            //     $itemIdx = 6414;
            //     $itemOpt = 10;
            //     $duration = 0;
            // } elseif ($setDay > '20240208000000' && $setDay < '20240208235959') {
            //     $item = '憤怒藥水(特大)x5';
            //     $itemIdx = 7201;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240209000000' && $setDay < '20240209235959') {
            //     $item = '[服裝]賀歲龍袍護肩(7D)x1';
            //     $itemIdx = 5319;
            //     $itemOpt = 5;
            //     $duration = 1695215768;
            //     $prdId = 1288;
            // } elseif ($setDay > '20240210000000' && $setDay < '20240210235959') {
            //     $item = 'GM的祝福(Lv.4)聖水x5';
            //     $itemIdx = 33560062;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240211000000' && $setDay < '20240211235959') {
            //     $item = '英雄聖水(30分鐘)x5';
            //     $itemIdx = 33560062;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240212000000' && $setDay < '20240212235959') {
            //     $item = '戰士聖水(30分)x5';
            //     $itemIdx = 7191;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240213000000' && $setDay < '20240213235959') {
            //     $item = '賢者聖水(30分)x5';
            //     $itemIdx = 7192;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240214000000' && $setDay < '20240214235959') {
            //     $item = '最高級復活結晶x5';
            //     $itemIdx = 33559144;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240215000000' && $setDay < '20240215235959') {
            //     $item = 'AP儲存箱(50/50)x1';
            //     $itemIdx = 7288;
            //     $itemOpt = 3276850;
            //     $duration = 0;
            // } elseif ($setDay > '20240216000000' && $setDay < '20240216235959') {
            //     $item = '抵抗聖水(30分鐘)x5';
            //     $itemIdx = 33560262;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240217000000' && $setDay < '20240217235959') {
            //     $item = '英雄的召喚x5';
            //     $itemIdx = 6449;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240218000000' && $setDay < '20240218235959') {
            //     $item = '英雄的跳躍x5';
            //     $itemIdx = 7271;
            //     $itemOpt = 5;
            //     $duration = 0;
            // } elseif ($setDay > '20240219000000' && $setDay < '20240219235959') {
            //     $item = '工匠的特效藥(300)x1';
            //     $itemIdx = 7933;
            //     $itemOpt = 300;
            //     $duration = 0;
            // } elseif ($setDay > '20240220000000' && $setDay < '20240220235959') {
            //     $item = '祝福寶珠-特級(1D)x1';
            //     $itemIdx = 33559475;
            //     $itemOpt = 5;
            //     $duration = 1207959552;
            // }
            if ($setDay > '20240131100000' && $setDay < '20240131105959') {
                $item = '貝拉德里克斯的加護x10';
                $itemIdx = 6500;
                $itemOpt = 10;
                $duration = 0;
            } elseif ($setDay > '20240131110000' && $setDay < '20240131115959') {
                $item = '喇叭x10';
                $itemIdx = 6414;
                $itemOpt = 10;
                $duration = 0;
            } elseif ($setDay > '20240131120000' && $setDay < '20240131125959') {
                $item = '憤怒藥水(特大)x5';
                $itemIdx = 7201;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240131130000' && $setDay < '20240131135959') {
                $item = '[服裝]賀歲龍袍護肩(7D)x1';
                $itemIdx = 5319;
                $itemOpt = 5;
                $duration = 1695215768;
                $prdId = 1288;
            } elseif ($setDay > '20240131140000' && $setDay < '20240131145959') {
                $item = 'GM的祝福(Lv.4)聖水x5';
                $itemIdx = 33560062;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240131150000' && $setDay < '20240131155959') {
                $item = '英雄聖水(30分鐘)x5';
                $itemIdx = 33560062;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240131160000' && $setDay < '20240131165959') {
                $item = '戰士聖水(30分)x5';
                $itemIdx = 7191;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240131170000' && $setDay < '20240131175959') {
                $item = '賢者聖水(30分)x5';
                $itemIdx = 7192;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240131180000' && $setDay < '20240131185959') {
                $item = '最高級復活結晶x5';
                $itemIdx = 33559144;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240201120000' && $setDay < '20240201125959') {
                $item = 'AP儲存箱(50/50)x1';
                $itemIdx = 7288;
                $itemOpt = 3276850;
                $duration = 0;
            } elseif ($setDay > '20240201130000' && $setDay < '20240201135959') {
                $item = '抵抗聖水(30分鐘)x5';
                $itemIdx = 33560262;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240201140000' && $setDay < '20240201145959') {
                $item = '英雄的召喚x5';
                $itemIdx = 6449;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240201150000' && $setDay < '20240201155959') {
                $item = '英雄的跳躍x5';
                $itemIdx = 7271;
                $itemOpt = 5;
                $duration = 0;
            } elseif ($setDay > '20240201160000' && $setDay < '20240201165959') {
                $item = '工匠的特效藥(300)x1';
                $itemIdx = 7933;
                $itemOpt = 300;
                $duration = 0;
            } elseif ($setDay > '20240201170000' && $setDay < '20240201175959') {
                $item = '祝福寶珠-特級(1D)x1';
                $itemIdx = 33559475;
                $itemOpt = 5;
                $duration = 1207959552;
            } else {
                $item = '祝福寶珠-特級(1D)x1';
                $itemIdx = 33559475;
                $itemOpt = 5;
                $duration = 1207959552;
            }
            $prdId = 1288;
        } else {
            // 付費道具設定
            if ($get['master_id'] >= 81 && $get['master_id'] <= 92) {
                $item = 'GM的祝福(Lv.3)聖水';
                $itemIdx = 33555598;
                $itemOpt = 1;
                $duration = 0;
                $prdId = 1474;
            } elseif ($get['master_id'] >= 93 && $get['master_id'] <= 98) {
                $item = 'GM的祝福(Lv.4)聖水';
                $itemIdx = 33555966;
                $itemOpt = 1;
                $duration = 0;
                $prdId = 1475;
            } elseif ($get['master_id'] >= 99 && $get['master_id'] <= 113) {
                $item = 'GM的祝福(Lv.2)聖水';
                $itemIdx = 33555597;
                $itemOpt = 1;
                $duration = 0;
                $prdId = 1473;
            } elseif ($get['master_id'] >= 114 && $get['master_id'] <= 120) {
                $item = 'GM的祝福(Lv.5)聖水';
                $itemIdx = 33557391;
                $itemOpt = 1;
                $duration = 0;
                $prdId = 1476;
            }
        }
        // 發送道具
        $count_number_log = Event240123_getlog::count();
        $tranNo = 'event240205-' . 0 . '-' . $count_number_log . date('YmdHis');
        $client = new Client();
        $data = [
            "userId" => $request->user,
            "itemIdx" => $itemIdx,
            "itemOpt" => $itemOpt,
            "durationIdx" => $duration,
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

        $newLog = new Event240123_getlog();
        $newLog->user = $request->user;
        $newLog->item = $item;
        $newLog->coupon = $get['title'];
        $newLog->ip = $real_ip;
        $newLog->type = $type;
        $newLog->coupon_deadline = Carbon::now()->addHours(72);
        $newLog->save();

        return response()->json([
            'status' => 1,
            'item_name' => $item,
            'coupon_name' => $get['title'],
        ]);

    }
    // 查紀錄
    private function history($request)
    {
        // 未登入
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
            ]);
        }
        $result = Event240123_getlog::select('coupon', 'item', 'coupon_deadline')->where('user', $request->user)->where('type', $request->history_type)->orderby('created_at', 'asc')->get();
        return response()->json([
            'status' => 1,
            'list' => $result,
        ]);
    }
}
