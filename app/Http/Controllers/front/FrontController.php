<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\page;

class FrontController extends Controller
{
    public function wiki($id = 0)
    {
        if($id == 0){
            $first =  page::where('open', 'Y')->where('type', 'wiki')->orderby('id', 'asc')->first();
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
}
