<?php

namespace App\Admin\Controllers;

use App\Models\event240403GetLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class Event20240329GetLogController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('領取紀錄')
            ->description('清單')
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new event240403GetLog());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('user', __('帳號'));
        $grid->column('gift', __('領取活動'))->display(function () {
            switch ($this->gift) {
                case 'gift01':
                    return '補給卡x30';
                    break;
                case 'gift02':
                    return '補給卡x10';
                    break;
                case 'gift03':
                    return '補給卡x30';
                    break;
                case 'gift04':
                    return '補給卡x50';
                    break;
                case 'gift05':
                    return '補給卡x50';
                    break;
                case 'gift06':
                    return '補給卡x80';
                    break;
                default:
                    return $this->gift;
                    break;
            }
        });
        $grid->column('ip', __('IP'));
        $grid->column('type', __('獎勵類型'))->display(function () {
            if ($this->type == 'active') {
                return '活動背包';
            } else {
                return 'CASH背包';
            }
        });
        $grid->column('server_id', __('伺服器'))->display(function () {
            if ($this->server_id == 'server01') {
                return '冰珀星';
            } else if ($this->server_id == 'server02') {
                return '黑恆星';
            } else {
                return '共用';
            }
        });
        $grid->column('created_at', __('領取時間'))->date('Y-m-d');

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
