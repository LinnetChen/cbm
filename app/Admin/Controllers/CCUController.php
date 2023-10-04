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
use App\Models\CCU_PerTime;
use App\Admin\Excel\PostsExporter;
class CCUController extends AdminController
{
    public function index(Content $content){
        return $content
        ->header('CCU')
        ->description('清單')
        ->body($this->grid($this));
    }

    protected function grid()
    {
        $grid = new Grid(new CCU_PerTime());
        $grid->model()->orderBy('created_at','desc');
        $grid->column('ccu_time', __('時間'));
        $grid->column('ccu_s1', __('CCU (一服)'));
        $grid->column('ccu_s2', __('CCU (二服)'));



        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->where(function ($query) {
                $query->where('ccu_time', 'like', "%".$this->input."%");
            }, '時間(YYYY/MM/DD)');
        });

        $grid->actions(function($actions){
            $actions->disableView();
        });

        $grid->disableRowSelector();
        //$grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();
        // $grid->exporter(new PostsExporter());
        return $grid;
    }
}
