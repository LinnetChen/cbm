<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

class transferController extends Controller
{
    //
    public function index()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
    }
}
