<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Page;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use URL;

class AnnouncementController extends AdminController
{
    public function index(Content $content)
    {
        $title = '公告';
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
        $grid->model()->where('type', 'announcement')->orderBy('open', 'desc')->orderBy('top', 'desc')->orderBy('new', 'desc')->orderBy('created_at', 'desc')->orderBy('sort', 'desc');
        $grid->column('title', __('標題'));
        $grid->column('cate_id', __('分類名稱'))->display(function () {
            if ($this->cate_id != null) {
                $cateName = Category::where('id', $this->cate_id)->first();
                return $cateName['title'];
            }
        });
        $grid->column('top', __('至頂'))->display(function () {
            if ($this->top == 'y') {
                return '<span style=color:red>TOP</span>';
            }
        });
        $grid->column('new', __('新文章'))->display(function () {
            if ($this->new == 'y') {
                return '<span style=color:red>NEW</span>';
            }
        });

        $grid->column('open', __('開啟狀態'))->display(function () {
            if ($this->open == 'N') {
                return '關閉';
            } else {
                return '開啟';
            }
        });
        $grid->column('created_at', __('建立時間'));
        $grid->column('sort', __('排序'));

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('title', '標題');
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

        $cate = Category::select('id', 'cate_title')->where('type', 'announcement')->orderBy('status', 'desc')->orderBy('sort', 'desc')->pluck('cate_title', 'id');
        $defaultCate = Category::where('type', 'announcement')->first();
        $form = new Form(new Page());

        $form->text('title', __('標題'));
        $form->select('cate_id', __('分類'))->options($cate)->default($defaultCate['id']);
        $form->ckeditor('content', __('內容'));
        $form->select('status', __('狀態'))->options(['N' => '關閉', 'Y' => '開啟'])->default('N');
        $form->number('sort', __('排序'))->default(0);
        $form->radio('top', __('Top標籤'))->options(['y' => '是', 'n' => '否'])->default('n')->help("點選'是',並儲存,會將先前的TOP文章取消TOP,並將TOP設定為目前的文章喔!");
        $form->radio('new', __('New標籤'))->options(['y' => '是', 'n' => '否'])->default('n');
        $form->text('type', __('類型'))->default('announcement')->readonly();
        //$form->date('created_at',__('發布日期'))->format('YYYY-MM-DD HH:mm:ss');
        $form->datetime('created_at', __('發佈日期'))->default(date('Y-m-d H:i:s'));

        //增加按鈕
        $form->tools(function (Form\Tools $tools) {
            $url = URL::current();
            $url2 = explode('/', URL::current());
            $count = COUNT($url2);
            $type = $url2[$count - 1];
            if ($type == 'create') {
                $tools->append("<a class='btn btn-sm btn-primary mallto-next' href='/preview' target='_blank'>view</a> &nbsp;");
            }
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        $form->saving(function (Form $form) {
            if ($form->top == 'y') {
                $findTOP = Page::where('top', 'y')->first();
                $getID = explode('announcement/', url()->current());
                // 確認是否為新建文章
                if (isset($getID[1])) {
                    // 如果目前top文章跟網址取得的id不同,則把舊文章的取消掉
                    if ($findTOP && $findTOP->id != $getID[1]) {
                        $findTOP->top = 'n';
                        $findTOP->save();
                    }
                } else {
                    // 新文章有top標籤,如果已有舊文章有top,則取消
                    if ($findTOP) {
                        $findTOP->top = 'n';
                        $findTOP->save();
                    }
                }
            }
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

    public function detail()
    {
        // $exurl=explode('/',URL::current());
        //dd(gettype(URL::current()));
        $url = explode('/', URL::current());
        //dd(gettype($url));
        $count = COUNT($url);
        $id = $url[$count - 1];
        $content = Page::find($id);
        return view('front.announcementContent', [
            'content' => $content,
        ]);
    }

}
