<?php

namespace App\Models;

use CleaniqueCoders\LaravelUuid\Contracts\HasUuid as HasUuidContract;
use CleaniqueCoders\LaravelUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Base extends Model implements HasMedia, HasUuidContract
{
    use HasFactory;
    use HasUuid;
    use InteractsWithMedia;

    protected $guarded = [
        'id',
    ];

    public function scopeIs($query, $field, $value)
    {
        return $query->where('is_' . $field, $value);
    }

}
