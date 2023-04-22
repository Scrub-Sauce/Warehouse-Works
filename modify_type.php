<?php
    include 'db_connect.php';

    if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
        $t_query = $_POST['type'];
        $nt_query = $_POST['new_type'];

        $db = db_iconnect('warehouse-works');
        $sql = "UPDATE `type` SET `name` = '$nt_query' WHERE `auto_id` = $t_query";
        // $sql = "UPDATE `type` SET `name` = '$nt_query' WHERE `auto_id` = '$t_query'";
        // // $db->query($sql) or 
        // //     die("Something went wrong with $sql<br>".$db->error);

        echo "<h2>type has been changed at Auto ID: $t_query to $nt_query</h2>";


    } else {
        echo '<h1>Modify Type</h1>';
        echo '<form method="post" action="">';
            echo '<label for="type"></label>';
            echo '<select name="type" id="type">';
            $db = db_iconnect('warehouse-works');
            $sql = "SELECT * FROM `type`";
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