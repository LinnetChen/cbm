<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class PreregUser extends Model
{
    protected $table = 'prereguser';
    use DefaultDatetimeFormat;
}
