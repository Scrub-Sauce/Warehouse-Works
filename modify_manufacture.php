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
        $m_query = $_POST['manufacture'];
        $nt_query = $_POST['new_manufacture'];
        $s_query = $_POST['status_change'];

        $status_change = true;
        $name_change = true;

        if($nt_query == ''){
            $name_change = false;
        }
        if($s_query == '0') {
            $status_change = false;
        }

        $db = db_iconnect('warehouse-works');
        $sql="Set autocommit=0";
        $db->query($sql) or
            die("Something went wrong with $sql<br>".$db->error);
        if($name_change && !$status_change){
            $sql = "UPDATE `manufacture` SET `name` = '$nt_query' WHERE `auto_id` = '$m_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h2>ID: $m_query name has been updated.</h2>";
        }elseif(!$name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `manufacture` = '$m_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h2>ID: $m_query status has been updated.</h2>";
        }elseif($name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `manufacture` = '$m_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            $sql = "UPDATE `manufacture` SET `name` = '$nt_query' WHERE `auto_id` = '$m_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h2>ID: $m_query name and status have been updated.</h2>";
        }else{
            echo '<h2>No Values Changed.</h2>';
        }
        $sql="Commit";
        $db->query($sql) or
            die("Something went wrong with $sql<br>".$db->error);
        $sql="Set autocommit=1";
        $db->query($sql) or
            die("Something went wrong with $sql<br>".$db->error);
        $time_end = microtime(true);
        $seconds = $time_end - $time_start;
        $execution_time = ($seconds) / 60;

        echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
        echo '<a href="./search.php">Home</a>';

    } else {
        $time_start = microtime(true);
        echo '<h2>Modify Manufacture</h2>';
        echo '<form method="post" action="">';
            echo '<label for="manufacture">Manufacture: </label>';
            echo '<select name="manufacture" id="manufacture">';
                $db = db_iconnect('warehouse-works');
                $sql = "SELECT * FROM `manufacture`";
                $result = $db->query($sql) or
                    die("Something went wrong with: $sql<br>".$db->error);
                while($data=$result->fetch_array(MYSQLI_ASSOC)){
                    echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
                }
            echo '</select>';
            echo '<label for="status_change">Status: </label>';
            echo '<select name="status_change" id="status_change">';
                echo '<option value="0">No Change</option>';
                $sql = "SELECT * FROM `status`";
                $result = $db->query($sql) or
                    die("Something went wrong with: $sql<br>".$db->error);
                while($data=$result->fetch_array(MYSQLI_ASSOC)){
                    
                    echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
                }
            echo '</select>';
            echo '<label for="new_manufacture">New manufacture: </label>';
            echo '<input manufacture="text" name="new_manufacture">';
            echo '<button manufacture="submit" name="submit" value="submit">Submit</button>';
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