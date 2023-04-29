<?php
include ('db_connect.php');

$db = db_iconnect('warehouse-works');

$m_query = $_REQUEST['manufacture'];
$t_query = $_REQUEST['type'];
$n_query = $_REQUEST['num'];
$s_query = $_REQUEST['serial_num'];
$stat_query = $_REQUEST['status'];
$info[] = array();

$time_start = microtime(true);
// Create a map of all manufacturers so we don't need to make additional queries.
$sql = "SELECT `auto_id`, `name` FROM `manufacture`";
$result = $db->query($sql) or
die("Something went wrong with $sql<br>".$db->error);
$m_map = array();
foreach($result as $row){
    $m_map[$row['auto_id']] = $row['name'];
}

// Check value of Manufacture
if($m_query == 'all'){
    $manufacture = "`manufacture` LIKE '%'";
}else{
    $manufacture = "`manufacture` = '$m_query'";
}

// Create a map of all types so we don't need unnecessary queries.
$sql = "SELECT `auto_id`, `name` FROM `type`";
$result = $db->query($sql) or
die("Something went wrong with $sql<br>".$db->error);
$t_map = array();
foreach($result as $row){
    $t_map[$row['auto_id']] = $row['name'];
}

// Check Value of type
if($t_query == 'all'){
    $type = "`type` LIKE '%'";
}else{
    $type = "`type` = '$t_query'";
}

// Create a map of all Statuses so we don't need unnecessary queries.
$sql = "SELECT * FROM `status`";
$result = $db->query($sql) or
die("Something went wrong with $sql<br>".$db->error);
$stat_map = array();
foreach($result as $row){
    $stat_map[$row['auto_id']] = $row['name'];
}

// Check value of status
if($s_query == 'all'){
    $status = "`status` LIKE '%'";
}else{
    $status = "`status` = '$stat_query";
}

$sql = "SELECT * FROM `equipment` WHERE $type AND $manufacture AND $status AND `serial_number` LIKE '%$s_query%' LIMIT $n_query";
echo("$sql");
$result = $db->query($sql) or
    die('Something went wrong with $sql'.$db->error);
while($data = $result->fetch_array(MYSQLI_ASSOC)){
    $info[] = array($data['auto_id'], $t_map[$data['type']], $m_map[$data['manufacture']], $data['serial_number'], $stat_map[$data['status']]);
}

$time_end = microtime(true);
$seconds = $time_end - $time_start;
$execution_time = ($seconds) / 60;

$output[] = "Status: Success";
$output[] = "MSG: $info";
$output[] = "Action: $execution_time";
$responseData = json_encode($output);
echo "$responseData";

echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
echo '<a href="./search.php">Home</a>';