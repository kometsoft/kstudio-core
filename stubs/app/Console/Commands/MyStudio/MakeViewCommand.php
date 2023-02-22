<?php

namespace App\Console\Commands\MyStudio;

use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeViewCommand extends Command
{
    use \App\Traits\MyStudio;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'mystudio:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view file';

    /**
     * The type of view being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     *
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
        ? $customPath
        : __DIR__ . $stub;
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name, $dir = '')
    {
        $name = trim($name);
        $name = str_replace($this->rootNamespace(), '', $name);
        $name = str_replace('\\', '/', $name);

        $module = Str::of($this->getModuleInput())->kebab();

        return resource_path('views/mystudio/' . $module . $dir . '/' . Str::kebab($name) . '.blade.php');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/mystudio/views/' . $this->type . '.stub');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The module'],
            ['form', InputArgument::REQUIRED, 'The form id'],
        ];
    }

    /**
     * Get the desired class name from the input.
     */
    public function getModuleInput(): string
    {
        return trim($this->argument('module'));
    }

    /**
     * Get the desired class name from the input.
     */
    public function getFormInput(): int
    {
        return $this->argument('form');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->input->setOption('index', true);
            $this->input->setOption('create', true);
            $this->input->setOption('edit', true);
            $this->input->setOption('show', true);
        }

        if ($this->option('index')) {
            if ($this->option('partial')) {
                $this->createPartialViewFor('index');
            } else {
                $this->createViewFor('index');
            }
        }

        if ($this->option('create')) {
            $this->createViewFor('create');
        }

        if ($this->option('edit')) {
            $this->createViewFor('edit');
        }

        if ($this->option('show')) {
            $this->createViewFor('show');
        }
    }

    protected function createViewFor($name, $type = null, $dir = '')
    {
        $this->type = $type ?: $name;

        $path = $this->getPath($name, $dir);

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->info('View for ' . $this->getModuleInput() . ' - ' . $name . ' created successfully.');
    }

    protected function createPartialViewFor($name)
    {
        $this->createViewFor($name, $name . '-partial');

        $this->createViewFor($name, 'partials/' . $name, '/partials/list');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a all standard views - index, create, edit, show'],
            ['force', null, InputOption::VALUE_NONE, 'Create the file even if the file already exists'],
            ['partial', null, InputOption::VALUE_NONE, 'Create the view file with partial'],
            ['index', null, InputOption::VALUE_NONE, 'Create the index view file'],
            ['create', null, InputOption::VALUE_NONE, 'Create the create view file'],
            ['edit', null, InputOption::VALUE_NONE, 'Create the edit view file'],
            ['show', null, InputOption::VALUE_NONE, 'Create the show view file'],
            ['form', null, InputOption::VALUE_NONE, 'Form name of the view file'],
        ];
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if ($this->getFormInput()) {
            $form          = blade_content($this->getFormInput());
            $index_partial = 'mystudio.' . Str::of($this->getModuleInput())->kebab() . '.partials.list.index';

            return str_replace(
                [
                    '{{ form }}',
                    '{{ form_id }}',
                    '{{ title }}',
                    '{{ title_plural }}',
                    '{{ content_create }}',
                    '{{ content_edit }}',
                    '{{ content_show }}',
                    '{{ index_partial }}',
                ],
                [
                    $form['name'],
                    $form['id'],
                    $form['title'],
                    $form['title_plural'],
                    $form['content_create'],
                    $form['content_edit'],
                    $form['content_show'],
                    $index_partial,
                ],
                $stub
            );
        }

        return parent::replaceClass($stub, $name);
    }
}
