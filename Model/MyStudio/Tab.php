<?php

namespace App\Models\MyStudio;

use App\Models\Base as Model;

class Tab extends Model
{
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];
}
