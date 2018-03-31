<?php

namespace App\Classes;

class RDNWorker { 
    
    public static function startQueueListenerJob() {
        // Initialize variables
        $path = base_path();
        $artisanCommand = $path . '/artisan queue:listen';
        $phpCommand = '/usr/bin/php -c ' . $path .'/php.ini ';
        $pid_file = $path . '/storage/framework/laravel-queue-listener.pid';
        $running = false;
        $tries = 3;
        
        // Check if queue listener pid file exists
        if (file_exists($pid_file)) {
            // Read pid from file
            $pid = file_get_contents($pid_file);
            
            // Get pid related path and command
            $result = exec("ps -fp $pid --no-heading | awk '{print $11, $12}'");
                
            // Check if is itself queue listener process
            $running = (strpos($result, $artisanCommand) !== false);
        }
        
        //  Up queue process if is not running
        if(!$running) {
            $command = $phpCommand . ' ' . $artisanCommand . ' --tries='. $tries. ' > /dev/null & echo $!';
            $number = exec($command);
            file_put_contents($pid_file, $number);
        }
    }
    
}