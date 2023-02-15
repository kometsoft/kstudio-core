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
        // $this->loadViewsFrom(__DIR__ . '/resources/views', 'tab');

        // $this->loadTranslationsFrom(__DIR__ . '/lang', 'auth');

        // Config file
        // $this->publishes([
        //     __DIR__ . '/config/laravel-auth.php' => config_path('laravel-auth.php'),
        // ], 'laravel-auth-config');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/FormController.php' => app_path('Controllers/MyStudio/FormController.php'),
        ], 'form-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/CalendarController.php' => resource_path('Controllers/MyStudio/CalendarController.php'),
        ], 'calendar-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/ColumnController.php' => resource_path('Controllers/MyStudio/ColumnController.php'),
        ], 'column-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/GenerateFileController.php' => resource_path('Controllers/MyStudio/GenerateFileController.php'),
        ], 'generate-file-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/ListController.php' => resource_path('Controllers/MyStudio/ListController.php'),
        ], 'list-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/MenuController.php' => resource_path('Controllers/MyStudio/MenuController.php'),
        ], 'menu-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/MigrationController.php' => resource_path('Controllers/MyStudio/MigrationController.php'),
        ], 'migration-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/TabController.php' => resource_path('Controllers/MyStudio/TabController.php'),
        ], 'tab-controller');

        $this->publishes([
            __DIR__ . '/app/Http/Controllers/MyStudio/TableFieldController.php' => resource_path('Controllers/MyStudio/TableFieldController.php'),
        ], 'table-field-controller');


        // Assets
        // $this->publishes([
        //     __DIR__ . '/../stubs/resources/sass' => resource_path('sass'),
        //     __DIR__ . '/../stubs/resources/js' => resource_path('js'),
        //     __DIR__ . '/../stubs/vite.config.js' => base_path('vite.config.js'),
        //     __DIR__ . '/../stubs/public/vendor' => public_path('vendor'),
        // ], 'laravel-auth-assets');

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
