<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\page;
use App\Models\Image;
use App\Models\suspension;
class FrontController extends Controller
{
    public function index(){
        $img = Image::where('status','Y')->where('type','index')->orderBy('sort','desc')->get();
        $na = page::where('type', 'announcement')->where('open', 'Y')->where('created_at','<=',date('Y-m-d H:i:s'))->orderBy('top','desc')->orderBy('new','desc')->orderBy('created_at','desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nb = page::where('type', 'announcement')->where('cate_id', 17)->where('open', 'Y')->where('created_at','<=',date('Y-m-d H:i:s'))->orderBy('top','desc')->orderBy('new','desc')->orderBy('created_at','desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nc = page::where('type', 'announcement')->where('cate_id', 18)->where('open', 'Y')->where('created_at','<=',date('Y-m-d H:i:s'))->orderBy('top','desc')->orderBy('new','desc')->orderBy('created_at','desc')->orderBy('sort', 'desc')->limit(6)->get();
        $nd = page::where('type', 'announcement')->where('cate_id', 24)->where('open', 'Y')->where('created_at','<=',date('Y-m-d H:i:s'))->orderBy('top','desc')->orderBy('new','desc')->orderBy('created_at','desc')->orderBy('sort', 'desc')->limit(6)->get();
        return view('front.home_page',[
            'img'=>$img,
            'na'=>$na,
            'nb'=>$nb,
            'nc'=>$nc,
            'nd'=>$nd,
        ]);
    }
    public function wiki($id = 0){
        if($id == 0){
            $first =  page::where('open', 'Y')->where('type', 'wiki')->orderby('sort', 'desc')->first();
            $id = $first['id'];
        }
        // 撈出分類和頁面的正確排序
        $side = page::where('open', 'Y')->where('type', 'wiki')->orderby('overall_sort', 'desc')->orderby('sort', 'desc')->get();
        // 用cate_id區分項目
        $groupItem = $side->groupBy(['cate_id']);
        $sideSort = [];
        $cate_inArray = [];
        // 整理分類與該分類項目,區分單一page
        foreach ($side as $key => $value) {
            if ($value['cate_id'] != null) {
                if (!in_array($value['cate_id'], $cate_inArray)) {
                    $findCate = Category::find($value['cate_id']);
                    $sideSort[$value['cate_id']]['cate_title'] = $findCate['cate_title'];
                    $sideSort[$value['cate_id']]['id'] = $findCate['id'];
                    $sideSort[$value['cate_id']]['have_cate'] = true;
                    array_push($cate_inArray, $value['cate_id']);
                }
            } else {
                $sideSort[$key]['cate_title'] = $value['title'];
                $sideSort[$key]['id'] = $value['id'];
                $sideSort[$key]['have_cate'] = false;
            }
        }
        // 撈出畫面
        $page = page::where('type', 'wiki')->where('id', $id)->first();
        return view('home_wiki', [
            'side' => $sideSort, //側邊攔
            'page' => $page, //內容
            'sideContent' => $groupItem, //側邊攔分類子項
        ]);
    }
    public function suspension_list(){
        $list = suspension::orderBy('created_at','desc')->paginate(10);
        return view('front.suspension_list',[
            'list'=>$list,
        ]);
    }
}
