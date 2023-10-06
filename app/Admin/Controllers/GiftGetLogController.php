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
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('user', __('帳號'));
        $grid->column('gift', __('領取活動'));
        $grid->column('gift_item', __('領取道具'));
        // $grid->column('serial_cate_id', __('活動'))->display(function () {
        //     $get = serial_number_cate::where('id', $this->serial_cate_id)->first();
        //     return $get['title'];
        // });
        $grid->column('ip', __('IP'));
        $grid->column('tranNo', __('tranNo'));
        $grid->column('created_at', __('領取時間'))->date('Y-m-d');

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user', '帳號');
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
