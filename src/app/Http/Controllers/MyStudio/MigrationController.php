<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MigrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $migrations = MyStudio::where('type', 'migration')->get();
        $migrated   = DB::table('migrations')->get()->pluck('migration', 'id')->all();

        return view('mystudio.migration.index', [
            'migrations' => $migrations,
            'migrated'   => $migrated,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Run Migration Command

    // Migrate all
    public function migrateAll()
    {
        Artisan::call('migrate --force --path=/database/migrations/mystudio/');

        return redirect()->back()->with('success', 'All Migration file successfully migrate');
    }

    // Migrate refresh all
    public function migrateRefreshAll()
    {
        Artisan::call('migrate:refresh --force --path=/database/migrations/mystudio/');

        return redirect()->back()->with('success', 'All Migration file successfully migrate');
    }

    // Migrate rollback all
    public function migrateReset()
    {
        // rollback all migration file inside mystudio folder
        Artisan::call('migrate:reset --force --path=/database/migrations/mystudio/');

        return redirect()->back()->with('success', 'All Migration file reset successfully');
    }

    // Migrate specific file
    public function migrate($name)
    {
        Artisan::call('migrate --force --path=/database/migrations/mystudio/' . $name . '.php');

        return redirect()->back()->with('success', 'Migration file (' . $name . ') successfully migrate.');
    }

    // Migrate refresh specific file
    public function migrateRefresh($name)
    {
        Artisan::call('migrate:refresh --force --path=/database/migrations/mystudio/' . $name . '.php');

        return redirect()->back()->with('success', 'Migration file (' . $name . ') has been refresh successfully');
    }

    // Migrate rollback specific file
    public function reset($name)
    {
        Artisan::call('migrate:rollback --force --path=/database/migrations/mystudio/' . $name . '.php');

        return redirect()->back()->with('success', 'Migration file (' . $name . ') has been rollback successfully');
    }

}
