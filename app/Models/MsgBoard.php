<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class MsgBoard extends Model
{
    protected $table = 'msgboard';
    use DefaultDatetimeFormat;
}
