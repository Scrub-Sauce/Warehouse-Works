<?php
    include 'db_connect.php';

    if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
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

        echo "s_query = '$s_query' status_change:";
        echo $status_change ? 'true' : 'false';

        echo "nt_query = '$nt_query' name_change:";
        echo $name_change ? 'true' : 'false';
        $db = db_iconnect('warehouse-works');
        if($name_change && !$status_change){
            $sql = "UPDATE `type` SET `name` = '$nt_query' WHERE `auto_id` = '$t_query";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h3>ID: $t_query name has been updated.</h3>";
        }elseif(!$name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `type` = '$t_query";
            db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h3>ID: $t_query status has been updated.</h3>";
        }elseif($name_change && $status_change){
            $sql = "UPDATE `equipment` SET `status` = '$s_query' WHERE `type` = '$t_query";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            $sql = "UPDATE `type` SET `name` = '$nt_query' WHERE `auto_id` = '$t_query";
            $db->query($sql) or
                die("Something went wrong with $sql<br>".$db->error);
            echo "<h3>ID: $t_query name and status have been updated.</h3>";
        }else{
            echo '<h3>No Values Changed.</h3>';
        }

        

        // 
        // $db->query($sql) or
        //     die("Something went wrong with $sql<br>".$db->error);

        echo "<h2>type has been changed at Auto ID: $t_query to $nt_query</h2>";


    } else {
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
    }

    
    
?>