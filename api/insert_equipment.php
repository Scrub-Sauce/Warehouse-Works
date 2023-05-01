<?php
include("db_connect.php");

if(count($_REQUEST) != 3){
    $output[] = "Status: Error";
    $output[] = "MSG: Invalid number of arguments";
    $output[] = "Action: type, manufacture, and serial_num are the only accepted data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}

if(!isset($_REQUEST['type'])){
    $output[] = "Status: Error";
    $output[] = "MSG: Type data NULL";
    $output[] = "Action: Resend type data";
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
    $output[] = "MSG: Serial_num data NULL";
    $output[] = "Action: Resend Serial_num data";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $s_query = trim($_REQUEST['serial_num']);
    if($s_query == ''){
        $output[] = "Status: Error";
        $output[] = "MSG: Serial_num data NULL";
        $output[] = "Action: Resend Serial_num data";
        $responseData = json_encode($output);
        echo "$responseData";
        die();
    }
}

$db = db_iconnect('warehouse-works');
$time_start = microtime(true);

$t_found = false;
$m_found = false;

$sql = "SELECT * FROM `manufacture` WHERE `name` = '$m_query'";
$result = $db->query($sql) or
    die("Something went wrong with $sql<br>".$db->error);
$data = $result->fetch_array(MYSQLI_ASSOC);

if($data == NULL){
    $output[] = "Status: Error";
    $output[] = "MSG: Manufacture does not exist";
    $output[] = "Action: Insert Manufacture";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $m_query = $data['auto_id'];
    $m_found = true;
}

$sql = "SELECT * FROM `type` WHERE `name` = '$t_query'";
$result = $db->query($sql) or
    die("Something went wrong with $sql<br>".$db->error);
$data = $result->fetch_array(MYSQLI_ASSOC);
if($data == NULL){
    $output[] = "Status: Error";
    $output[] = "MSG: Type does not exist";
    $output[] = "Action: Insert Type";
    $responseData = json_encode($output);
    echo "$responseData";
    die();
}else{
    $t_query = $data['auto_id'];
    $t_found = true;
}

$sql = "SELECT * FROM `equipment` WHERE `serial_number` LIKE '$s_query'";
$result = $db->query($sql) or
    die("Something went wrong with $sql<br>".$db->error);
$data = $result->fetch_array(MYSQLI_ASSOC);

if(($data == NULL) && ($t_found) && ($m_found)){
    $sql = "INSERT INTO `equipment` (`type`, `manufacture`, `serial_number`) VALUES ('$t_query', '$m_query', '$s_query\r')";
    $db->query($sql) or
        die("Something went wrong with $sql<br>".$db->error);

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    $output[] = "Status: Success";
    $output[] = "MSG: Equipment successfully added.";
    $output[] = "Action: $execution_time";
    $responseData = json_encode($output);
    echo "$responseData";
}else{
    $output[] = "Status: Error";
    $output[] = "MSG: An equipment with the serial_num $s_query already exists";
    $output[] = "Action: Choose another serial number";
    $responseData = json_encode($output);
    echo "$responseData";
}