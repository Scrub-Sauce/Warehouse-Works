<?php

include 'db_connect.php';
$db = db_iconnect('warehouse-works');
$time_start = microtime(true);
$sql = "SELECT DISTINCT (`manufacture`) FROM `equipment`";
$result = $db->query($sql) or
    die("Something went wrong with: $sql<br>".$db->error);


echo '<form method="post" action="">';
echo '<select name="manufacture" id="">';
while($data=$result->fetch_array(MYSQLI_NUM)){
    echo '<option value="'.$data[0].'">'.$data[0].'</option>';
}

// End of select
echo '</select>';

// End of Form
echo '</form>';

$time_end = microtime(true);
$seconds = $time_end - $time_start;
$execution_time = ($seconds) / 60;

echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";

?>