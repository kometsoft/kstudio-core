<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use App\Models\Permission;
use Illuminate\Support\Str;

class DeletePermission implements Processor
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
                $name = Str::of($this->form->name)->lower()->kebab();

                Permission::where('name', $name . ':list')->delete();
                Permission::where('name', $name . ':create')->delete();
                Permission::where('name', $name . ':edit')->delete();
                Permission::where('name', $name . ':show')->delete();

                logger()->info('Permission ' . $name . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }
}
