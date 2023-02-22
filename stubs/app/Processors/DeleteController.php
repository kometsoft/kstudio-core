<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteController implements Processor
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
                $name = Str::of($this->form->name)->singular()->camel()->ucfirst() . 'Controller.php';

                // Delete controller
                File::delete(app_path('Http/Controllers/MyStudio/' . $name));

                logger()->info('Controller ' . $name . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
