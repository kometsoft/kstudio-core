<?php

namespace App\Console\Commands\MyStudio;

use Yajra\DataTables\Generators\DataTablesMakeCommand as Command;

class MakeDataTablesCommand extends Command
{
    use \App\Traits\MyStudio;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'mystudio:datatables
                            {name : The name of the DataTable.}
                            {--model= : The name of the model to be used.}
                            {--model-namespace= : The namespace of the model to be used.}
                            {--action= : The path of the action view.}
                            {--table= : Scaffold columns from the table.}
                            {--builder : Extract html() to a Builder class.}
                            {--force : Create the class even if the DataTable already exists.}
                            {--dom= : The dom of the DataTable.}
                            {--buttons= : The buttons of the DataTable.}
                            {--columns= : The columns of the DataTable.}';

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\DataTables\MyStudio';
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/mystudio/datatables.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

}
