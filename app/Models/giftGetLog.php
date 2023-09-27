<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class giftGetLog extends Model
{
    protected $table = 'gift_getlog';
    use DefaultDatetimeFormat;
}
