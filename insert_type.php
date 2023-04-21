<?php
include 'db_connect.php';

if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
    $time_start = microtime(true);

    $type = $_POST['type'];

    $db = db_iconnect('warehouse-works');
    $sql = "SELECT COUNT(*) FROM `type` WHERE `name` ='$type'";
    
    $result = $db->query($sql);
    $count = $result->fetchColumn();

    if($count > 0) {
        echo '<h2?>Error: type already exists</h2>';
    } else {
        $sql = "INSERT INTO `type` (`name`) VALUES ('$type')";
        $result= $db->query($sql) or
            die ("Something went wrong with $sql<br>".$db->error);

        echo "<h2>Type '$type' successfully added.</h2>";
    }

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
} else {
    echo '<h2>Insert new Type</h2>';
    echo '<form method="post" action="">';
        echo '<label for="type">Type:</label>';
        echo '<input name="type" type="text" class="input-field">';
        echo '<button type="submit" name="submit" value="submit" class="submit-button">Submit</button>';
    echo '</form>';
}
?>