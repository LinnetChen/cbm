<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event231220_item;
use App\Models\Event231220_buylog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Event231220Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'login') {
            $result = Event231220Controller::login($request);
            return $result;
        } else if ($request->type == 'buy') {
            $result = Event231220Controller::buy($request);
            return $result;
        } else if ($request->type == 'buy_recode') {
            $result = Event231220Controller::buy_recode($request);
            return $result;
        }
    }

    public function login($request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        if((date('Ymd') >= '20231220')&&(date('Ymd') <= '20231225')) {
            if((date('His') >= '180000')&&(date('His') < '220000')) {
                $time = 'y';
            } else {
                $time = 'n';
            }
        } else {
            $time = 'n';
        }

        if($time == 'n') {
            $ice_iteminfo = null;
            $black_iteminfo = null;
            $iteminfo = null;
        } else {
            $item_list = Event231220_item::where([['start_date', '<=', date('Y-m-d H:i:s')],['end_date', '>', date('Y-m-d H:i:s')]])->orderby('id')->get();
            $i = 0;
            $j = 0;
            foreach ($item_list as $key) {
                if($key->server_id == 1) {
                    $ice_iteminfo[$i]['id'] = $key->productID;
                    $ice_iteminfo[$i]['price'] = $key->price;
                    $buy_cnt = Event231220_buylog::where([['created_at', '>=', date('Y-m-d').' 18:00:00'],['created_at', '<=', date('Y-m-d').' 22:00:00'],['server_id', '=', 1],['productID', '=', $key->productID]])->count();
                    $ice_iteminfo[$i]['quantity'] = $key->limit_cnt - $buy_cnt;
                    $i++;
                }
                if($key->server_id == 2) {
                    $black_iteminfo[$j]['id'] = $key->productID;
                    $black_iteminfo[$j]['price'] = $key->price;
                    $buy_cnt = Event231220_buylog::where([['created_at', '>=', date('Y-m-d').' 18:00:00'],['created_at', '<=', date('Y-m-d').' 22:00:00'],['server_id', '=', 2],['productID', '=', $key->productID]])->count();
                    $black_iteminfo[$j]['quantity'] = $key->limit_cnt - $buy_cnt;
                    $j++;
                }
                if($key->server_id == 0) {
                    $iteminfo = $key->productID;
                }
            }
        }

        if ($request->user == null) {
            return response()->json([
                'status' => -99,
                'time' => $time,
                'ice_iteminfo' => $ice_iteminfo,
                'black_iteminfo' => $black_iteminfo,
                'iteminfo_1' => $iteminfo,
            ]);
        } else {
            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId='.$request->user);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);

            if($reqbody->data > 0) {
                $user_gameid = $reqbody->data;

                $client = new Client(['verify' => false]);
                $res = $client->request('GET', 'http://c1twapi.global.estgames.com/cash/get?userNum='.$user_gameid);
                $reqbody = $res->getBody();
                $reqbody = json_decode($reqbody);

                if($reqbody->data) {
                    $point = $reqbody->data->cash;
                } else {
                    $point = 0;
                }
            } else {
                $point = 0;
            }

            if($time == 'n') {
                $itemsell = 'n';
            } else {
                $buy_cnt = Event231220_buylog::where([['created_at', '>=', date('Y-m-d H').':00:00'],['created_at', '<=', date('Y-m-d H').':59:59'],['user_id', '=', $request->user],['productID', '=', $iteminfo]])->count();
                if($buy_cnt > 0) {
                    $itemsell = 'n';
                } else {
                    $itemsell = 'y';
                }
            }

            return response()->json([
                'status' => 1,
                'time' => $time,
                'point' => $point,
                'ice_iteminfo' => $ice_iteminfo,
                'black_iteminfo' => $black_iteminfo,
                'iteminfo_1' => $iteminfo,
                'itemsell_1' => $itemsell,
            ]);
        }
    }

    public function buy($request)
    {
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
            ]);
        }

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        if((date('Ymd') >= '20231220')&&(date('Ymd') <= '20231225')) {
            if((date('His') >= '180000')&&(date('His') < '220000')) {
                $time = 'y';
            } else {
                $time = 'n';
            }
        } else {
            $time = 'n';
        }
        if($time == 'n') {
            return response()->json([
                'status' => -96,
            ]);
        }

        $item_info = Event231220_item::where([['start_date', '<=', date('Y-m-d H:i:s')],['end_date', '>', date('Y-m-d H:i:s')],['productID', '=', $request->buy_item]])->first();
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId='.$request->user);
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);

        if($reqbody->data > 0) {
            $user_gameid = $reqbody->data;

            $client = new Client(['verify' => false]);
            $res = $client->request('GET', 'http://c1twapi.global.estgames.com/cash/get?userNum='.$user_gameid);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);

            if($reqbody->data) {
                $point = $reqbody->data->cash;
            } else {
                $point = 0;
            }
        } else {
            $point = 0;
        }

        if ($point < $item_info->price) {
            return response()->json([
                'status' => -98,
            ]);
        }

        if($item_info->server_id != 0) {
            $buy_cnt = Event231220_buylog::where([['created_at', '>=', date('Y-m-d').' 18:00:00'],['created_at', '<=', date('Y-m-d').' 22:00:00'],['productID', '=', $item_info->productID]])->count();
            if ($buy_cnt >= $item_info->limit_cnt) {
                return response()->json([
                    'status' => -97,
                ]);
            }
        } else {
            $buy_cnt = Event231220_buylog::where([['created_at', '>=', date('Y-m-d H').':00:00'],['created_at', '<=', date('Y-m-d H').':59:59'],['user_id', '=', $request->user],['productID', '=', $item_info->productID]])->count();
            if ($buy_cnt > 0) {
                return response()->json([
                    'status' => -97,
                ]);
            }
        }

        $tranNo = 'event-231220-' . date('YmdHis');
        $client = new Client();
        $data = [
            "userId" => $request->user,
            "itemIdx" => $item_info->itemID,
            "itemOpt" => $item_info->option,
            "durationIdx" => $item_info->duration,
            "prdId" => $item_info->prdid,
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

        $BuyLogAdd = new Event231220_buylog();
        $BuyLogAdd->user_id = $request->user;
        $BuyLogAdd->server_id = $item_info->server_id;
        $BuyLogAdd->productID = $item_info->productID;
        $BuyLogAdd->itemname = $item_info->itemName;
        $BuyLogAdd->itemID = $item_info->itemID;
        $BuyLogAdd->option = $item_info->option;
        $BuyLogAdd->price = $item_info->price;
        $BuyLogAdd->user_ip = $real_ip;
        $BuyLogAdd->save();
        return response()->json([
            'status' => 1,
        ]);
    }

    public function buy_recode($request)
    {
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
            ]);
        }
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        $buy_log = Event231220_buylog::where([['user_id', '=', $request->user]])->orderby('created_at','desc')->get();
        $i = 0;
        $list = null;
        foreach ($buy_log as $key) {
            $list[$i]['name'] = $key->itemname;
            $list[$i]['price'] = $key->price;
            if($key->server_id == 1) {
                $list[$i]['server'] = '冰珀星';
            }
            if($key->server_id == 2) {
                $list[$i]['server'] = '黑恆星';
            }
            if($key->server_id == 0) {
                $list[$i]['server'] = '共通';
            }
            $list[$i]['date'] = date('Y-m-d H:i:s',strtotime($key->created_at));
            $i++;
        }
        return response()->json([
            'status' => 1,
            'list' => $list,
        ]);
    }
}
