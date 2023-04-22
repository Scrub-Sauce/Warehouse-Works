<?php
include 'db_connect.php';

if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
    $time_start = microtime(true);

    $manufacture = $_POST['manufacture'];

    $db = db_iconnect('warehouse-works');
    $sql = "SELECT * FROM `manufacture` WHERE `name` ='$manufacture'";
    
    $result = $db->query($sql);
    $data = $result->fetch_array(MYSQLI_ASSOC);

    if($data == NULL) {
        $sql = "INSERT INTO `manufacture` (`name`) VALUES ('$manufacture')";
        $result= $db->query($sql) or
            die ("Something went wrong with $sql<br>".$db->error);
        echo "<h2>Manufacutre '$manufacture' successfully added.</h2>";
    } else {
        echo '<h2?>Error: Manufacture already exists</h2>';
    }

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
    echo '<a href="./search.php">Home</a>';
} else {
    $time_start = microtime(true);
    echo '<h2>Insert new manufacture</h2>';
    echo '<form method="post" action="">';
        echo '<label for="manufacture">Manufacture:</label>';
        echo '<input name="manufacture" type="text" class="input-field">';
        echo '<button type="submit" name="submit" value="submit" class="submit-button">Submit</button>';
    echo '</form>';
    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
    echo '<a href="./search.php">Home</a>';
}
?>