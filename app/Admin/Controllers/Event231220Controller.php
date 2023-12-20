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
use App\Models\Event231220_buylog;
use App\Admin\Excel\PostsExporter;
class Event231220Controller extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('聖誕消費節')
        ->description('購買清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new Event231220_buylog());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('user_id', __('帳號'));
        $grid->column('server_id', __('伺服器'))->display(function(){
            if($this->server_id == 1) {
                return '冰珀星';
            }
            if($this->server_id == 2) {
                return '黑恆星';
            }
            if($this->server_id == 0) {
                return '共通';
            }
        });
        $grid->column('itemname', __('ITEM'));
        $grid->column('price', __('金額'));
        $grid->column('user_ip', __('IP'));
        $grid->column('created_at', __('建立時間'))->date('Y-m-d');



        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
            $filter->equal('itemname', 'ITEM');
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
