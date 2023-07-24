<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class transferPageController extends Controller
{
    public function transfer()
    {
        $send_url = 'http://c1tw-transfer.estgames.com/accounts/transfer?region=tw&key=n24SMFS4dPvOUGQsZnoovMJhhet8BlZN';
        $client = new Client();
        $res = $client->request('POST', $send_url,
            [
                'form_params' => [
                    'userId' => 'neko0518',
                    'password' => '2min0518',
                    'subPassword' => '091015',
                    'siteId' => 'digeamkotw01',
                ],
            ]);
        $reqbody = $res->getBody();
        $reqbody = json_decode($reqbody);
        dd($reqbody);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'http://c1tw-transfer.estgames.com/accounts/transfer?region=tw&key=n24SMFS4dPvOUGQsZnoovMJhhet8BlZN');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // curl_setopt($ch, CURLOPT_POST, true);
        // $data = array(
        //     'userId' => 'neko0518',
        //     'password' => '2min0518',
        //     'subPassword' => '091015',
        //     'siteId' => 'digeamkotw01');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // $result = curl_exec($ch);
        // dd($result);
    }
}
