<?php

namespace App\Admin\Controllers;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use URL;
use App\Models\category;
class MainCateController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('百科分類')
        ->description('清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new category());
        $grid->model()->where('type','!=','announcement')->orderBy('sort','desc')->orderBy('created_at','desc');
        $grid->column('cate_title', __('分類標題'));
        $grid->column('status', __('狀態'))->display(function(){
            if($this->status =='Y'){
                return '開啟';
            }else{
                return '關閉';
            }
        });
        $grid->column('sort', __('排序'))->date('Y-m-d');
        $grid->column('created_at', __('建立時間'))->date('Y-m-d');



        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableRowSelector();
        $grid->disableExport();
        return $grid;
    }
    protected function form()
    {
        $form = new Form(new Category());

        $form->text('cate_title', __('分類標題'));
        $form->select('status', __('狀態'))->options(['N'=>'關閉','Y'=>'開啟'])->default('N');
        $form->number('sort', __('排序'))->default(1);
        $form->text('type', __('類型'))->default('wiki')->readonly();

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();

        });

        return $form;

    }

    public function edit($type,Content $content)
    {

        // 切開網址,定義id
        $explodeUrl =explode('/',URL::current());
        $count  = COUNT($explodeUrl);
        $id = $explodeUrl[$count-2];
        return Admin::content(function (Content $content) use ($id) {

            $content->header('百科分類');
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
