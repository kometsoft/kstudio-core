<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::name('dictionary.')->group(function () {
        Route::name('ticket-category.')->group(function () {
            Route::get('ticket-category/index', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'index'])->name('index');
            Route::get('ticket-category/create', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'create'])->name('create');
            Route::post('ticket-category/store', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'store'])->name('store');
            Route::get('ticket-category/show/{category}', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'show'])->name('show');
            Route::get('ticket-category/edit/{category}', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'edit'])->name('edit');
            Route::post('ticket-category/update/{category}', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'update'])->name('update');

            Route::post('ticket-category/attach/{category}', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'attach'])->name('attach');
            Route::post('ticket-category/detach/{user_id}/{category}', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'detach'])->name('detach');
            Route::get('ticket-category/edituser/{user_id}/{category}', [\App\Http\Controllers\Dictionary\TicketCategoryController::class, 'edituser'])->name('edituser');
        });
    });

   
});