<?php

namespace Kometsoft\Auth;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\InstallAuthCommand;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__ . '/config/laravel-auth.php',
        //     'laravel-auth'
        // );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../stubs/app/Http/Controllers/MyStudio' => app_path('Controllers/MyStudio'),
        ], 'kstudio-controller');

        $this->publishes([
            __DIR__ . '/../stubs/app/Models/MyStudio' => app_path('Models/MyStudio'),
        ], 'kstudio-model');

        // Assets
        $this->publishes([
            __DIR__ . '/../stubs/resources/calendar/views/mystudio' => resource_path('calendar/views/mystudio'),
        ], 'kstudio-assets');

        // // Stubs
        // $this->publishes([
        //     __DIR__ . '/../stubs/app' => app_path(),
        //     __DIR__ . '/../stubs/resources/views' => resource_path('views'),
        //     __DIR__ . '/../stubs/lang' => lang_path(),
        //     __DIR__ . '/../stubs/stubs' => base_path('stubs'),
        // ], 'laravel-auth-stubs');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallAuthCommand::class,
            ]);
        }
    }
}
