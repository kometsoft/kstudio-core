<?php

namespace App\Console\Commands\MyStudio;

use Illuminate\Foundation\Console\ModelMakeCommand as Command;

class MakeModelCommand extends Command
{
    use \App\Traits\MyStudio;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'mystudio:model';
}
