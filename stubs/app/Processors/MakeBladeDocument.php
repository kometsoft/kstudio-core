<?php

namespace App\Processors;

use App\Contracts\Processor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeBladeDocument implements Processor
{
    private $form;
    private $type;

    public function __construct($form, string $type = '')
    {
        $this->form = $form;
        $this->type = $type;
    }

    public static function make($form, string $type = '')
    {
        return new self($form, $type);
    }

    public function process()
    {
        try {
            if (isset($this->form)) {
                $module = Str::of($this->form->name ?? '')->singular()->kebab();
                $form_id = $this->form->id;
                $type = '--all';

                if (!empty($this->type)) {
                    $type = '--' . $this->type;
                }
                
                Artisan::call("mystudio:view $module $form_id --force --partial $type");

                logger()->info('Generate view document for  ' . ($this->form->name ?? ''));
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
