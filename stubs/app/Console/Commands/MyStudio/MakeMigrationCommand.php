<?php

namespace App\Console\Commands\MyStudio;

use Illuminate\Console\Command;

class MakeMigrationCommand extends Command
{
    use \App\Traits\MyStudio;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mystudio:migration {name : The name of the migration}
                            {--create= : The table to be created}
                            {--path= : The migration path to be created}
                            {--table= : The table to migrate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new MyStudio migration file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $parameters = [
            'name' => trim($this->argument('name')),
            '--path' => $this->getMigrationPath(),
            '--realpath' => true,
            '--quiet' => true,
        ];

        if ($this->option('create')) {
            $parameters['--create'] = $this->option('create');
        }

        if ($this->option('table')) {
            $parameters['--table'] = $this->option('table');
        }

        $this->call('make:migration', $parameters);
        $this->info('MyStudio migration created successfully.');

        return Command::SUCCESS;
    }
}
