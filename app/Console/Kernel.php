<?php

namespace App\Console;

use App\Console\Commands\IncrementEmployeesBalance;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command(IncrementEmployeesBalance::class);

        // Database Backup
        $schedule->command('backup:run --only-db')
            ->twiceDaily(1, 18) // 1:00 AM and 6:00 PM
            ->onFailure(function () {
                Log::error('Backup task failed.');
            });

        // Backup Cleanup
        $schedule->command('backup:clean')->weekly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
