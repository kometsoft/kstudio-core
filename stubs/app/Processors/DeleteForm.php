<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteForm implements Processor
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
                $this->deleteDependency();
                $this->deleteForm();

                logger()->info('Form ' . ($this->form->name ?? '') . ' successfully deleted by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }

    public function deleteForm()
    {
        // Delete form's view directory
        File::deleteDirectory(resource_path('views/mystudio/' . Str::of($this->form->name ?? '')->singular()->kebab()));

        // Delete form record
        $this->form->delete();
    }

    public function deleteDependency()
    {
        // Delete route
        DeleteRoute::make($this->form)->process();

        // Delete controller
        DeleteController::make($this->form)->process();

        // Delete datatable
        DeleteDataTable::make($this->form)->process();

        // Delete permission
        DeletePermission::make($this->form)->process();
    }
}
