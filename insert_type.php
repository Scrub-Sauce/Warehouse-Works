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

    $type = $_POST['type'];

    $db = db_iconnect('warehouse-works');
    $sql = "SELECT * FROM `type` WHERE `name` ='$type'";
    
    $result = $db->query($sql);
    $data = $result->fetch_array(MYSQLI_ASSOC);

    if($data == NULL) {
        $sql = "INSERT INTO `type` (`name`) VALUES ('$type')";
        $result= $db->query($sql) or
            die ("Something went wrong with $sql<br>".$db->error);
        echo "<h2>Type '$type' successfully added.</h2>";
    } else {
        echo '<h2?>Error: type already exists</h2>';
    }

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
    echo '<a href="./search.php">Home</a>';
} else {
    $time_start = microtime(true);
    echo '<h2>Insert new type</h2>';
    echo '<form method="post" action="">';
        echo '<label for="type">Type:</label>';
        echo '<input name="type" type="text" class="input-field">';
        echo '<button type="submit" name="submit" value="submit" class="submit-button">Submit</button>';
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