<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\serial_number_cate;
use App\Models\serial_number;
class SerialNumberController extends Controller
{
    public function delSerial(Request $request){
        $check =serial_number_cate::where('id',$request->page_id)->first();
        if($check){
            $del_serial = serial_number::where('type',$check['type'])->delete();
        }
        serial_number_cate::where('id',$request->page_id)->delete();
        return response()->json([
            'status' => 1,
        ]);
    }
}
