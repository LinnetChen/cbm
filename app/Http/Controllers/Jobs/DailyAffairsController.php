<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use App\Models\giftContent;
use App\Models\giftGetLog;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Log;

class DailyAffairsController extends Controller
{
    // public function getChangePoint(){
    //     Log::info('有進來排程');
    //         $client = new Client();
    //         $res = $client->request('POST', 'https://digeam.com/api/get_rco_change_log');
    //         $result = $res->getBody();
    //         $result = json_decode($result);
    //         foreach ($result as $value){
    //             $check = changeLogRecord::where('user_id',$value->user_id)->where('c_point',$value->c_point)->where('created_at',$value->created_at)->first();
    //             if(!$check){
    //                 $new = new changeLogRecord();
    //                 $new->user_id =$value->user_id;
    //                 $new->c_point = $value->c_point;
    //                 $new->cb_point = $value->cb_point;
    //                 $new->created_at = $value->created_at;
    //                 $new->updated_at = $value->created_at;
    //                 $new->save();
    //             }
    //         }
    // }
    public function upgrade_cbo_news()
    {
        Log::info('有進來新聞排程更新');
        $client = new Client();
        $res = $client->request('POST', 'https://digeam.com/api/get_cbo_news');
    }
    public function send_cbo_cash_reward()
    {
        $checkItem = giftGetLog::where('is_send', 'n')->get();
        foreach ($checkItem as $result) {
            $check_already = giftGetLog::where('user', $result['user'])->where('gift', $result['gift'])->where('tranNo', $result['tranNo'])->where('is_send', 'y')->first();
            if (!$check_already) {
                $getItem = giftContent::where('gift_group_id', $result['gift'])->get();
                foreach ($getItem as $value) {
                    $count_number_log = giftGetLog::count();
                    $tranNo = 'gift-' . $result['gift'] . '-' . $count_number_log . date('YmdHis');
                    $client = new Client();
                    $data = [
                        "userId" => $result['user'],
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
                    $updateLog = giftGetLog::where('user', $result['user'])->where('gift', $result['gift'])->where('gift_item', $value['title'])->where('is_send', 'n')->first();
                    $updateLog->is_send = 'y';
                    $updateLog->save();
                }
            } else {
                // 組合發獎
                if ($check_already->is_send != 'y') {
                    $check_already->is_send = '已有派發過一次獎勵';
                    $check_already->save();
                }
            }
        }
        // $getItem = giftGetLog::where('gift_group_id', $gift_id)->get();

    }
    public function send_cbo_active_reward()
    {
        $checkItem = giftGetLog::where('type', 'cash')->where('is_send', 'n')->get();
        foreach ($checkItem as $result) {
            $check_already = giftGetLog::where('user', $result['user'])->where('gift', $result['gift'])->where('tranNo', $result['tranNo'])->where('is_send', 'y')->first();
            if (!$check_already) {
                $getItem = giftContent::where('gift_group_id', $result['gift'])->get();
                foreach ($getItem as $value) {
                    $client = new Client(['verify' => false]);
                    $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/userNum?userId=' . $result['user']);
                    $reqbody = $res->getBody();
                    $reqbody = json_decode($reqbody);
                    if ($reqbody->data) {
                        $client = new Client();
                        $data = [
                            "userNum" => $reqbody->data,
                            "deliveryTime" => $value['deliveryTime'],
                            "expirationTime" => $value['expirationTime'],
                            "itemKind" => $value['itemKind'],
                            "itemOption" => $value['itemOption'],
                            "itemPeriod" => $value['itemPeriod'],
                            "count" => $value['count'],
                            "title" => $value['title'],
                            "serverIdx" => $value['serverIdx'],
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
                        // 撰寫紀錄
                        $updateLog = giftGetLog::where('user', $result['user'])->where('gift', $result['gift'])->where('gift_item', $value['title'])->where('is_send', 'n')->first();
                        $updateLog->is_send = 'y';
                        $updateLog->save();
                    } else {
                        // 撰寫紀錄
                        $updateLog = giftGetLog::where('user', $result['user'])->where('gift', $result['gift'])->where('gift_item', $value['title'])->where('is_send', 'n')->first();
                        $updateLog->is_send = '找不到userNum';
                        $updateLog->save();
                    }
                }
            } else {
                // 組合發獎
                if ($check_already->is_send != 'y') {
                    $check_already->is_send = '已有派發過一次獎勵';
                    $check_already->save();
                }
            }
        }
    }
}
