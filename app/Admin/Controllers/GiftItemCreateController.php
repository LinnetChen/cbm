<?php

namespace App\Admin\Controllers;

use App\Models\serial_number;
use App\Models\giftContent;
use App\Models\giftGroup;
use App\Models\giftCreate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\MessageBag;
use URL;
class GiftItemCreateController extends AdminController
{
    public function index(Content $content)
    {
        $explode = explode('/',URL::current());
        $cate_id = $explode[count($explode)-2];
        $getGroup = giftGroup::where('id',$cate_id)->first();
        $getCate = giftCreate::where('id',$getGroup['gift_id'])->first();
        return $content
            ->header('領獎專區')
            ->description($getCate['title'].'－'.$getGroup['title'])
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $explode = explode('/',URL::current());
        $cate_id = $explode[count($explode)-2];
        $grid = new Grid(new giftContent());
        $grid->model()->where('gift_group_id',$cate_id)->orderBy('created_at', 'desc');
        $grid->column('title', __('標題'));
        $grid->column('itemIdx', __('itemIdx'));
        $grid->column('itemOpt', __('itemOpt'));
        $grid->column('durationIdx', __('durationIdx'));
        $grid->column('prdId', __('prdId'));

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
        $getCate = explode('/',URL::current());
        $cate_id = $getCate[count($getCate)-3];

        $form = new Form(new giftContent());
        $form->text('gift_group_id', __('分類ID'))->default($cate_id)->readonly();

        $form->text('title', __('標題'))->required();
        $form->text('itemIdx', __('itemIdx'))->required();
        $form->text('itemOpt', __('itemOpt'))->required();
        $form->text('durationIdx', __('durationIdx'))->required();
        $form->text('prdId', __('prdId'))->required();



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
