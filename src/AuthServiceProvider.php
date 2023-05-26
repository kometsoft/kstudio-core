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

        //Controllers
        $this->publishes([
            __DIR__ . '/../stubs/app/Http/Controllers/MyStudio' => app_path('Controllers/MyStudio'),
        ], 'kstudio-controller');

        // Models
        $this->publishes([
            __DIR__ . '/../stubs/app/Models/MyStudio' => app_path('Models/MyStudio'),
        ], 'kstudio-model');

        // Views
        $this->publishes([
            __DIR__ . '/../stubs/resources/views' => resource_path('views'),
            // __DIR__ . '/../stubs/resources/views/mystudio' => resource_path('views/mystudio'),
            // __DIR__ . '/../stubs/resources/views/home.blade.php' => resource_path('views/home.blade.php'),
        ], 'kstudio-view');

        // Routes
        $this->publishes([
            __DIR__ . '/../stubs/routes' => base_path('routes'),
        ], 'kstudio-route');

        // Stubs
        $this->publishes([
            __DIR__ . '/../stubs/stubs' => base_path('stubs'),
        ], 'kstudio-stubs');

        // Support
        $this->publishes([
            __DIR__ . '/../stubs/support' => base_path('support'),
        ], 'kstudio-support');

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
