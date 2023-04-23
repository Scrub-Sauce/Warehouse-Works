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

        $id_query = $_POST['auto_id'];
        $t_query = $_POST['type'];
        $m_query = $_POST['manufacture'];
        $serial_query = $_POST['serial_num'];
        $s_query = $_POST['status_change'];

        $type_change = true;
        $manufacture_change = true;
        $status_change = true;
        $serial_change = true;

        if($serial_query == ''){
            $serial_change = false;
        }
        if($s_query == '0') {
            $status_change = false;
        }

        $db = db_iconnect('warehouse-works');
        $sql="Set autocommit=0";
        $db->query($sql) or
            die("Something went wrong with $sql<br>".$db->error);
            
        if($name_change && !$status_change){
            $sql = "UPDATE `equipment` SET `type` = '$t_query', `manufacture` = '$m_query', `serial_number` = '$serial_query' WHERE `auto_id` = '$id_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h2>ID: $id_query serial number, type, and manufacture has been updated.</h2>";
        }elseif(!$name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `auto_id` = '$id_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h2>ID: $id_query status has been updated.</h2>";
        }elseif($name_change && $status_change){
            $sql = "UPDATE `equipment` SET `type` = '$t_query', `manufacture` = '$m_query', `serial_number` = '$serial_query', `status` = '$s_query' WHERE `auto_id` = '$id_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h2>ID: $id_query all information has been updated.</h2>";
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
        $db = db_iconnect('warehouse-works');
        echo '<h2>Modify Equipment</h2>';
        echo '<h3>Select a record to modify by ID and enter any fields that need to be changed.
        </h3>';
        echo '<form method="post" action="">';

            echo '<label for="auto_id">ID: </label>';
            echo '<input type="text" name="auto_id" id="auto_id"/>';

            echo '<label for="type">Type: </label>';
            echo '<select name="type" id="type">';
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
            echo '<label for="serial_num">Serial Number: </label>';
            echo '<input type="text" name="serial_num" id="serial_num"/>';
            echo '<button type="submit" name="submit" value="submit">Submit</button>';
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