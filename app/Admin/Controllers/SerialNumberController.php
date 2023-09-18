<?php

namespace App\Admin\Controllers;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use URL;
use App\Models\serial_number;
class SerialNumberController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('序號系統')
        ->description('列表')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $explodeURL = explode('/',URL::current());
        $count = Count($explodeURL);

        $grid = new Grid(new serial_number());
        $grid->model()->where('type',$explodeURL[$count-2]);
        $grid->column('type', __('序號分類'));
        $grid->column('number', __('序號'));
        $grid->column('status', __('使用狀態'))->display(function(){
            if($this->status =='N'){
                return '未使用';
            }else{
                return '已使用';
            }
        });
        $grid->column('user_id', __('使用帳號'));
        $grid->column('updated_at', __('更新時間'))->date('Y-m-d');

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableActions();

        return $grid;
    }
}
