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
use App\Models\transfer_user;
use App\Admin\Excel\PostsExporter;
class TransferUserController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('玩家轉移清單')
        ->description('清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new transfer_user());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('user_id', __('帳號'));
        $grid->column('cabal_id', __('綁定帳號'));
        $grid->column('status', __('狀態'))->display(function(){
            if($this->status =='Y'){
                return '上鎖';
            }
        });
        $grid->column('lock_time', __('解鎖時間'))->display(function(){
            if($this->status =='Y'){
                return $this->lock_time;
            }
        });
        $grid->column('ip', __('IP'));
        $grid->column('created_at', __('建立時間'))->date('Y-m-d');



        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
            $filter->equal('cabal_id', 'cabal帳號');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableRowSelector();
        // $grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->exporter(new PostsExporter());
        return $grid;
    }
}
