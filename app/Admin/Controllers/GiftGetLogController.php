<?php

namespace App\Admin\Controllers;

use App\Models\giftGetLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class GiftGetLogController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('領獎專區Log')
            ->description('清單')
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new giftGetLog());
        $grid->model()->where('is_send','y')->orderBy('created_at', 'desc');
        $grid->column('user', __('帳號'));
        $grid->column('gift', __('領取活動'));
        $grid->column('gift_item', __('領取道具'));
        $grid->column('count', __('可重複領取項目此次發送數量'));
        $grid->column('ip', __('IP'));
        $grid->column('tranNo', __('tranNo'));
        $grid->column('type', __('獎勵類型'))->display(function(){
            if($this->type =='active'){
                return '活動背包';
            }else{
                return 'CASH背包';
            }
        });
        $grid->column('server_id', __('伺服器'))->display(function(){
            if($this->server_id =='1'){
                return '冰珀星';
            }else if($this->server_id =='2'){
                return '黑恆星';
            }else{
                return '共用';
            }
        });
        $grid->column('is_send', __('發送狀況'))->display(function(){
            if($this->is_send =='y'){
                return '已發送';
            }
        });
        $grid->column('created_at', __('領取時間'))->date('Y-m-d');
        $grid->column('updated_at', __('道具發送時間'))->date('Y-m-d');

        $grid->filter(function ($filter) {
            $filter->equal('user', '帳號');
            $filter->equal('gift', '領取活動編號');
            $filter->disableIdFilter();
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();

        return $grid;
    }
}
