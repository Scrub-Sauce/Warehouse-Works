<?php

include 'db_connect.php';
$db = db_iconnect('warehouse-works');

$sql = "SELECT * FROM `manufacture`";
$manufacture_result = $db->query($sql) or
die("Something went wrong with: $sql<br>".$db->error);

while($item = $manufacture_result->fetch_array(MYSQLI_ASSOC)){
    $sql = "SELECT * FROM `equipment` WHERE `manufacture` = '$item[name]' limit 1000";
    $equipment_result = $db->query($sql) or
    die("Something went wrong with: $sql<br>".$db->error);

    while($data = $equipment_result->fetch_array(MYSQLI_ASSOC)){
        echo "<p>About to update $data[auto_id] with new manufacture:$item[name] from $data[manufacture]</p>";
        $sql = "UPDATE `equipment` SET `manufacture` = '$item[auto_id]' WHERE `auto_id` = '$data[auto_id]'";
        $db->query($sql) or
        die("Something went wrong with: $sql<br>".$db->error);
    }
}

echo "<p>Done</p>";
