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
    echo '<h2>Insert new type</h2>';
    echo '<form method="post" action="" class="form-wrapper">';
        echo '<div class="input-wrapper">';
            echo '<label for="type">Type:</label>';
            echo '<input name="type" type="text" class="input-field">';
        echo '</div>';

        echo '<button type="submit" name="submit" value="submit" class="submit-button">Submit</button>';
    echo '</form>';

if(isset($_POST['submit']) && $_POST['submit'] == 'submit'){
    $type = $_POST['type'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://warehouse-works.systems/api/insert_type?type=$type",
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

    $tmp = explode(":", $results[0]);
    $status = trim($tmp[1]);

    $tmp = explode(":", $results[1]);
    $message = $tmp[1];

    echo "<h3>$message</h3>";

    if($status == "Success"){
        $time = explode(':', $results[2]);
        echo "<p>Execution Time: $time[1] minutes</p>";
    }else{
        $action = explode(":", $results[2]);
        echo "<p>Fix: $action[1]</p>";
    }
}
echo '<a href="./search_api.php">Home</a>';

echo "</body>";
echo "</html>";