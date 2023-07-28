<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class try_login_log extends Model
{
    protected $table = 'try_login_log';
    use DefaultDatetimeFormat;
}
