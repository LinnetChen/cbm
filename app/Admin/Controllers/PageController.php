<?php

namespace App\Admin\Controllers;

use App\Models\category;
use App\Models\page;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use URL;

class PageController extends AdminController
{

    public function __construct()
    {

        $page = page::get();
        foreach ($page as $value) {
            if ($value['cate_id'] == null) {
                $getPage = page::find($value['id']);
                $getPage->overall_sort = $value['sort'];
                $getPage->save();
            } else if ($value['cate_id'] != null) {
                $Category = category::find($value['cate_id']);
                $getPage = page::find($value['id']);
                $getPage->overall_sort = $Category->sort;
                $getPage->save();
            }
        }
    }

    public function index(Content $content)
    {
        $explodeUrl = explode('/', URL::current());
        $count = COUNT($explodeUrl);
        $type = $explodeUrl[$count - 2];
        $this->pageType = $type;
        switch ($this->pageType) {
            case 'wiki':
                $title = '百科清單';
                break;
        }
        return $content
            ->header($title)
            ->description('文章管理')
            ->body($this->grid($this));
    }

    protected function grid()
    {
        $script = <<<SCRIPT
        if(location.href.indexOf('#reloaded')==-1){
            location.href = location.href+"#reloaded";
            location.reload()
        }
SCRIPT;
        Admin::script($script);
        $grid = new Grid(new Page());
        $grid->model()
            ->where('type', $this->pageType)
            ->orderBy('overall_sort', 'desc')
            ->orderBy('sort', 'desc');
        $grid->column('title', __('標題'));
        $grid->column('cate_id', __('分類名稱'))->display(function () {
            if ($this->cate_id != null) {
                $cateName = category::where('id', $this->cate_id)->first();
                return $cateName['cate_title'];
            }
        });

        $grid->column('status', __('開啟狀態'))->display(function () {
            if ($this->open == 'N') {
                return '關閉';
            } else {
                return '開啟';
            }
        });

        $grid->column('sort', __('排序'))->display(function () {
            if ($this->cate_id != null) {
                return $this->overall_sort . '-' . $this->sort;
            } else {
                return $this->sort;
            }
        });

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('title', '標題');
            $filter->equal('cate_id', '分類')->select(category::pluck('cate_title', 'id')->toArray());
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
        $cate = category::select('id', 'cate_title')->where('type', 'wiki')->orderBy('status', 'desc')->orderBy('sort', 'desc')->pluck('cate_title', 'id');
        $form = new Form(new Page());

        $form->text('title', __('標題'));
        $form->select('cate_id', __('分類'))->options($cate)->default(0);
        $form->ckeditor('content', __('內容'))->options(['width:1046px']);
        $form->select('open', __('狀態'))->options(['N' => '關閉', 'Y' => '開啟'])->default('N');
        $form->number('sort', __('排序'))->default(1);
        $form->text('type', __('類型'))->default('wiki')->readonly();

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        $script = <<<SCRIPT
        setTimeout(() => {
            $('.cke_editable').css('width','1046px !important');
          }, "5000");
SCRIPT;
        Admin::script($script);

        return $form;

    }

    public function edit($type, Content $content)
    {
        // 切開網址,定義id
        $explodeUrl = explode('/', URL::current());
        $count = COUNT($explodeUrl);
        $id = $explodeUrl[$count - 2];
        return Admin::content(function (Content $content) use ($id) {

            $content->header('赤壁百科編輯');
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
