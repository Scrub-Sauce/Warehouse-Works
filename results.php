<?php
include 'db_connect.php';
$db = db_iconnect('warehouse-works');
$time_start = microtime(true);

$query = $_POST['manufacture'];
if(isset($_POST['submit']) && ($_POST['submit'] == "submit"))
{
    $sql = "SELECT `type`, `serial_number` FROM `equipment` WHERE `manufacture` = '$query'";
    $result = $db->query($sql) or 
        die("Something went wrong with $sql<br>".$db->error);
    echo '<h3>Search by manufacture: '.$query.'</h3>';
    echo '<table>';
    echo '<tr><th>Type</th><th>Manufacture</th><th>Serial Number</th></tr>';
    while($data=$result->fetch_array(MYSQLI_ASSOC )){
        echo '<tr>';
            echo '<td>'.$data['type'].'</td>';
            echo '<td>'.$query.'</td>';
            echo '<td>'.$data['serial_number'].'</td>';
        echo '</tr>';
    }

    echo '</table>';


    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
} else {
    echo "<h2>204: No Content<h2><p>To properly use this page submit a request at the <a href='./search_manufacture.php'>Search Manufacture</a> page</p>";
}
?>