<?php
function db_iconnect($dbName) {
    $un = "root";
    $pw = "+0j8ci*Bpfh->Dwt";
    $db = $dbName;
    $hostname = "localhost";
    $dblink = new mysqli($hostname, $un, $pw, $db);
    return $dblink;
}

$dblink = db_iconnect("warehouse-works");
echo "Hello from php process $argv[1] about to process file: $argv[2]\n";
$fp = fopen("/var/www/html/$argv[2]","r");
$count = 0;
$time_start = microtime(true);
echo "<p>PHP ID: $argv[1] - Start time is: $time_start</p>";
$sql="Set autocommit=0";
$dblink->query($sql) or
    die("Something went wrong with $sql<br>\n".$dblink->error);
while (($row=fgetcsv($fp)) !== FALSE) {
    $sql = "INSERT IGNORE INTO `equipment` (`type`, `manufacture`, `serial_number`) VALUES ('$row[0]', '$row[1]', '$row[2]')";
    $dblink->query($sql) or
        die("Something went wrong with $sql<br>".$dblink->error);
    $count++;
}
$sql="Commit";
$dblink->query($sql) or
    die("Something went wrong with $sql<br>\n".$dblink->error);
$time_end = microtime(true);
echo "<p>PHP ID: $argv[1] - End Time: $time_end</p>\n";
$seconds= $time_end - $time_start;
$execution_time = ($seconds)/60;
$rowsPerSecond = $count/$seconds;
echo "<p>PHP ID: $argv[1] - Insert Rate: $rowsPerSecond per second</p>"
?>
