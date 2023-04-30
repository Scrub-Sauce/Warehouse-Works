<?php
$time_start = microtime(true);

//if(count($_REQUEST) != 3){
//    $output[] = "Status: Error";
//    $output[] = "MSG: Invalid number of arguments";
//    $output[] = "Action: type, manufacture, and serial_num are the only accepted data";
//    $responseData = json_encode($output);
//    echo "$responseData";
//    die();
//}

if(!isset($_REQUEST['type'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Manufacture data NULL";
    $output[] = "Action: Resend manufacture data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $t_query = $_REQUEST['type'];
}

if(!isset($_REQUEST['manufacture'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Manufacture data NULL";
    $output[] = "Action: Resend manufacture data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $m_query = $_REQUEST['manufacture'];
}

if(!isset($_REQUEST['serial_num'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Manufacture data NULL";
    $output[] = "Action: Resend manufacture data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $s_query = $_REQUEST['serial_num'];
}

$db = db_iconnect('warehouse-works');
$sql = "SELECT `auto_id` FROM `equipment` WHERE `serial_number` LIKE '%$s_query%'";
$result = $db->query($sql) or
    die("Something went wrong with $sql<br>".$db->error);
$data = $result->fetch_array(MYSQLI_ASSOC);

echo "<h2>$data</h2>";

//if($data ==NULL){
//    $sql = "INSERT INTO `equipment` (`type`, `manufacture`, `serial_number`) VALUES ('$t_query', '$m_query', '$s_query')";
//    $db->query($sql) or
//        die("Something went wrong with $sql<br>".$db->error);
//
//    $time_end = microtime(true);
//    $seconds = $time_end - $time_start;
//    $execution_time = ($seconds) / 60;
//
//    $output[] = "Status: Success";
//    $output[] = "MSG: Equipment successfully added.";
//    $output[] = "Action: $execution_time";
//    $responseData = json_encode($output);
//}else{
//    $output[] = "Status: Error";
//    $output[] = "MSG: An equipment with the serial_num $s_query already exists";
//    $output[] = "Action: None";
//    $responseData = json_encode($output);
//    echo "$responseData";
//}