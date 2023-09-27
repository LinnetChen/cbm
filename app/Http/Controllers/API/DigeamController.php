<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\page;
class DigeamController extends Controller
{
    public function IndexNews(){
        $page = page::select('id','cate_id','title','created_at')->where('type', 'announcement')->where('open', 'Y')->where('created_at','<=',date('Y-m-d H:i:s'))->orderBy('top','desc')->orderBy('new','desc')->orderBy('created_at','desc')->orderBy('sort', 'desc')->get();
        return $page;
    }
}
