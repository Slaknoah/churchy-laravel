<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;

use Illuminate\Console\Command;

class clearStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets storage system';

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
     * @return mixed
     */
    public function handle()
    {
        $directories = Storage::directories('/public');
        foreach($directories as $directory) {
            Storage::deleteDirectory($directory);
            Storage::makeDirectory($directory);
        }

        echo "Storage cleaned!" . "\n";
    }
}
