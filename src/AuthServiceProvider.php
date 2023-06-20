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
            __DIR__ . '/../stubs/app/Models' => app_path('Models'),
        ], 'kstudio-model');

        // Views
        $this->publishes([
            // __DIR__ . '/../stubs/resources/views' => resource_path('views'),
            __DIR__ . '/../stubs/resources/views/mystudio' => resource_path('views/mystudio'),
            __DIR__ . '/../stubs/resources/views/home.blade.php' => resource_path('views/home.blade.php'),
            __DIR__ . '/../stubs/resources/views/layouts' => resource_path('views/layouts'),
            __DIR__ . '/../stubs/resources/views/components' => resource_path('views/components'),
            __DIR__ . '/../stubs/resources/json' => resource_path('json'),

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

        // public
        $this->publishes([
            __DIR__ . '/../stubs/public' => base_path('public'),
        ], 'kstudio-public');

        // public
        $this->publishes([
            __DIR__ . '/../stubs/database/migrations' => base_path('database/migrations'),
        ], 'kstudio-migration');

        // filesystem
        $this->publishes([
            __DIR__ . '/../stubs/config/filesystem.php' => base_path('config/filesystem.php'),
        ], 'kstudio-filesystem');

        //Requests
        $this->publishes([
            __DIR__ . '/../stubs/app/Http/Requests' => app_path('Http'),
        ], 'kstudio-requests');

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
