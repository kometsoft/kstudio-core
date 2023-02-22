<?php

namespace App\Console\Commands\MyStudio;

use Illuminate\Routing\Console\ControllerMakeCommand as Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends Command
{
    use \App\Traits\MyStudio;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mystudio:controller';

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\MyStudio';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }

    /**
    * Get the console command options.
    *
    * @return array
    */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The name of the model'],
            ['module', 'd', InputOption::VALUE_OPTIONAL, 'The name of the module'],
        ]);
    }

    protected function getStub()
    {
        $stub = null;

        if ($this->option('resource')) {
            $stub = '/stubs/mystudio/controller.stub';
        } else {
            $stub = parent::getStub();
        }

        return $this->resolveStubPath($stub);
    }

    protected function replaceNamespace(&$stub, $name)
    {
        parent::replaceNamespace($stub, $name);

        $searches = [
            ['DummyModel', 'DummyDataTable', 'DummyModule'],
            ['{{ model }}', '{{ dataTable }}', '{{ module }}'],
            ['{{model}}', '{{dataTable}}', '{{module}}'],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getModel(), $this->getDataTable(), $this->getModule()],
                $stub
            );
        }

        return $this;
    }

    protected function getModel()
    {
        $_model = Str::replace('App\Models\MyStudio\\', '', $this->option('model')) ?: Str::replace('Controller', '', $this->argument('name'));

        return ucfirst(Str::camel(trim($_model)));
    }

    protected function getDataTable()
    {
        return ucfirst(Str::camel(trim(Str::replace('Controller', '', $this->argument('name'))))) . 'DataTable';
    }

    protected function getModule()
    {
        $_module = trim($this->option('module')) ?: Str::replace('Controller', '', $this->argument('name'));

        return Str::kebab($_module);
    }
}
