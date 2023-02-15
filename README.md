# Laravel Auth

## Requirements 
- php >=8.0
- laravel/ui ^4.1

## Installations

#### Install the composer package

After a fresh laravel installation, run;

```
composer require kometsoft/laravel-auth
```

#### Run install command

```
php artisan auth:install
```

## Datatables



### Usage

Publis the datatables-buttons config file
```
php artisan vendor:publish --tag=datatables-buttons
```

Change the stub path in datatables-buttons.php
```
/*
* Set Custom stub folder
*/
'stub' => '/stubs/datatables',
```

Pages with datatable should look like this.
```php
@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@vite(['resource/js/datatables/app.js'])
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
```


TODO

```php
Route::middleware(['auth'])->name('admin.')->controller(App\Http\Controllers\Auth\ProfileController::class)->group(function () {
    Route::get('profile', 'index')->name('profile.index');
    Route::post('profile', 'store')->name('profile.store');
    Route::get('profile/create', 'create')->name('profile.create');
    Route::get('profile/{profile}', 'show')->name('profile.show');
    Route::post('profile/{profile}', 'update')->name('profile.update');
    Route::delete('profile/{profile}', 'destroy')->name('profile.destroy');
    Route::get('profile/{profile}/edit', 'edit')->name('profile.edit');
    Route::put('profile/{profile}/update-password', 'updatePassword')->name('profile.update-password');
});
```