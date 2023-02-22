<?php

namespace App\Console\Commands\MyStudio;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeRouteCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mystudio:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new route';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('resource')) {
            return $this->resolveStubPath('/stubs/mystudio/route-resource.stub');
        }

        return $this->resolveStubPath('/stubs/mystudio/route.stub');
    }

    /**
     * Get the destination class path.
     *
    * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::of($name)
            ->replaceFirst($this->rootNamespace(), '')
            ->lower()
            ->kebab();

        return base_path('/routes/web/mystudio/'.str_replace('\\', '/', $name).'.php');
    }

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
                        : __DIR__.$stub;
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
        if ($this->option('resource')) {
            return str_replace(
                ['{{ uri }}', '{{ class }}'],
                [
                    Str::of($name)
                        ->replace($this->getNamespace($name).'\\', '', $name)
                        ->singular()
                        ->lower()
                        ->kebab(),
                    $this->option('resource').'::class',
                ],
                $stub
            );
        }

        return parent::replaceClass($stub, $name);
    }

    /**
    * Get the console command options.
    *
    * @return array
    */
    protected function getOptions()
    {
        return [
            ['resource', 'r', InputOption::VALUE_REQUIRED, 'Create a resourceful route'],
        ];
    }
}
