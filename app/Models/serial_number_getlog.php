<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class serial_number_getlog extends Model
{
    protected $table = 'serial_number_getlog';
    use DefaultDatetimeFormat;
}
