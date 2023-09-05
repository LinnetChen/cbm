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
use App\Models\MsgBoard;
class MsgBoardController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('留言板')
        ->description('清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new MsgBoard());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('user_id', __('帳號'));
        $grid->column('post_name', __('名稱'))->display(function(){
            if(base64_decode($this->post_name) == '') {
                return $this->post_name;
            } else {
                return base64_decode($this->post_name);
            }
        });
        $grid->column('post_txt', __('內容'))->display(function(){
            if(base64_decode($this->post_txt) == '') {
                return $this->post_txt;
            } else {
                return base64_decode($this->post_txt);
            }
        });
        $states = [
            'on' => ['value' => 'Y', 'text' => '顯示', 'color' => 'primary'],
            'off' => ['value' => 'N', 'text' => '隱藏', 'color' => 'default'],
        ];
        $grid->column('is_show', __('狀態'))->display(function(){
            if($this->is_show =='Y'){
                return '顯示';
            }else{
                return '隱藏';
            }
        });
        $grid->column('user_ip', __('IP'));
        $grid->column('created_at', __('建立時間'))->date('Y-m-d H:i:s');



        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
            $filter->where(function ($query) {
                $query->where('post_txt', 'like', "%".base64_encode($this->input)."%");
            }, '內容');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableExport();
        return $grid;
    }
    protected function form()
    {
        $form = new Form(new MsgBoard());

        $form->text('user_id', __('帳號'))->default('admin')->readonly();
        $form->text('post_name', __('名稱'));
        $form->text('post_txt', __('內容'));
        $form->select('is_show', __('狀態'))->options(['N'=>'隱藏','Y'=>'顯示'])->default('N');
        $form->text('user_ip', __('類型'))->default('211.23.144.219')->readonly();

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

            $content->header('留言板');
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
