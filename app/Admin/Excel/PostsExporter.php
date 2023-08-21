<?php

namespace App\Admin\Excel;

use Encore\Admin\Table\Exporters\ExcelExporter;

class PostsExporter extends ExcelExporter
{
    protected $fileName = '文章列表.xlsx';

    protected $columns = [
        'id'      => 'ID',
        'title'   => '标题',
        'content' => '内容',
    ];
}
