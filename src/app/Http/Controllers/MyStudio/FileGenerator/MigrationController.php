<?php

namespace App\Http\Controllers\MyStudio\FileGenerator;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use App\Processors\DeleteMigration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrationController extends Controller
{
    const NEW_LINE  = "\n";
    const SEPARATOR = "\t\t\t";

    public function create(Request $request, $id)
    {
        $table = MyStudio::find($id);

        if (!empty($table->settings)) {
            $table_name = Str::snake(Str::plural($table->name));
            $file_name  = $this->getFileName($table);

            // Load latest migration
            $files      = File::files(database_path('migrations/mystudio'));
            $file_names = [];

            foreach ($files as $file) {
                array_push($file_names, ['name' => basename($file)]);
            }

            // Get generated migration file
            $input = collect($file_names)->filter(function ($value, $key) use ($file_name) {
                return Str::endsWith($value['name'], $file_name . '.php');
            })->first();

            // try {
            // Insert migration data into my_studio table every time user generate migration file
            $migration = MyStudio::where('name', basename($input['name'], '.php'))->where('type', 'migration')->first();

            if (!$migration instanceof MyStudio) {
                $migration = MyStudio::create([
                    'name'        => basename($input['name'], '.php'),
                    'type'        => 'migration',
                    'description' => 'Table ' . $table_name . ' migration file',
                    'settings'    => [
                        'table_id'   => $id,
                        'table_name' => $table_name,
                        'file_name'  => $input['name'],
                    ],
                ]);
            }

            // Retrieve latest generated migration file
            $file = Storage::disk('migration')->get('mystudio/' . $input['name']);

            // Generate migration content based-on table settings
            $content = Str::replace('// {{ content }}', $this->generateContent($table), $file);

            // Write content to migration file
            Storage::disk('migration')->put('mystudio/' . $input['name'], $content);

            return redirect()->back()->with('success', 'Migration file successfully created');
            // } catch (\Throwable$th) {
            //     logger()->error($th->getMessage());

            //     return redirect()->back()->with('failed', 'Migration file failed to create. Exception: ' . $th->getMessage());
            // }
        } else {
            return redirect()->back()->with('failed', 'Migration file failed to create. Table column cannot be empty.');
        }
    }

    private function getFileName($table)
    {
        $table_name = Str::snake(Str::plural($table->name));
        $is_create  = true;

        if (1 == 1) {
            // Create New/Replace migration

            // Delete related existing migration
            $migrations = MyStudio::where('type', 'migrations')->where('settings->table_id', $table->id)->get();

            if ($migrations->count() > 0) {
                foreach ($migrations as $migration) {
                    // Delete migration
                    DeleteMigration::make($migration)->process();
                }
            }

            $file_name = 'create_' . $table_name . '_table';
        } else {
            // Alter migration
            $is_create = false;

            $file_name = 'alter_' . $table_name . '_table_' . date('His');
        }

        // Create migration file
        Artisan::call('mystudio:migration ' . $file_name . ' --create=' . $is_create . ' --table=' . $table_name);

        return $file_name;
    }

    private function generateContent($table)
    {
        $migration  = collect($table->settings['defaultMigration']);
        $softdelete = $migration->where('column_name', 'softDeletes()')->first();

        $content = '';
        $updated = [];

        // Migration Column
        if (data_get($table, 'settings.migrationProperties')) {
            foreach ($table->settings['migrationProperties'] as $key => $column) {
                // Not yet migrated column
                if (!data_get($column, 'is_migrated')) {
                    $length   = '';
                    $indexing = '';
                    $nullable = '';
                    $default  = '';
                    $comment  = '';

                    if (!empty($column['column_length'])) {
                        $length = ", " . $column['column_length'] . "";
                    }

                    if ($column['column_index'] === 'unique') {
                        $indexing = "->unique()";
                    } elseif ($column['column_index'] === 'index') {
                        $indexing = "->index()";
                    } elseif ($column['column_index'] === 'primary') {
                        $indexing = "->primary()";
                    }

                    if ($column['column_nullable'] === 'Yes') {
                        $nullable = "->nullable()";
                    }

                    if (!empty($column['column_default_value'])) {
                        $default = "->default('" . $column['column_default_value'] . "')";
                    }

                    if (!empty($column['column_comment'])) {
                        $comment = "->comment('" . $column['column_comment'] . "')";
                    }

                    $content .= "\$table->{$column['column_type']}('{$column['column_name']}'{$length}){$indexing}{$nullable}{$default}{$comment};" . self::NEW_LINE . self::SEPARATOR;

                    // Update column is_migrated flag
                    $updated['settings->migrationProperties->' . $key . '->is_migrated'] = true;
                }
            }

            if ($softdelete['column_enable'] ?? '' == 'Yes') {
                $content .= "\$table->softDeletes();" . self::NEW_LINE;
            }
        }

        if (data_get($table, 'settings.updatedMigration')) {
            foreach ($table->settings['updatedMigration'] as $key => $column) {
                // Not yet migrated column
                if (!data_get($column, 'is_migrated')) {
                    // Update column is_migrated flag
                    $updated['settings->updatedMigration->' . $key . '->is_migrated'] = true;
                }
            }
        }

        if (data_get($table, 'settings.deletedMigration')) {
            foreach ($table->settings['deletedMigration'] as $key => $column) {
                // Not yet migrated column
                if (!data_get($column, 'is_migrated')) {
                    // Update column is_migrated flag
                    $updated['settings->deletedMigration->' . $key . '->is_migrated'] = true;
                }
            }
        }

        // Save updated info
        if (!empty($updated)) {
            $table->update($updated);
        }

        return $content;
    }

    // AJAX check table existence in database
    public function checkExistence($table_id)
    {
        $table = MyStudio::find($table_id);

        $table_name = Str::snake(Str::plural($table->name));

        // Check table existence
        $data = [
            'is_exist' => Schema::hasTable($table_name),
        ];

        return $data;
    }
}
