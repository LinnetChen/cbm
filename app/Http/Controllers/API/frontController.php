<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class frontController extends Controller
{
    public function exchange(Request $request){
        dd($request,$_COOKIE);
    }
}
