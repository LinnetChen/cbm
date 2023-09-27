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
use App\Models\serial_number_cate;
use App\Models\serial_number_getlog;
class SerialNumberLogController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('序號兌換Log')
        ->description('清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new serial_number_getlog());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('user', __('帳號'));
        $grid->column('number', __('兌換序號'));
        $grid->column('serial_cate_id', __('活動'))->display(function(){
            $get = serial_number_cate::where('id',$this->serial_cate_id)->first();
            return $get['title'];
        });
        $grid->column('ip', __('IP'));
        $grid->column('created_at', __('領取時間'))->date('Y-m-d');



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
        $grid->disableCreateButton();

        return $grid;
    }
}
