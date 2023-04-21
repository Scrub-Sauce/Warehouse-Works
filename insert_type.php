<?php
include 'db_connect.php';

if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
    $time_start = microtime(true);

    $type = $_POST['type'];

    $db = db_iconnect('warehouse-works');
    $sql = "SELECT * FROM `type` WHERE `name` ='$type'";
    
    $result = $db->query($sql);
    $count = $result->fetch_array(MYSQLI_ASSOC);

    echo '<pre>';
    var_dump($count);
    echo '</pre>';

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
} else {
    echo '<h2>Insert new type</h2>';
    echo '<form method="post" action="">';
        echo '<label for="type">Type:</label>';
        echo '<input name="type" type="text" class="input-field">';
        echo '<button type="submit" name="submit" value="submit" class="submit-button">Submit</button>';
    echo '</form>';
}
?>