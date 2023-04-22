<?php
    include 'db_connect.php';

    if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
        $t_query = $_POST['type'];
        $nt_query = $_POST['new_type'];
        $s_query = $_POST['status'];

        $status_change = true;
        $name_change = true;

        echo "'$name_change'";

        if($nt_query == ''){
            $name_change = false;
        }

        if($s_query == '0') {
            $staus_change = false;
        }

        echo "s_query = '$s_query' status_change:";
        echo $status_change ? 'true' : 'false';

        echo "nt_query = '$nt_query' name_change:";
        echo $name_change ? 'true' : 'false';
        $db = db_iconnect('warehouse-works');
        if($name_change && !$status_change){
            echo '<p>Name change only</p>';
        }elseif(!$name_change && $status_change){
            echo '<p>Status change only</p>';
        }elseif($name_change && $status_change){
            echo '<p>Name and Status Change</p>';
        }else{
            echo '<p>Change None.</p>';
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
            echo '<label for="status">Status: </label>';
            echo '<select name="status" id="status">';
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