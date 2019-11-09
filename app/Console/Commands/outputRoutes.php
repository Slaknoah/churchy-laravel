<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class outputRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:output';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Outputs routes list to csv file';

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
        $routes = Route::getRoutes();

        // routes file
        $file = public_path('routes.csv');

        if(!\file_exists($file) || !\is_readable($file)) 
            Storage::put('routes.csv', '');
        
        if( ($fp = fopen($file, 'w')) !== false) {
            fputcsv($fp, ['METHOD', 'URI', 'NAME', str_pad("ACTION", 150, ' ')]);
            foreach ($routes as $route) {
                fputcsv($fp, [head($route->methods()) , $route->uri(), $route->getName(), $route->getActionName()]);
            }
            fclose($fp);  
            echo "File created successfully!\n";
        } else {
            echo "Failed to open file!\n";
        }
        
    }
}
