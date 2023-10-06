<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\CCU_PerTime;
class CCUController extends Controller
{
    public function update_cbo_ccu()
    {
        $client = new Client(['verify' => false]);
        $res = $client->request('GET', 'http://c1twapi.global.estgames.com/statistics/server/getCCUPerTime?fromDate='.date("Y/m/d").'&toDate='.date("Y/m/d"));
        //$res = $client->request('GET', 'http://c1twapi.global.estgames.com/statistics/server/getCCUPerTime?fromDate=2023/09/01&toDate='.date("Y/m/d"));
        $result = $res->getBody();
        $result = json_decode($result);

        foreach ($result as $ccu_lists) {
            //echo $ccu_lists->serverName.' '.$ccu_lists->regDate.' '.$ccu_lists->hour.' '.$ccu_lists->maxCCU.'<br>';
            if($ccu_lists->hour < 10) {
                $ccu_time = $ccu_lists->regDate.' 0'.$ccu_lists->hour.':00:00';
            } else {
                $ccu_time = $ccu_lists->regDate.' '.$ccu_lists->hour.':00:00';
            }

            $find_log = CCU_PerTime::where('ccu_time', $ccu_time)->count();

            if($ccu_lists->serverName == '黑恆星') {
                $ccu_s2 = $ccu_lists->maxCCU;
                if($find_log == 0) {
                    $log_save = new CCU_PerTime();
                    $log_save->ccu_time = $ccu_time;
                    $log_save->ccu_s2 = $ccu_s2;
                    $log_save->save();
                } else {
                    CCU_PerTime::where('ccu_time', $ccu_time)->update(array('ccu_s2' => $ccu_s2));
                }
            }

            if($ccu_lists->serverName == '冰珀星') {
                $ccu_s1 = $ccu_lists->maxCCU;
                if($find_log == 0) {
                    $log_save = new CCU_PerTime();
                    $log_save->ccu_time = $ccu_time;
                    $log_save->ccu_s1 = $ccu_s1;
                    $log_save->save();
                } else {
                    CCU_PerTime::where('ccu_time', $ccu_time)->update(array('ccu_s1' => $ccu_s1));
                }
            }
        }
    }
}