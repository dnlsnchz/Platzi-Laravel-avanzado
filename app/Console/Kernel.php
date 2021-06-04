<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendEmailVerificationCommand;
use App\Console\Commands\SendNewsLetterCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmailVerificationCommand::class,
        SendNewsLetterCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->command('inspire')
            ->sendOutputTo(storage_path('inspire.log'))
            ->hourly();

        $schedule->call(function () {
            echo 'Test';
        })
        ->sendOutputTo(storage_path('logs/test_schedule.log'))
        ->everyMinute()
            ->evenInMaintenanceMode();

        $schedule->command('send:newsletter --schedule')
            ->onOneServer()
            ->withoutOverlapping()
            ->mondays();

        $schedule->command(SendEmailVerificationCommand::class)
            ->onOneServer()
            ->withoutOverlapping()
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
