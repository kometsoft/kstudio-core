<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DeleteMigration implements Processor
{
    private $migration;

    public function __construct($migration)
    {
        $this->migration = $migration;
    }

    public static function make($migration)
    {
        return new self($migration);
    }

    public function process()
    {
        try {
            if ($this->migration instanceof MyStudio) {
                // Delete migration file
                File::delete(database_path('migrations/mystudio/' . $this->migration->settings['file_name']));
                
                // Delete migration trail
                DB::statement("DELETE FROM migrations WHERE migration = '" . $this->migration->name . "'");

                // Delete migration record
                $this->migration->delete();

                logger()->info('Migration ' . ($this->migration->name ?? '') . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
