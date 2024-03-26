<?php

namespace App\Admin\Controllers;

use App\Models\giftCreate;
use App\Models\giftGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use URL;

class NewGiftProjectCreateController extends AdminController
{
    public function index(Content $content)
    {
        $getCate = explode('/', URL::current());
        $cate_id = $getCate[count($getCate) - 2];
        $getCate = giftCreate::where('id', $cate_id)->first();
        return $content
            ->header('領獎專區-條件設定')
            ->description($getCate['title'])
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $getCate = explode('/', URL::current());
        $cate_id = $getCate[count($getCate) - 2];

        $grid = new Grid(new giftGroup());
        $grid->model()->where('gift_id', $cate_id)->orderBy('created_at', 'desc');
        $grid->column('title', __('標題'));
        $grid->column('item', __('活動獎勵'));
        $grid->column('desc', __('說明'));
        $grid->column('item_set', __('道具設定'))->display(function () {
            return '<a href =/admin/' . $this->id . '/new_create_gift_item>設定</a>';
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

        // $grid->disableActions();

        return $grid;
    }

    protected function form()
    {
        $getCate = explode('/', URL::current());
        $cate_id = $getCate[count($getCate) - 3];
        $form = new Form(new giftGroup());

        $form->text('gift_id', __('分類ID'))->default($cate_id)->readonly();
        $form->text('title', __('標題'));
        $form->textarea('item', __('活動獎勵'));
        $form->textarea('desc', __('說明'));

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();

        });
        Admin::style('.item {width: 251.67px;}');
        Admin::style('.desc {width: 251.67px;}');
        Admin::style('.item {font-size: 17.6px;}');
        Admin::style('.desc {font-size: 17.6px;}');
        Admin::style('.item {text-align: center;}');
        Admin::style('.desc {text-align: center;}');
        return $form;

    }

    public function edit($type, Content $content)
    {
        // 切開網址,定義id
        $explodeUrl = explode('/', URL::current());
        $count = COUNT($explodeUrl);
        $id = $explodeUrl[$count - 2];
        return Admin::content(function (Content $content) use ($id) {

            $content->header('CBO百科編輯');
            $content->description('編輯');

            $content->body($this->form($id)->edit($id));
        });
    }

    public function update($type)
    {
        $explodeUrl = explode('/', URL::current());
        $count = COUNT($explodeUrl);
        $id = $explodeUrl[$count - 1];
        return $this->form()->update($id);
    }
}
