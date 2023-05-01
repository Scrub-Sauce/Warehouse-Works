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
    echo '<h2>Insert new equipment</h2>';
    echo '<form method="post" action="">';

        echo '<div class="input-wrapper">';
            echo '<label for="type">Type: </label>';
            echo '<select name="type" id="type">';
            $db = db_iconnect('warehouse-works');
            $sql = "SELECT * FROM `type`";
            $result = $db->query($sql) or
            die("Something went wrong with: $sql<br>".$db->error);
            while($data=$result->fetch_array(MYSQLI_ASSOC)){
                echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
            }
            echo '</select>';
        echo '</div>';

        echo '<div class="input-wrapper">';
            echo '<label for="manufacture">Manufacture: </label>';
            echo '<select name="manufacture" id="manufacture">';
            $sql = "SELECT * FROM `manufacture`";
            $result = $db->query($sql) or
            die("Something went wrong with: $sql<br>".$db->error);
            while($data=$result->fetch_array(MYSQLI_ASSOC)){
                echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
            }
            echo '</select>';
        echo '</div>';

        echo '<div class="input-wrapper">';
            echo '<label for="serial_num">Serial Number: </label>';
            echo '<input type="text" name="serial_num" id="serial_num">';
        echo '</div>';

        echo '<button name="submit" value="submit" type="submit">Submit</button>';
    echo '</form>';

    if(isset($_POST['submit']) && $_POST['submit'] == 'submit'){
        $type = $_POST['type'];
        $manufacture = $_POST['manufacture'];
        $serial_num = $_POST['serial_num'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://warehouse-works.systems/api/insert_equipment?type=$type&manufacture=$manufacture&serial_num=$serial_num",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err) {
            echo "<h3>cURL Error Search API #1: $err</h3>";
            die();
        }else{
            $results = json_decode($response, true);
        }

        $tmp = explode(":", $results[1]);
        $message = $tmp[1];

        echo "$message";
    }

echo '</body>';
echo '</html>';