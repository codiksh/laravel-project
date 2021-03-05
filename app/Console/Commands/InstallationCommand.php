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
        system('npm install');
        $this->call('migrate');
        $this->call('codiksh:deploy');
        $this->call('ide-helper:meta');
        $this->call('ide-helper:generate');
        $this->call('db:seed', ['--class' => 'RolesSeeder']);
        $this->call('db:seed', ['--class' => 'AdminSeeder']);
        return 1;
    }
}
