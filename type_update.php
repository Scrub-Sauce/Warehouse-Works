<?php

include 'db_connect.php';
$db = db_iconnect('warehouse-works');

$sql = "SELECT * FROM `type`";
$type_result = $db->query($sql) or
    die("Something went wrong with: $sql<br>".$db->error);

while($item = $type_result->fetch_array(MYSQLI_ASSOC)){
    $sql = "SELECT * FROM `equipment` WHERE `type` = '$item[name]' limit 6000";
    $equipment_result = $db->query($sql) or
        die("Something went wrong with: $sql<br>".$db->error);

    while($data = $equipment_result->fetch_array(MYSQLI_ASSOC)){
        echo "<p>About to update $data[auto_id] with new type:$item[name] from $data[type]</p>";
        $sql = "UPDATE `equipment` SET `type`='$item[auto_id]' WHERE `auto_id` = '$data[auto_id]'";
        $db->query($sql) or
            die("Something went wrong with: $sql<br>".$db->error);
    }
}

echo "<p>Done</p>";

?>


