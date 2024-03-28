<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class Event20240403User extends Model
{
    protected $table = 'event240403_user';
    use DefaultDatetimeFormat;
}
