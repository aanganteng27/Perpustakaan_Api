<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // 1. Menjalankan pengingat pengembalian buku (H-1) jam 08:00 pagi
        $schedule->command('reminder:return-book')->dailyAt('08:00');

        // 2. Menjalankan pengecekan denda otomatis jam 01:00 pagi
        // Ini akan mencari buku yang lewat jatuh tempo dan membuat tagihan denda
        $schedule->command('fine:calculate')->dailyAt('01:00');
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