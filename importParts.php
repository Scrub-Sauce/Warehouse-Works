<?php
    // Set Directory
    $dir = '/var/www/html/';

    //Scan directories files and form a filtered file list.
    $files = scandir($dir);
    $regex = '/^filtered.*/';
    $filteredFiles = array_filter($files, function($file) use ($regex) {
        return preg_match($regex, $file);
    });
    
    // Set a maximum number of import instances
    $concurrentProcesses = 1;

    // Create an empty process queue to store active processes
    $processQueue = [];

    // Iterate through each file and start an instance
    foreach ($filteredFiles as $key=>$value) {
        // Make sure process queue doesn't eceed to concurrent process maximum
        if(count($processQueue) < $concurrentProcesses){
            shell_exec("/usr/bin/php /var/www/html/importArgs.php $key $value > ./$value.log 2>./$value.log &");
            echo "Import of $value started.\n";
            $processQueue [] = $value;

        }else{
            while($processQueue >= $concurrentProcesses){
                $output = array();
                exec("ps -efa | grep $processQueue[0]", $output);
                if(count($output) < 3){
                    echo "Removing $processQueue[0] from the queue.";
                    array_shift($processQueue);
                    break;
                }else{
                    sleep(2);
                    echo "Waiting for a process to complete...\n";
                }
            }
            shell_exec("/usr/bin/php /var/www/html/importArgs.php $key $value > ./$value.log 2>./$value.log &");
            echo "Import of $value started.\n";
            $processQueue [] = $value;
        }
    }
?>
