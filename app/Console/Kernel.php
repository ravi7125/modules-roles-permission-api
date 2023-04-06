<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Jobs\UpdateIsNewFieldJob;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    // Run a callback every five minutes
    $schedule->call(function () {
        // Get all users created in the last 5 minutes
        $users = DB::table('users')->where('created_at', '>=', now()->subdays(2))->get();

        // Update the is_new field for new users
        foreach ($users as $user) {
            DB::table('users')->where('id', $user->id)->update(['is_new' => 1]);
        }

        // Set is_new to 0 for old users
        DB::table('users')->where('created_at', '<', now()->subdays(2))->update(['is_new' => 0]);
    })->dailyAt('01:15');
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
