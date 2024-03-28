<?php

namespace App\Admin\Controllers;

use App\Models\Event240403BindingLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class Event20240329BindingLogController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('綁定紀錄')
            ->description('清單')
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new Event240403BindingLog());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('user', __('帳號'));
        $grid->column('binding', __('綁定碼'));
        $grid->column('ip', __('IP'));
        $grid->column('server_id', __('伺服器'))->display(function () {
            if ($this->server_id == 'server01') {
                return '冰珀星';
            } else if ($this->server_id == 'server02') {
                return '黑恆星';
            }
        });
        $grid->column('created_at', __('綁定時間'))->date('Y-m-d');

        $grid->filter(function ($filter) {
            $filter->equal('user', '帳號');
            $filter->equal('binding', '綁定碼');
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
