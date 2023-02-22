<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteModel implements Processor
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
                $name = Str::of($this->table->name)->singular()->camel()->ucfirst();
                $file = $name . '.php';

                // Delete model file
                File::delete(base_path('/app/Models/MyStudio/' . $file));

                logger()->info('Model ' . ($name ?? '') . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
