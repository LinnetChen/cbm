<?php

namespace App\Admin\Controllers;

use App\Models\Event240123_getlog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class Event240205Controller extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('神光庇護')
            ->description('領取紀錄')
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new Event240123_getlog());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('user', __('帳號'));
        $grid->column('item', __('獲得道具'));
        $grid->column('coupon', __('優惠券'));
        $grid->column('ip', __('IP'));
        $grid->column('type', __('獲取類型'))->display(function () {
            if ($this->type == 'bless') {
                return '加倍祝福';
            } else {
                return '祈求庇佑';
            }
        });
        $grid->column('coupon_deadline', __('優惠券到期時間'));
        $grid->column('created_at', __('建立時間'));

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user', '帳號');
            $filter->equal('ip', 'IP');
            $filter->equal('type', '獲取類型')->select(['bless' => '加倍祝福', 'pray' => '祈求庇佑']);
        });

        $grid->actions(function ($actions) {
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
