<?php

namespace App\Admin\Controllers;

use App\Models\giftCreate;
use App\Models\giftGroup;
use App\Models\newGiftContent;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use URL;

class NewGiftItemCreateController extends AdminController
{
    public function index(Content $content)
    {
        $explode = explode('/', URL::current());
        $cate_id = $explode[count($explode) - 2];
        $getGroup = giftGroup::where('id', $cate_id)->first();
        $getCate = giftCreate::where('id', $getGroup['gift_id'])->first();
        return $content
            ->header('領獎專區')
            ->description($getCate['title'] . '－' . $getGroup['title'])
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $explode = explode('/', URL::current());
        $cate_id = $explode[count($explode) - 2];
        $grid = new Grid(new newGiftContent());
        $grid->model()->where('gift_group_id', $cate_id)->orderBy('created_at', 'desc');
        $grid->column('title', __('標題'));
        $grid->column('itemKind', __('itemKind'));
        $grid->column('itemOption', __('itemOption'));
        $grid->column('itemPeriod', __('itemPeriod'));
        $grid->column('count', __('數量'));
        $grid->column('serverIdx', __('伺服器'))->display(function () {
            if ($this->serverIdx == 1) {
                return '冰珀星';
            } else {
                return '黑恆星';
            }
        });
        $grid->column('deliveryTime', __('領取開始'));
        $grid->column('expirationTime', __('領取結束'));

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableFilter();

        return $grid;
    }

    protected function form()
    {
        $getCate = explode('/', URL::current());
        $cate_id = $getCate[count($getCate) - 3];

        $form = new Form(new newGiftContent());
        $form->text('gift_group_id', __('分類ID'))->default($cate_id)->readonly();

        $form->text('title', __('標題'))->required();
        $form->text('itemKind', __('itemKind'))->required();
        $form->text('itemOption', __('itemOption'))->required();
        $form->text('itemPeriod', __('itemPeriod'))->required();
        $form->number('count', __('count'))->default(1)->required();
        $form->select('serverIdx', __('伺服器'))->options([1 => '冰珀星', 2 => '黑恆星'])->default(1)->required();
        $form->datetime('deliveryTime', __('領取開始'));
        $form->datetime('expirationTime', __('領取結束'));

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();

        });

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
