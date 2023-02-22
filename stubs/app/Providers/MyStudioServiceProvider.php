<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyStudioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        collect(array_filter(glob(database_path('migrations/*')), 'is_dir'))
            ->each(function ($path) {
                $this->loadMigrationsFrom($path);
            });
    }
}
