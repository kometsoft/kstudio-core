<?php

namespace App\Models\Mystudio;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $table = 'settings';

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];

}
