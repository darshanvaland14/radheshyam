<?php

// namespace App\Console;

// use Illuminate\Console\Scheduling\Schedule;
// use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// class Kernel extends ConsoleKernel
// {
//     protected $commands = [
//         App\Ship\Commands\ExtendCheckinAutoMaticCommand::class,
//     ];

//     protected function schedule(Schedule $schedule)
//     {
//         // Schedule the extend:checkin command to run daily at 2:30 PM
//         $schedule->command('extendcheckin')
//                  ->dailyAt('13:00')
//                  ->timezone('Asia/Kolkata') // Adjust to your timezone
//                  ->appendOutputTo(storage_path('logs/laravel.log')); // Optional: Log command output

//         // $schedule->command('extendcheckin')->everyMinute();
//     }

//     protected function commands()
//     {
//         $this->load(__DIR__.'/Commands');
//         $this->load(base_path('app/Ship/Commands'));

//         require base_path('routes/console.php');
//     }
// }