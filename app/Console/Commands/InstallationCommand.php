<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codiksh:install-template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs template.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('migrate');
        $this->call('ide-helper:meta');
        $this->call('ide-helper:generate');
        $this->call('db:seed', ['--class' => 'RolesSeeder']);
        $this->call('db:seed', ['--class' => 'AdminSeeder']);
        $this->info('Installation completed! Serve the application to see it in action!');
        return 1;
    }
}
