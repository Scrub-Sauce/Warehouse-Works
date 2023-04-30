<?php
include ('db_connect.php');

if(!isset($_REQUEST['manufacture'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Manufacture data NULL";
    $output[] = "Action: Resend manufacture data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}

$manufacture = $_REQUEST['manufacture'];

$time_start = microtime(true);
$db = db_iconnect('warehouse-works');
$sql = "SELECT * FROM `manufacture` WHERE `name` ='$manufacture'";

$result = $db->query($sql) or
die("Something went wrong with $sql".$db->error);
$data = $result->fetch_array(MYSQLI_ASSOC);

if($data == NULL) {
    $sql = "INSERT INTO `manufacture` (`name`) VALUES ('$manufacture')";
    $result= $db->query($sql) or
    die ("Something went wrong with $sql<br>".$db->error);

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    $output[] = "Status: Error";
    $output[] = "MSG: $manufacture added successfully";
    $output[] = "Action: $execution_time";
    $responseData = json_encode($output);
    echo "$responseData";
} else {
    $output[] = "Status: Error";
    $output[] = "MSG: Provided manufacture already exists";
    $output[] = "Action: None";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}