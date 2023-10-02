<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class page extends Model
{
    protected $table = 'page';
    use DefaultDatetimeFormat;
}
