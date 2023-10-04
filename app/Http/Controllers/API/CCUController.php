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
        $result = $res->getBody();
        $result = json_decode($result);

        foreach ($result as $ccu_lists) {
            echo $ccu_lists->serverName.' '.$ccu_lists->regDate.' '.$ccu_lists->hour.' '.$ccu_lists->maxCCU.'<br>';
        }
    }
}