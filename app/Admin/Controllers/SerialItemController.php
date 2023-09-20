<?php

namespace App\Admin\Controllers;

use App\Models\serial_item;
use App\Models\serial_number_cate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\MessageBag;
use URL;
class SerialItemController extends AdminController
{
    public function index(Content $content)
    {
        $explode = explode('/',URL::current());
        $cate_id = $explode[count($explode)-2];
        $getGroup = serial_number_cate::where('id',$cate_id)->first();

        return $content
            ->header('序號道具設定')
            ->description($getGroup['title'])
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $explode = explode('/',URL::current());
        $cate_id = $explode[count($explode)-2];
        $grid = new Grid(new serial_item());
        $grid->model()->where('cate_id',$cate_id)->orderBy('created_at', 'desc');
        $grid->column('item_name', __('道具名稱'));
        $grid->column('prdId', __('prdId'));
        $grid->column('itemIdx', __('itemIdx'));
        $grid->column('itemOpt', __('itemOpt'));
        $grid->column('durationIdx', __('durationIdx'));

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

        $form = new Form(new serial_item());
        $form->text('cate_id', __('序號ID'))->default($cate_id)->readonly();

        $form->text('item_name', __('道具名稱'))->required();
        $form->text('prdId', __('prdId'))->required();
        $form->text('itemIdx', __('itemIdx'))->required();
        $form->text('itemOpt', __('itemOpt'))->required();
        $form->text('durationIdx', __('durationIdx'))->required();


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
