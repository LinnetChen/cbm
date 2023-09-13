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
use App\Models\PreregUser;
use App\Admin\Excel\PostsExporter;
class PreregUserController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('事前預約玩家')
        ->description('清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new PreregUser());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('user_id', __('帳號'));
        $grid->column('mobile', __('手機'));
        $grid->column('user_ip', __('IP'));
        $grid->column('created_at', __('建立時間'))->date('Y-m-d');



        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
            $filter->equal('mobile', '手機');
            $filter->equal('user_ip', 'IP');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableRowSelector();
        //$grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();
        // $grid->exporter(new PostsExporter());
        return $grid;
    }
}
