<?php

namespace App\Containers\AppSection\Checkin\UI\CLI\Commands;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Commands\ConsoleCommand;
use App\Ship\Transporters\DataTransporter;
use Log;
use Illuminate\Support\Facades\App;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Artisan;
use App\Containers\AppSection\Checkin\Tasks\ExtendCheckinDailyAutomaticTask;
/**
* Class ScheduleRemoveLogsCommand
*
* @author  Johannes Schobel <johannes.schobel@googlemail.com>
*/
class ExtendCheckinAutoMaticCommand extends ConsoleCommand
{
 
    protected $signature = 'extend:checkin';

    protected $description = 'Check In Extend Automatic';
 
    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }
 
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
       
        Log::info('ExtendCheckinAutoMatic command started at ' . now());

        $task = app(ExtendCheckinDailyAutomaticTask::class);
        $result = $task->run(); 
        // $result = 1;
        Log::info('ExtendCheckinAutoMatic command executed successfully', ['result' => $result]);

        $this->info('Check-in task completed successfully!');
    }
 
 
}