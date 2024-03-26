<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event240403BindingLog;
use App\Models\Event20240403User;
use Illuminate\Http\Request;

class Event20240403Controller extends Controller
{
    public function index(Request $request)
    {

        // if ($_COOKIE['StrID']) {
        //     return response()->json([
        //         'status' => -99,
        //     ]);
        // }
        // if (!($request->user)) {
        //     return response()->json([
        //         'status' => -99,
        //     ]);
        // }
        if ($request->type == 'login') {
            $result = Event20240403Controller::login($request);
        } elseif ($request->type == 'qualify') {
            $result = Event20240403Controller::qualify($request);
        } elseif ($request->type == 'binding') {
            $result = Event20240403Controller::binding($request);
        } elseif ($request->type == 'send_gift') {
            $result = Event20240403Controller::send_gift($request);
        } elseif ($request->type == 'gift') {
            $result = Event20240403Controller::gift($request);
        } elseif ($request->type == 'wing_gift') {
            $result = Event20240403Controller::wing_gift($request);
        } else {
            return 0;
        }

        return $result;
    }
    // 判斷登入
    private function login($request)
    {
        // 確認是否有資料
        $check = Event20240403User::where('user_id', $request->user)->first();
        if ($check) {

        } else {
            // 第一次進入頁面,判斷玩家類型
            // 以下待上線後撰寫搜尋login DB
            $user_type = 'skillful';
            $info = [];
            // 以上待上線後撰寫搜尋login DB
            $user = new Event20240403User();
            $user->user_id = $request->user;
            $user->user_type = $user_type;
            $user->info = json_encode($info);
            if ($user_type == 'skillful') {
                $getCode = Event20240403Controller::set_code();
                $code = explode('/', $getCode);
                $user->server_01_code = $code[0];
                $user->server_02_code = $code[1];
            }
            $user->save();
        }
        $user = Event20240403User::where('user_id', $request->user)->first();
        return response()->json([
            'status' => 1,
        ]);
    }
    private function qualify($request)
    {
        $check = Event20240403User::where('user_id', $request->user)->first();
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }
        $info = json_decode($check['info']);
        if (count($info) >= 3) {
            return response()->json([
                'status' => -98,
            ]);
        } else {
            return response()->json([
                'status' => 1,
            ]);
        }
    }
    // 綁定
    private function binding($request)
    {
        $check = Event20240403User::where('user_id', $request->user)->first();
        $info = json_decode($check['info']);
        if (count($info) >= 3) {
            return response()->json([
                'status' => -99,
            ]);
        }
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }
        // 確認是否被綁定
        $checkAlreadyUse = Event240403BindingLog::where('binding', $request->binding)->first();
        if ($checkAlreadyUse) {
            return response()->json([
                'status' => -98,
            ]);
        }
        // 確認綁定碼是否正確
        if ($request->server_id == 'server01') {
            $checkBinding = Event20240403User::where('server_01_code', $request->binding)->where('user_type', 'skillful')->first();
        } else if ($request->server_id == 'server02') {
            $checkBinding = Event20240403User::where('server_02_code', $request->binding)->where('user_type', 'skillful')->first();
        } else {
            return response()->json([
                'status' => -96,
            ]);
        }
        if (!$checkBinding) {
            return response()->json([
                'status' => -97,
            ]);
        }
        // 確認伺服器
        if ($request->server_id == 'server00') {
            return response()->json([
                'status' => -96,
            ]);
        } elseif ($request->server_id != 'server01' && $request->server_id != 'server02') {
            return response()->json([
                'status' => -96,
            ]);
        }

        $info[count($info)] = $request->binding;
        $check->info = $info;
        $check->save();

        $newBindingLog = new Event240403BindingLog();
        $newBindingLog->user = $request->user;
        $newBindingLog->server_id = $request->server_id;
        $newBindingLog->binding = $request->binding;
        $newBindingLog->save();

        return response()->json([
            'status' => 1,
        ]);
    }
    // 立即領獎
    private function send_gift($request)
    {

    }
    // 立即領獎
    private function gift($request)
    {

    }
    // 綁定
    private function wing_gift($request)
    {
        $check = Event20240403User::where('user_id', $request->user)->first();
        if ($check['user_type'] == 'skillful') {
            return response()->json([
                'status' => -99,
            ]);
        }

        // if ($_COOKIE['StrID']) {
        //     return response()->json([
        //         'status' => -96,
        //     ]);
        // }

        if (!($request->user)) {
            return response()->json([
                'status' => -96,
            ]);
        }
        
    }

    // 產碼
    private function set_code()
    {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid_01 = substr($charid, 0, 4)
        . substr($charid, 4, 4)
        . substr($charid, 8, 4);

        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid_02 = substr($charid, 0, 4)
        . substr($charid, 4, 4)
        . substr($charid, 8, 4);

        return $uuid_01 . '/' . $uuid_02;
    }
}
