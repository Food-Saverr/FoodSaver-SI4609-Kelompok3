<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register CheckExpiringFood command
Artisan::command('food:check-expiring', function () {
    $this->call(\App\Console\Commands\CheckExpiringFood::class);
})->purpose('Check for food items that are about to expire and send notifications');

// Register RemoveExpiredFood command
Artisan::command('food:remove-expired', function () {
    $this->call(\App\Console\Commands\RemoveExpiredFood::class);
})->purpose('Remove expired food donations from the system');
