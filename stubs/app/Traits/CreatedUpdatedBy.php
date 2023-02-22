<?php

namespace App\Traits;

use App\Models\User;

trait CreatedUpdatedBy
{
  public static function bootCreatedUpdatedBy()
  {
    // Updating created_by and updated_by when model is created
    static::creating(function ($model) {
      $model->created_by = auth()->id();
    });

    // Updating updated_by when model is updated
    static::updating(function ($model) {
      $model->updated_by = auth()->id();
    });
  }

  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => '-']);
  }

  public function updator()
  {
    return $this->belongsTo(User::class, 'updated_by')->withDefault(['name' => '-']);
  }
}
