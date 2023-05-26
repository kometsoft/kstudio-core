<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::name('admin.')->group(function () {
        Route::prefix('admin/')->group(function () {
            Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
            Route::resource('role', \App\Http\Controllers\Admin\RoleController::class);
            Route::resource('audit-trail', \App\Http\Controllers\Admin\AuditTrailController::class);
            Route::resource('data-dictionary', \App\Http\Controllers\Admin\DataDictionaryController::class);

            // AJAX
            Route::get('data-dictionary/getKey/{key}', [\App\Http\Controllers\Admin\DataDictionaryController::class, 'getKey']);
        });
    });
    Route::put('profile/{profile}/updatePassword', [\App\Http\Controllers\Auth\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::resource('profile', \App\Http\Controllers\Auth\ProfileController::class);
});
