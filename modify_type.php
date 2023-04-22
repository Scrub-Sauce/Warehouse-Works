<?php
    include 'db_connect.php';

    if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
        $time_start = microtime(true);
        $t_query = $_POST['type'];
        $nt_query = $_POST['new_type'];
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
        $dblink->query($sql) or
            die("Something went wrong with $sql<br>\n".$dblink->error);
        if($name_change && !$status_change){
            $sql = "UPDATE `type` SET `name` = '$nt_query' WHERE `auto_id` = '$t_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h3>ID: $t_query name has been updated.</h3>";
        }elseif(!$name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `type` = '$t_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h3>ID: $t_query status has been updated.</h3>";
        }elseif($name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `type` = '$t_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            $sql = "UPDATE `type` SET `name` = '$nt_query' WHERE `auto_id` = '$t_query'";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h3>ID: $t_query name and status have been updated.</h3>";
        }else{
            echo '<h3>No Values Changed.</h3>';
        }
        $sql="Commit;SET autocommit=1";
        $dblink->query($sql) or
            die("Something went wrong with $sql<br>\n".$dblink->error);

        $time_end = microtime(true);
        $seconds = $time_end - $time_start;
        $execution_time = ($seconds) / 60;

        echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";

    } else {
        $time_start = microtime(true);
        echo '<h1>Modify Type</h1>';
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
            echo '<label for="new_type">New Type: </label>';
            echo '<input type="text" name="new_type">';
            echo '<button type="submit" name="submit" value="submit">Submit</button>';
        echo '</form>';

        $time_end = microtime(true);
        $seconds = $time_end - $time_start;
        $execution_time = ($seconds) / 60;

        echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
    }    
?>