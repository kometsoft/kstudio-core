<?php

namespace App\Models\Admin;

use App\Models\Base as Model;

class Lookup extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value_translation' => 'array',
        'meta_value'        => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
