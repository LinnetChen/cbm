<?php

namespace App\Admin\Controllers;

use App\Models\Event20240403User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class Event20240329Controller extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('玩家資訊')
            ->description('清單')
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new Event20240403User());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('user_id', __('帳號'));
        $grid->column('user_type', __('類型'))->display(function () {
            switch ($this->user_type) {
                case 'new':
                    return '新玩家';
                    break;
                case 'skillful':
                    return '活耀玩家';
                    break;
                case 'return':
                    return '回歸玩家';
                    break;
            }
        });
        $grid->column('server_01_code', __('冰珀星綁定碼'));
        $grid->column('server_02_code', __('黑恆星綁定碼'));
        $grid->column('info', __('已綁定'));
        $grid->column('created_at', __('參與時間'))->date('Y-m-d');

        $grid->filter(function ($filter) {
            $filter->equal('user_id', '帳號');
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
