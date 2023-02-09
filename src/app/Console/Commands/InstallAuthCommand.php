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
    protected $signature = 'auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the auth resources.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->runCommands(['php artisan ui bootstrap --auth']);

        $this->callSilent('vendor:publish', ['--tag' => 'laravel-auth-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-auth-assets', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-auth-stubs', '--force' => true]);

        $this->runCommands([
            'npm install @tabler/core laravel-datatables-vite nouislider litepicker tom-select alpinejs autosize imask',
            'npm run build',
        ]);
        
        $this->line('');
        $this->components->info('Auth scaffolding installed successfully.');
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
