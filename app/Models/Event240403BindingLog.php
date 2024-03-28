<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class Event240403BindingLog extends Model
{
    protected $table = 'event240403_binding_log';
    use DefaultDatetimeFormat;
}
