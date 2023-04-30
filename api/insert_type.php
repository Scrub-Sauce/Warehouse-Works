<?php
include ('db_connect.php');

if(count($_REQUEST) != 1){
    $output[] = "Status: Error";
    $output[] = "MSG: Invalid number of arguments";
    $output[] = "Action: Only send manufacture data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}

if(!isset($_REQUEST['type'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Type data NULL";
    $output[] = "Action: Resend Type data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}

$type = $_REQUEST['type'];

$time_start = microtime(true);
$db = db_iconnect('warehouse-works');
$sql = "SELECT * FROM `type` WHERE `name` ='$type'";

$result = $db->query($sql) or
    die("Something went wrong with $sql".$db->error);
$data = $result->fetch_array(MYSQLI_ASSOC);

if($data == NULL) {
    $sql = "INSERT INTO `type` (`name`) VALUES ('$type')";
    $result= $db->query($sql) or
        die ("Something went wrong with $sql<br>".$db->error);

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    $output[] = "Status: Error";
    $output[] = "MSG: $type added successfully";
    $output[] = "Action: $execution_time";
    $responseData = json_encode($output);
    echo "$responseData";
} else {
    $output[] = "Status: Error";
    $output[] = "MSG: Provided type already exists";
    $output[] = "Action: None";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}