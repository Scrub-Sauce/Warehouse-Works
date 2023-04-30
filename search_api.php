<?php
include ('db_connect.php');

$db = db_iconnect('warehouse-works');

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

    echo '<h2>Search Database</h2>';
    echo '<div class="form-wrapper">';
        echo '<form method="post" action="">';

            echo "<div class='input-wrapper'>";
                echo '<label for="manufacture">Manufacture:</label>';
                echo '<select name="manufacture" id="manufacture">';
                    echo '<option value="all">Any</option>';

                    $sql = "SELECT * FROM `manufacture`";
                    $result = $db->query($sql) or
                    die("Something went wrong with: $sql<br>".$db->error);
                    while($data=$result->fetch_array(MYSQLI_ASSOC)){
                        echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
                    }
                // End of select
                echo '</select>';
            echo "</div>";

            echo "<div class='input-wrapper'>";
                echo '<label for="type">Type:</label>';
                echo '<select name="type" id="type">';
                    echo '<option value="all">Any</option>';
                    $sql = "SELECT * FROM `type`";
                    $result = $db->query($sql) or
                    die("Something went wrong with: $sql<br>".$db->error);
                    while($data=$result->fetch_array(MYSQLI_ASSOC)){
                        echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
                    }
                // End of select
                echo '</select>';
            echo "</div>";

            echo "<div class='input-wrapper'>";
                echo '<label for="status">Status:</label>';
                echo '<select name="status" id="status">';
                    echo '<option value="all">Any</option>';
                    $sql = "SELECT * FROM `status`";
                    $result = $db->query($sql) or
                        die("Something went wrong with: $sql<br>".$db->error);
                    while($data=$result->fetch_array(MYSQLI_ASSOC)){
                        echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
                    }
                // End of select
                echo '</select>';
            echo "</div>";

            echo "<div class='input-wrapper'>";
                echo "<label for='serial_num'>Serial Number:";
                echo "<input type='text' name='serial_num' id='serial_num' />";
            echo "</div>";

            echo "<div class='input-wrapper'>";
                echo "<label for='num'>Max number of results:</label>";
                echo '<select name="num" id="num">';
                    echo '<option value="10">10</option>';
                    echo '<option value="25">25</option>';
                    echo '<option value="50">50</option>';
                    echo '<option value="100">100</option>';
                    echo '<option value="250">250</option>';
                    echo '<option value="500">500</option>';
                    echo '<option value="1000">1000</option>';
                echo '</select>';
            echo "</div>";

            echo '<button type="submit" name="submit" value="submit">Submit</button>';

            // End of Form
            echo '</form>';
        echo '</div>';

        if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){
            echo "<h3>Search Results</h3>";
            $t_query = $_POST['type'];
            $m_query = $_POST['manufacture'];
            $n_query = $_POST['num'];
            $s_query = $_POST['serial_num'];
            $stat_query = $_POST['status'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://warehouse-works.systems/api/search?type=$t_query&manufacture=$m_query&status=$stat_query&num=$n_query",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
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
            $tmp = explode(':', $results[0]);
            $status = trim($tmp[1]);
            if($status === 'Success'){
                echo "<p>Status was a success</p>";
            }
        }

echo '</body>';
echo '</html>';
