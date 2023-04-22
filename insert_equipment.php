<?php
include 'db_connect.php';

echo '<!DOCTYPE html>';
echo '<html lang="en">';
    echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="stylesheet" href="main.css">';
        echo '<title>Search</title>';
    echo '</head>';
    echo '<body>';

if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
    $time_start = microtime(true);

    $t_query = $_POST['type'];
    $m_query = $_POST['manufacture'];
    $s_query = $_POST['serial_num'];

    $db = db_iconnect('warehouse-works');
    $sql = "SELECT `auto_id` FROM `equipment` WHERE `serial_number` LIKE '%$s_query%'";
    $result = $db->query($sql) or
        die("Something went wrong with $sql<br>".$db->error);
    $data = $result->fetch_array(MYSQLI_ASSOC);

    echo "<p>t_query: $t_query m_query: $m_query s_query: $s_query</p";

    if($data == NULL) {
        $sql = "INSERT INTO `equipment` (`type`, `manufacture`, `serial_number`) VALUES ('$t_query', '$m_query', '$s_query')";
        $db->query($sql) or
            die("Something went wrong with $sql<br>".$db->error);
        echo "<h2>Equipment: $t_query - $m_query - $s_query has been added to the database";

    } else {
        echo '<h2>Error: This equipment already exists. ID: '.$data['auto_id'];
    }

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
    echo '<a href="./search.php">Home</a>';
} else {
    $time_start = microtime(true);
    echo '<h1>Insert new equipment</h1>';
    echo '<form method="post" action="">';
        echo '<label for="type">Type: </label>';
        echo '<select name="type" id="type">';
            $db = db_iconnect('warehouse-works');
            $sql = "SELECT * FROM `type`";
            $result = $db->query($sql) or
                die("Something went wrong with: $sql<br>".$db->error);
            while($data=$result->fetch_array(MYSQLI_ASSOC)){
                echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
            }
        echo '</select>';
        echo '<label for="manufacture">Manufacture: </label>';
        echo '<select name="manufacture" id="manufacture">';
            $sql = "SELECT * FROM `manufacture`";
            $result = $db->query($sql) or
                die("Something went wrong with: $sql<br>".$db->error);
            while($data=$result->fetch_array(MYSQLI_ASSOC)){
                echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
            }
        echo '</select>';
        echo '<label for="serial_num">Serial Number: </label>';
        echo '<input type="text" name="serial_num" id="serial_num">';
        echo '<button name="submit" value="submit" type="submit">Submit</button>';
    echo '</form>';

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
    echo '<a href="./search.php">Home</a>';
}

echo '</body>';
echo '</html>';

?>