<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
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
}
