<?php
include ('db_connect.php');

if(!isset($_REQUEST['type'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Type data NULL";
    $output[] = "Action: Resend Type data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $t_query = $_REQUEST['type'];
}

if(!isset($_REQUEST['manufacture'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Manufacture data NULL";
    $output[] = "Action: Resend Manufacture data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $m_query = $_REQUEST['manufacture'];
}

if(!isset($_REQUEST['status'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Status data NULL";
    $output[] = "Action: Resend Status data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $stat_query = $_REQUEST['status'];
}
if(!isset($_REQUEST['num'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Number of Results data NULL";
    $output[] = "Action: Resend Num data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $n_query = $_REQUEST['num'];
}

$s_query = $_REQUEST['serial_num'];

$info[] = array();

$db = db_iconnect('warehouse-works');
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
    $key = array_search($m_query, $m_map);
    $manufacture = "`manufacture` = '$key'";
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
    $key = array_search($t_query, $t_map);
    $type = "`type` = '$key'";
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
    $key = array_search($stat_query, $stat_map);
    $status = "`status` = '$key'";
}

// Form query and run it
$sql = "SELECT * FROM `equipment` WHERE $type AND $manufacture AND $status AND `serial_number` LIKE '%$s_query%' LIMIT $n_query";
$result = $db->query($sql) or
    die('Something went wrong with $sql'.$db->error);
while($data = $result->fetch_array(MYSQLI_ASSOC)){
    $serial_num = trim($data['serial_number']);
    $info[] = array($t_map[$data['type']], $m_map[$data['manufacture']], $serial_num, $stat_map[$data['status']]);
}
$infoData = json_encode($info);

$time_end = microtime(true);
$seconds = $time_end - $time_start;
$execution_time = ($seconds) / 60;

$output[] = "Status: Success";
$output[] = "MSG: $infoData";
$output[] = "Action: $execution_time";
$responseData = json_encode($output);
echo "$responseData";
