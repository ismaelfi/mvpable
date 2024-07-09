<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DevSetup extends Command
{
    protected $signature = 'dev:setup';

    protected $description = 'Set up the development environment for the TALL SaaS project';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Installing Composer dependencies...');
        shell_exec('composer install');

        $this->info('Installing NPM dependencies...');
        shell_exec('npm install');

        if (! File::exists('.env')) {
            $this->info('Copying .env.example to .env...');
            File::copy('.env.example', '.env');
        }

        $this->info('Generating application key...');
        $this->call('key:generate');

        $this->info('Running database migrations and seeders...');
        $this->call('migrate');

        $this->info('Building front-end assets...');
        shell_exec('npm run build');

        $this->info('Creating symbolic link for storage...');
        $this->call('storage:link');

        $this->info('Configuring Git to use the custom hooks directory...');
        shell_exec('git config core.hooksPath .hooks');

        $this->info('Setup complete! To start the development server, run:');
        $this->line('php artisan serve');

        if ($this->confirm('Would you like to star the repository on GitHub?', true)) {
            $repoUrl = 'https://github.com/ismaelfi/saas-tall-starter';
            $this->info("Opening GitHub repository: $repoUrl");
            shell_exec("open $repoUrl");
        }

        $this->info('🚀 Development environment setup complete!');
    }
}
