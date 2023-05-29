<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use SoftDeletes;
}
