<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DeleteTable implements Processor
{
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public static function make($table)
    {
        return new self($table);
    }

    public function process()
    {
        try {
            if ($this->table instanceof MyStudio) {
                $this->deleteDependency();
                $this->deleteTable();

                logger()->info('Table ' . ($this->table->name ?? '') . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }

    public function deleteTable()
    {
        // Delete model
        DeleteModel::make($this->table)->process();

        // Delete migration
        $migrations = MyStudio::where('type', 'migration')->where('settings->table_id', $this->table->id)->get();

        if ($migrations->count() > 0) {
            foreach ($migrations as $migration) {
                // Delete migration
                DeleteMigration::make($migration)->process();
            }
        }

        // Drop table
        $table_name = Str::snake(Str::plural($this->table->name));

        // Drop table
        if (Schema::hasTable($table_name)) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::statement('DROP TABLE ' . $table_name . '');
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

            logger()->info('Table ' . ($this->table->name ?? '') . ' successfully deleted from database by ' . auth()->user()->name . '.');
        }

        $this->table->delete();
    }

    public function deleteDependency()
    {
        $forms = MyStudio::where('type', 'form')->whereJsonContains('settings->tableForm', array(['table_id' => "" . $this->table->id]))->get();

        if ($forms->count() > 0) {
            foreach ($forms as $form) {
                // Delete form
                DeleteForm::make($form)->process();
            }
        }
    }
}
