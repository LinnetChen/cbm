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
use Str;
use App\Models\serial_number_cate;
use App\Models\serial_number;
use Illuminate\Support\MessageBag;
class SerialNumberCateController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('序號系統')
        ->description('列表')
        ->body($this->grid($this));
    }

    protected function grid()
    {

        $grid = new Grid(new serial_number_cate());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('title', __('標題'));
        $grid->column('type', __('前贅詞'));
        $grid->column('count', __('序號數量'));
        $grid->column('all_for_one', __('序號類型'));
        $grid->column('list', __('序號列表'))->display(function(){
            return '<a href =/admin/'.$this->type.'/serial_number>序號列表</a>';
        });
        $grid->column('delete', __('刪除'))->display(function(){
            return '<button onclick="delete_div('.$this->id.')">刪除</button>';
        });

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('user_id', '帳號');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableActions();

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new serial_number_cate());

        $form->text('title', __('標題'));
        $form->text('type', __('前贅詞'));
        $form->select('all_for_one', __('狀態'))->options(['N'=>'一組序號一人用','Y'=>'一組序號多人用'])->default('N');
        $form->number('count', __('數量'))->default(1);

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();

        });

        $form->saving(function(Form $form){
            // 前贅詞檢查
            if(mb_strlen($form->type) != 3 ){
                $error = new MessageBag([
                    'title'   => '錯誤',
                    'message' => '前贅詞請設定3個字元',
                ]);
                return back()->with(compact('error'));
            };
            // 序號數量檢查
            if($form->all_for_one == 'Y'){
                if($form->count != 1){
                    $error = new MessageBag([
                        'title'   => '錯誤',
                        'message' => '一組多人使用序號請設定數量為"1"',
                    ]);
                    return back()->with(compact('error'));
                }
            }

        });

        $form->saved(function(Form $form){

            for($i=1;$i<=$form->count;$i++){
                $charid = strtoupper(md5(uniqid(rand(), true)));
                $uuid = substr($charid, 0, 4)
                .substr($charid, 4, 4)
                .substr($charid, 8, 4);

                $new = new serial_number();
                $new->type = $form->type;
                $new->number = $form->type.$uuid;
                $new->status = 'N';
                $new->save();
            }
        });

        return $form;

    }

    public function destroy($id)
    {
        dd('123');
    }
}
