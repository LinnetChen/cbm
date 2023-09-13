<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class testController extends Controller
{
    // 獲取發獎
    public function testAPI(){
        $client = new Client();
        $data = [
            "userNum" => 327176,
            "tranNo" => 0,
            "itemIdx" => 82018,
            "itemOpt" => 160,
            "durationIdx" => 0
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
    // 獲取玩家資訊
    // public function testAPI(){
    //     $client = new Client();
    //     $res = $client->request('GET', 'http://c1twapi.global.estgames.com/user/getUserDetailByUserId?userId=neko0518');
    //     $result = $res->getBody();
    //     $result = json_decode($result);
    //     dd($result);
    // }
}
