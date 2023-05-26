<?php

namespace App\Console\Commands;

use RuntimeException;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallAuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kstudio:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the kstudio core.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->runCommands(['php artisan ui bootstrap --auth']);

        $this->runCommands(['composer require laravel/ui']);
        $this->runCommands(['php artisan ui bootstrap --auth']);

        $this->runCommands(['composer require kometsoft/laravel-ui']);
        $this->runCommands(['php artisan vendor:publish --tag=ui-resources --force']);
        $this->runCommands(['npm install']);
        $this->runCommands(['npm i @tabler/core@1.0.0-beta17 bootstrap@5.3.0-alpha1 @tabler/icons-webfont autosize imask litepicker tom-select']);
        $this->runCommands(['npm run build']);

        $this->callSilent('vendor:publish', ['--tag' => 'kstudio-controller', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'kstudio-model', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'kstudio-view', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'kstudio-route', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'kstudio-stubs', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'kstudio-support', '--force' => true]);

        // $this->runCommands([
        //     'npm install @tabler/core laravel-datatables-vite nouislider litepicker tom-select alpinejs autosize imask',
        //     'npm run build',
        // ]);
        
        // $this->line('');
        // $this->components->info('KStudio Controller installed successfully.');
    }

    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}
