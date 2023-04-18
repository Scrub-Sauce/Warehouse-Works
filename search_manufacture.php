<?php
include 'db_connect.php';

if(isset($_POST['submit']) && ($_POST['submit'] == "submit"))
{
    $db = db_iconnect('warehouse-works');
    $time_start = microtime(true);
    $query = $_POST['manufacture'];
    $sql = "SELECT `name` FROM `manufacture` WHERE `auto_id` = '$query'";
    $result = $db->query($sql) or 
        die("Something went wrong with $sql<br>".$db->error);

    $manufacture = NULL;
    while($data = $result->fetch_array(MYSQLI_ASSOC))
    {
        $manufacture = $data['name'];
    }

    $sql = "SELECT `type`, `serial_number` FROM `equipment` WHERE `manufacture` = '$query'";
    $result = $db->query($sql) or 
        die("Something went wrong with $sql<br>".$db->error);
    echo '<h3>Search by manufacture: '.$manufacture.'</h3>';
    echo '<table>';
    echo '<tr><th>Type</th><th>Manufacture</th><th>Serial Number</th></tr>';
    while($data=$result->fetch_array(MYSQLI_ASSOC )){
        echo '<tr>';
            echo '<td>'.$data['type'].'</td>';
            echo '<td>'.$data['serial_number'].'</td>';
        echo '</tr>';
    }

    echo '</table>';


    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
} else {
    $db = db_iconnect('warehouse-works');
    $time_start = microtime(true);
    $sql = "SELECT * FROM `manufacture`";
    $result = $db->query($sql) or
        die("Something went wrong with: $sql<br>".$db->error);


    echo '<form method="post" action="">';
    echo '<select name="manufacture" id="">';
    while($data=$result->fetch_array(MYSQLI_ASSOC)){
        echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
    }

    // End of select
    echo '</select>';

    echo '<button type="submit" name="submit" value="submit">Submit</button>';

    // End of Form
    echo '</form>';

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
}


?>