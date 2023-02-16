<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Table Module Route
    Route::name('table.')->group(function () {
        Route::prefix('table/')->group(function () {
            Route::get('index', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'create'])->name('create');
            Route::post('store', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'store'])->name('store');
            Route::get('edit/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'edit'])->name('edit');
            Route::get('edit-table-column/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'editTableColumn'])->name('edit.table-column');
            Route::get('add-column/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'editTableColumn'])->name('add.table-column');
            Route::post('update-table-column/{table}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'updateTableColumn'])->name('update.table-column');
            Route::post('update/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'update'])->name('update');
            Route::get('show/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'show'])->name('show');
            Route::delete('destroy/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'destroy'])->name('destroy');

            // Generate File
            // Route::get('generate/migration/{table_id}', [\App\Http\Controllers\MyStudio\GenerateFileController::class, 'GenerateMigrationFile'])->name('migration.file');
            // Route::get('generate/model/{table_id}', [\App\Http\Controllers\MyStudio\GenerateFileController::class, 'GenerateModelFile'])->name('model.file');
            Route::get('file/migration/is_exist/{table_id}', [\App\Http\Controllers\MyStudio\FileGenerator\MigrationController::class, 'checkExistence'])->name('file.migration.is_exist');
            Route::get('file/migration/create/{table_id}', [\App\Http\Controllers\MyStudio\FileGenerator\MigrationController::class, 'create'])->name('file.migration.create');
            Route::get('file/model/create/{table_id}', [\App\Http\Controllers\MyStudio\FileGenerator\ModelController::class, 'create'])->name('file.model.create');
        });
    });

    // Table-Column Module Route
    Route::name('column.')->group(function () {
        Route::prefix('column/')->group(function () {
            Route::get('create/{table_id}', [\App\Http\Controllers\MyStudio\ColumnController::class, 'create'])->name('create');
            Route::get('show/{table_id}/{column_id}', [\App\Http\Controllers\MyStudio\ColumnController::class, 'show'])->name('show');
            Route::get('edit/{table_id}/{column_id}', [\App\Http\Controllers\MyStudio\ColumnController::class, 'edit'])->name('edit');
            Route::post('update/{table_id}/{column_id}', [\App\Http\Controllers\MyStudio\ColumnController::class, 'update'])->name('update');
        });
    });

    // Table-Relation Module Route
    Route::name('relation.')->group(function () {
        Route::prefix('table-relation/')->group(function () {
            Route::get('create/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'createRelation'])->name('createRelation');
            Route::post('store/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'storeRelation'])->name('storeRelation');
            Route::get('edit/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'editRelation'])->name('editRelation');
            Route::post('update/{table_id}', [\App\Http\Controllers\MyStudio\TableFieldController::class, 'updateRelation'])->name('updateRelation');
        });
    });

    // Form Module Route
    Route::name('form.')->group(function () {
        Route::prefix('form/')->group(function () {
            Route::get('index', [\App\Http\Controllers\MyStudio\FormController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\MyStudio\FormController::class, 'create'])->name('create');
            Route::post('store', [\App\Http\Controllers\MyStudio\FormController::class, 'store'])->name('store');
            Route::get('design-form/{form_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'designForm'])->name('designForm');
            Route::post('design-form/store/{form_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'storeForm'])->name('storeForm');
            Route::get('show-form/{form_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'showForm'])->name('showForm');
            Route::get('edit-form/{form_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'editForm'])->name('editForm');
            Route::post('update-form/{form_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'updateForm'])->name('updateForm');
            Route::delete('destroy/{form_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'destroy'])->name('destroy');

            // Generate Blade File
            Route::get('generate/blade/{form_id}', [\App\Http\Controllers\MyStudio\GenerateFileController::class, 'GenerateBladeFile'])->name('blade.file');

            //AJAX - get table column
            Route::get('getData/{table_id}', [\App\Http\Controllers\MyStudio\FormController::class, 'getData'])->name('getData');

            Route::get('file/data-table/create/{form_id}', [\App\Http\Controllers\MyStudio\FileGenerator\DataTablesController::class, 'create'])->name('file.data-table.create');
            Route::get('file/controller/create/{form_id}', [\App\Http\Controllers\MyStudio\FileGenerator\ControllerController::class, 'create'])->name('file.controller.create');
            Route::get('file/route/create/{form_id}', [\App\Http\Controllers\MyStudio\FileGenerator\RouteController::class, 'create'])->name('file.route.create');
        });
    });

    // Menu Module Route
    Route::name('menu.')->group(function () {
        Route::prefix('menu/')->group(function () {
            Route::get('show/', [\App\Http\Controllers\MyStudio\MenuController::class, 'show'])->name('show');
            Route::get('create/', [\App\Http\Controllers\MyStudio\MenuController::class, 'create'])->name('create');
            Route::post('store/', [\App\Http\Controllers\MyStudio\MenuController::class, 'store'])->name('store');
            Route::get('edit/', [\App\Http\Controllers\MyStudio\MenuController::class, 'edit'])->name('edit');
            Route::post('update/', [\App\Http\Controllers\MyStudio\MenuController::class, 'update'])->name('update');

            // GenerateMenuFile
            Route::get('file/menu/create/', [\App\Http\Controllers\MyStudio\GenerateFileController::class, 'GenerateMenuFile'])->name('file.menu.create');

        });
    });

    // List Module Route
    Route::name('list.')->group(function () {
        Route::prefix('list/')->group(function () {
            Route::get('index/', [\App\Http\Controllers\MyStudio\ListController::class, 'index'])->name('index');
            Route::get('create/', [\App\Http\Controllers\MyStudio\ListController::class, 'create'])->name('create');
            Route::post('store/', [\App\Http\Controllers\MyStudio\ListController::class, 'store'])->name('store');
            Route::get('edit/{list_id}', [\App\Http\Controllers\MyStudio\ListController::class, 'edit'])->name('edit');
            Route::post('update/{list_id}', [\App\Http\Controllers\MyStudio\ListController::class, 'update'])->name('update');
            Route::get('show/{list_id}', [\App\Http\Controllers\MyStudio\ListController::class, 'show'])->name('show');
        });
    });

    // Calendar Module Route
    Route::name('calendar.')->group(function () {
        Route::prefix('calendar/')->group(function () {
            Route::get('index/', [\App\Http\Controllers\MyStudio\CalendarController::class, 'index'])->name('index');
            Route::get('create/', [\App\Http\Controllers\MyStudio\CalendarController::class, 'create'])->name('create');
            Route::post('store/', [\App\Http\Controllers\MyStudio\CalendarController::class, 'store'])->name('store');
            Route::get('edit/{calendar_id}', [\App\Http\Controllers\MyStudio\CalendarController::class, 'edit'])->name('edit');
            Route::post('update/{calendar_id}', [\App\Http\Controllers\MyStudio\CalendarController::class, 'update'])->name('update');
            Route::get('show/{calendar_id}', [\App\Http\Controllers\MyStudio\CalendarController::class, 'show'])->name('show');

            Route::get('view/{calendar_id}', [\App\Http\Controllers\MyStudio\CalendarController::class, 'calendar'])->name('view');

        });
    });

    // Tabs Module Route
    Route::name('tabs.')->group(function () {
        Route::prefix('tabs/')->group(function () {
            Route::get('index/', [\App\Http\Controllers\MyStudio\TabController::class, 'index'])->name('index');
            Route::get('create/', [\App\Http\Controllers\MyStudio\TabController::class, 'create'])->name('create');
            Route::post('store/', [\App\Http\Controllers\MyStudio\TabController::class, 'store'])->name('store');
            Route::get('edit/{tab_id}', [\App\Http\Controllers\MyStudio\TabController::class, 'edit'])->name('edit');
            Route::post('update/{tab_id}', [\App\Http\Controllers\MyStudio\TabController::class, 'update'])->name('update');
            Route::get('show/{tab_id}', [\App\Http\Controllers\MyStudio\TabController::class, 'show'])->name('show');

            //AJAX - get form column
            Route::get('getData/{form_id}', [\App\Http\Controllers\MyStudio\TabController::class, 'getData'])->name('getData');
            //AJAX - get form table
            Route::get('getTable/{form_id}', [\App\Http\Controllers\MyStudio\TabController::class, 'getTable'])->name('getTable');
        });
    });

    // Migration Module Route
    Route::name('migration.')->group(function () {
        Route::prefix('migration/')->group(function () {
            Route::get('index/', [\App\Http\Controllers\MyStudio\MigrationController::class, 'index'])->name('index');

            Route::get('migrate/all/', [\App\Http\Controllers\MyStudio\MigrationController::class, 'migrateAll'])->name('migrate.all');
            Route::get('migrate/refresh/all/', [\App\Http\Controllers\MyStudio\MigrationController::class, 'migrateRefreshAll'])->name('migrate.refresh.all');
            Route::get('migrate/reset/all/', [\App\Http\Controllers\MyStudio\MigrationController::class, 'migrateReset'])->name('migrate.reset.all');

            Route::get('migrate/{name}', [\App\Http\Controllers\MyStudio\MigrationController::class, 'migrate'])->name('migrate');
            Route::get('migrate/fresh/{name}', [\App\Http\Controllers\MyStudio\MigrationController::class, 'migrateRefresh'])->name('migrate.fresh');
            Route::get('migrate/rollback/{name}', [\App\Http\Controllers\MyStudio\MigrationController::class, 'reset'])->name('migrate.rollback');

        });
    });

});

collect(glob(base_path('/routes/web/mystudio/*.php')))
    ->each(function ($path) {
        require $path;
    });
