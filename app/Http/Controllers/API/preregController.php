<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MsgBoard;
use App\Models\PreregUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class preregController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'login') {
            $result = preregController::login($request);
            return $result;
        } else if ($request->type == 'reserve') {
            $result = preregController::reserve($request);
            return $result;
        } else if ($request->type == 'post') {
            $result = preregController::post($request);
            return $result;
        } else if ($request->type == 'refresh') {
            $result = preregController::login($request);
            return $result;
        }
    }

    public function login($request)
    {
        $postBoard_temp = MsgBoard::select('post_name','post_txt')->where([['is_show', '=', 'Y'],['user_id', '<>', $request->user]])->inRandomOrder()->limit(11)->get();
        $checkMsg = MsgBoard::where([['is_show', '=', 'Y'],['user_id', '=', $request->user]])->first();
        if (!$checkMsg) {
            $postBoard[0]['post_name'] = $postBoard[0]['post_txt'] = '';
        } else {
            $postBoard[0]['post_name'] = $checkMsg->post_name;
            $postBoard[0]['post_txt'] = $checkMsg->post_txt;
        }
        
        $i = 1;
        foreach ($postBoard_temp as $key) {
            $postBoard[$i]['post_name'] = $key->post_name;
            $postBoard[$i]['post_txt'] = $key->post_txt;
            $i++;
        }
        if ($request->user == null) {
            return response()->json([
                'status' => -99,
                'postBoard' => $postBoard,
            ]);
        }
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $checkUser = PreregUser::where('user_id', $request->user)->first();
        if (!$checkUser) {
            $reserve = false;
        } else {
            $reserve = true;
        }

        return response()->json([
            'status' => 1,
            'postBoard' => $postBoard,
            'reserve' => $reserve,
        ]);
    }

    public function reserve($request)
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
        if (($request->phone == null)||($request->phone == '')) {
            return response()->json([
                'status' => -98,
            ]);
        }
        $checkPhoneAlreadyUser = PreregUser::where('mobile', $request->phone)->first();
        if ($checkPhoneAlreadyUser) {
            return response()->json([
                'status' => -96,
            ]);
        }
        $findUser = PreregUser::where('user_id', $request->user)->first();
        if ($findUser) {
            return response()->json([
                'status' => -97,
            ]);
        }

        $newUser = new PreregUser();
        $newUser->user_id = $request->user;
        $newUser->mobile = $request->phone;
        $newUser->user_ip = $real_ip;
        $newUser->save();
        return response()->json([
            'status' => 1,
        ]);
    }

    public function post($request)
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
        if ($request->post_name == null) {
            return response()->json([
                'status' => -98,
            ]);
        }
        if ($request->post_txt == null) {
            return response()->json([
                'status' => -97,
            ]);
        }
        $findUser = PreregUser::where('user_id', $request->user)->first();
        if (!$findUser) {
            return response()->json([
                'status' => -96,
            ]);
        }
        $findMsg = MsgBoard::where('user_id', $request->user)->first();
        if ($findMsg) {
            return response()->json([
                'status' => -95,
            ]);
        }

        $newMsg = new MsgBoard();
        $newMsg->user_id = $request->user;
        $newMsg->post_name = $request->post_name;
        $newMsg->post_txt = $request->post_txt;
        $newMsg->user_ip = $real_ip;
        $newMsg->save();
        return response()->json([
            'status' => 1,
        ]);
    }
}
