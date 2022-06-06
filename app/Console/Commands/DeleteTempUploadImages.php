<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteTempUploadImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp-uploads:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete temporary uploads media of login user form media table';

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
        Media::where('collection_name', 'temp-uploads')
            ->where('created_at', '<=', Carbon::now()->subHour()->toDateTimeString())
            ->delete();
        $this->info(' Deleted successfully!');
        return 0;
    }
}
