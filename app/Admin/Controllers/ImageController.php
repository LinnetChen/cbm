<?php

namespace App\Admin\Controllers;

use App\Models\Image;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'CBO官網首頁圖片管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Image());
        $grid->model()->orderBy('status','desc')->orderBy('sort','desc');
        $grid->column('file_name', __('圖片'))->image();
        $grid->column('url', __('網址'));
        $grid->column('status', __('開啟狀態'))->display(function(){
            if($this->status == 'N'){
                return '關閉';
            }else{
                return '開啟';
            }
        });
        $grid->column('sort', __('排序'));

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableExport();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Image::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Image());

        $form->image('file_name', __('圖片'))->uniqueName()->move('upload/index')->removable()->rules('required');
        $form->text('url', __('網址'))->rules('required');
        $form->select('status', __('狀態'))->options(['N' => '關閉', 'Y' => '開啟'])->default('N');
        $form->number('sort', __('排序'))->default(1);
        $form->text('type', __('類型'))->default('index')->readonly();

        $form->footer(function ($footer) {

            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
            $footer->disableReset();

        });
        return $form;
    }
}
