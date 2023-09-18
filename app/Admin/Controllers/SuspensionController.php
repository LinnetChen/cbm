<?php

namespace App\Admin\Controllers;

use App\Models\suspension;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class SuspensionController extends AdminController
{
    public function index(Content $content)
    {
        $title = '停權名單';
        return $content
            ->header($title)
            ->description()
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new suspension());
        $grid->column('user_id', __('違規帳號'));
        $grid->column('description', __('違規事項'));
        $grid->column('punish', __('懲處辦法(以帳號計算)'));
        $grid->column('lock_time', __('停權時間'));

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '違規帳號');
            $filter->equal('description', '違規事項');
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

        $form = new Form(new suspension());
        $form->text('user_id', __('違規帳號'));
        $form->text('description', __('違規事項'));
        $form->text('punish', __('懲處辦法'));
        $form->date('lock_time', __('停權時間'));

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;

    }
}
