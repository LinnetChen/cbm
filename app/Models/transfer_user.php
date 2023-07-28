<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
class transfer_user extends Model
{
    protected $table = 'transfer_user';
    use DefaultDatetimeFormat;
}
