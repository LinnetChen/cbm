<?php

namespace App\Admin\Controllers;

use App\Models\giftCreate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class GiftCreateController extends AdminController
{
    public function index(Content $content)
    {
        return $content

            ->header('領獎專區-道具設定')
            ->description('列表')
            ->body($this->grid($this));
    }

    protected function grid()
    {

        $grid = new Grid(new giftCreate());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('title', __('標題'));
        $grid->column('status', __('狀態'))->using(['n' => '關閉', 'y' => '開啟中']);
        $grid->column('type', __('獎勵類型'))->using(['cash' => 'CASH背包', 'active' => '活動背包']);
        $grid->column('start', __('開始日期'));
        $grid->column('end', __('截止日期'));
        $grid->column('project', __('條件設定'))->display(function () {
            if ($this->type == 'cash') {
                return '<a href =/admin/' . $this->id . '/create_gift_project>設定</a>';
            } else {
                return '<a href =/admin/' . $this->id . '/new_create_gift_project>設定</a>';
            }
        });

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->disableRowSelector();
        $grid->disableExport();

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new giftCreate());

        $form->text('title', __('標題'));
        $form->select('status', __('狀態'))->options(['n' => '關閉', 'y' => '開啟'])->default('n');
        $form->select('type', __('獎勵類型'))->options(['active' => '活動背包', 'cash' => 'CASH背包'])->default('active');
        $form->datetime('start', __('開始日期'));
        $form->datetime('end', __('結束日期'));

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();

        });

        return $form;

    }

}
