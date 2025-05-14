<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar command yang tersedia di aplikasi.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendExpiredReminders::class,
    ];

    /**
     * Menentukan jadwal perintah aplikasi.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Jalankan pengiriman notifikasi setiap hari jam 9 pagi
        $schedule->command('reminders:send-expired')
                 ->dailyAt('09:00')
                 ->timezone('Asia/Jakarta');
    }

    /**
     * Daftarkan perintah untuk aplikasi.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}