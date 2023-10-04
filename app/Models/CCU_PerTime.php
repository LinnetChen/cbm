<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class CCU_PerTime extends Model
{
    protected $table = 'ccu_pertime';
    use DefaultDatetimeFormat;
}
