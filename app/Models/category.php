<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class category extends Model
{
    protected $table ='category';
    use DefaultDatetimeFormat;
}
