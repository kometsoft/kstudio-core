<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteRoute implements Processor
{
    private $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    public static function make($form)
    {
        return new self($form);
    }

    public function process()
    {
        try {
            if ($this->form instanceof MyStudio) {
                $name = Str::of($this->form->name)->singular()->lower()->kebab();
                $file = $name . '.php';

                // Delete route file
                File::delete(base_path('routes/web/mystudio/' . $file));

                logger()->info('Route ' . ($name ?? '') . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
