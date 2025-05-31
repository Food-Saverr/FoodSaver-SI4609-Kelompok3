<?php

// Path ke direktori aplikasi Laravel
$appPath = __DIR__;
$logFile = $appPath . '/storage/logs/scheduler.log';

// Fungsi untuk logging
function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

try {
    // Log start
    writeLog("Starting scheduler...");

    // Jalankan scheduler Laravel
    $command = "cd {$appPath} && php artisan schedule:run";
    $output = [];
    $returnVar = 0;
    
    exec($command, $output, $returnVar);
    
    // Log output
    foreach ($output as $line) {
        writeLog($line);
    }
    
    // Log completion
    writeLog("Scheduler completed with return code: {$returnVar}");
} catch (Exception $e) {
    writeLog("Error: " . $e->getMessage());
} 