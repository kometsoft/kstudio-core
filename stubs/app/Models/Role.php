<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use SoftDeletes;
}
