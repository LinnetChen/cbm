<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\transfer_user;
use App\Models\try_login_log;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class transferPageController extends Controller
{
    public function login(Request $request)
    {

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }
        //$user = 'digeamkotw01';
        $user = $request->user;
        //未登入狀態
        if ($user == '') {
            return response()->json([
                'status' => -99,
            ]);
        } else {
            $user_info = transfer_user::where('user_id', $user)->first();
            if ($user_info != '') {
                if ($user_info->cabal_id != '') {
                    return response()->json([
                        'status' => 1,
                        'cabal_status' => 1,
                        'account_locking' => $user_info->cabal_id,
                    ]);
                } else {
                    return response()->json([
                        'status' => 1,
                        'cabal_status' => -99,
                        'account_locking' => '',
                    ]);
                }
            } else {
                //建新資料
                $create_user = new transfer_user();
                $create_user->user_id = $user;
                $create_user->ip = $real_ip;
                $create_user->save();
                return response()->json([
                    'status' => 1,
                    'cabal_status' => -99,
                    'account_locking' => '',
                ]);
            }
        }
    }
    public function cabal_login(Request $request)
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $real_ip = $_SERVER["REMOTE_ADDR"];
        }

        $user = $request->user;
        $cabal_user = $request->cabal_user;
        $cabal_pwd = $request->cabal_pwd;
        $cabal_pwd2 = $request->cabal_pwd2;

        //判斷是否為鎖定帳號
        $user_info = transfer_user::where('user_id', $user)->first();
        $stime = Carbon::now();
        //鎖定時間已過
        if ($user_info->lock_time < $stime) {
            $user_info->status = 'N';
            $user_info->save();
        }
        $user_info = transfer_user::where('user_id', $user)->first();
        //鎖定時間還沒過直接回傳
        if ($user_info != '' and $user_info->lock_time > $stime) {
            $error_CD = (new Carbon)->diffInSeconds($user_info->lock_time, true);
            return response()->json([
                'status' => -99,
                'error_times' => 5,
                'error_CD' => $error_CD,
            ]);
        } else {
            //api查看是否成功
            $send_url = 'https://c1tw-transfer.digeam.com/accounts/transfer?region=tw&key=n24SMFS4dPvOUGQsZnoovMJhhet8BlZN';
            $data = array(
                'userId' => $cabal_user,
                'password' => $cabal_pwd,
                'subPassword' => $cabal_pwd2,
                'siteId' => $user);
            $jsonData = json_encode($data);
            $client = new Client();
            $res = $client->post($send_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $jsonData,
            ]);
            $reqbody = $res->getBody();
            $reqbody = json_decode($reqbody);
            $code = $reqbody->code;

            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                $real_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
            } else {
                $real_ip = $_SERVER["REMOTE_ADDR"];
            }

            //假如回傳200成功綁定更新user
            if ($code == 200) {
                $update_user = transfer_user::where('user_id', $user)->first();
                $update_user->user_id = $user;
                $update_user->ip = $real_ip;
                $update_user->cabal_id = $cabal_user;
                $update_user->save();

                $create_log = new try_login_log();
                $create_log->user_id = $user;
                $create_log->ip = $real_ip;
                $create_log->login_result = 'success';
                $create_log->save();
                return response()->json([
                    'status' => 1,
                    'content' => $reqbody,
                ]);
            } elseif ($code == 8002) {
                //帳號已綁定

                $user_other = [];
                array_push($user_other, substr($user, 0, 1));
                array_push($user_other, substr($user, 1, 1));
                array_push($user_other, substr($user, -2, -1));
                array_push($user_other, substr($user, -1));
                return response()->json([
                    'status' => -98,
                    'user_other' => $user_other,
                    'content' => $reqbody,
                ]);
            } else {
                //嘗試錯誤 紀錄寫入
                if ($code == 8004) {
                    //SubPassword錯誤
                    $login_result = 'SubPassword dose not match';
                } else {
                    //帳號或密碼錯誤
                    $login_result = 'Account/Password error';
                }
                $create_log = new try_login_log();
                $create_log->user_id = $user;
                $create_log->ip = $real_ip;
                $create_log->login_result = $login_result;
                $create_log->save();

                $stime = Carbon::now()->toDateTimeString();
                $etime = Carbon::now()->subMinutes(30)->toDateTimeString();
                $log_count = try_login_log::where('user_id', $user)->whereBetween('created_at', [$etime, $stime])->count();
                $user_info = transfer_user::where('user_id', $user)->first();
                if ($log_count >= 5) {
                    $log_info = try_login_log::where('ip', $real_ip)->orderBy('created_at', 'desc')->first();
                    $lock_time = Carbon::parse($log_info->try_time)->addHours(2)->toDateTimeString();
                    $user_info->status = 'Y';
                    $user_info->lock_time = $lock_time;
                    $user_info->save();
                    $error_CD = (new Carbon)->diffInSeconds($lock_time, true);
                    $log_count = 5;
                } else {
                    $error_CD = 0;
                }
                return response()->json([
                    'status' => -99,
                    'error_times' => $log_count,
                    'error_CD' => $error_CD,
                    'content' => $reqbody,
                ]);
            }
        }
    }

}
