<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DeployingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codiksh:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs some required commands after deployment';

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
        system('composer dump-autoload');
        system('composer dump-autoload -o');
        $this->call('clear-compiled');
        $this->call('optimize');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('config:clear');
        $this->call('version:absorb');
//        $this->call('optimize'); TODO - Removed optimize in the end, since, with this, we can not use env() directly within code, ot has to be through config only. And since, we do not know well about this, temporarily commenting the same.
        return 0;
    }
}
