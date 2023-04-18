<?php
include 'db_connect.php';

if(isset($_POST['submit']) && ($_POST['submit'] == "submit"))
{
    $db = db_iconnect('warehouse-works');
    $time_start = microtime(true);
    $m_query = $_POST['manufacture'];
    $t_query = $_POST['type'];
    $n_query = $_POST['num'];

    $m_wild = true;
    $t_wild = true;

    $manufacture = NULL;
    if($m_query == '%'){
        $manufacture = 'Any';
    }else{
        $m_wild = false;
        $sql = "SELECT `name` FROM `manufacture` WHERE `auto_id` = '$m_query'";
        $result = $db->query($sql) or 
            die("Something went wrong with $sql<br>".$db->error);

        
        while($data = $result->fetch_array(MYSQLI_ASSOC))
        {
            $manufacture = $data['name'];
        }
    }
    

    $type = NULL;
    if($t_query == '%'){
        $type = 'Any';
    }else{
        $t_wild = false;
        $sql = "SELECT `name` FROM `type` WHERE `auto_id` = '$t_query'";
        $result = $db->query($sql) or 
            die("Something went wrong with $sql<br>".$db->error);

        while($data = $result->fetch_array(MYSQLI_ASSOC))
        {
            $type = $data['name'];
        }
    }

    if(!$t_wild && !$m_wild){
        $sql = "SELECT * FROM `equipment` WHERE `type` = '$t_query' AND `manufacture` = '$m_query' AND `serial_number` LIKE '%%' LIMIT $n_query";
    }elseif (!$t_wild && $m_wild) {
        $sql = "SELECT * FROM `equipment` WHERE `type` = '$t_query' AND `serial_number` LIKE '%%' LIMIT $n_query";
    }elseif ($t_wild && !$m_wild) {
        $sql = "SELECT * FROM `equipment` WHERE `manufacture` = '$m_query' AND `serial_number` LIKE '%%' LIMIT $n_query";
    }elseif ($t_wild && $m_wild) {
        $sql = "SELECT * FROM `equipment` WHERE `serial_number` LIKE '%%' LIMIT $n_query";
    }

    $result = $db->query($sql) or 
        die("Something went wrong with $sql<br>".$db->error);
    echo '<h3>Search by manufacture '.$manufacture.' type '.$type.' showing '.$n_query.' results.</h3>';
    echo "<p>$sql</p>";
    echo "<p>t_wild = $t_wild m_wild = $m_wild";
    echo '<table>';
    echo '<tr><th>Type</th><th>Serial Number</th></tr>';
    if($results->rowCount() == 0){
        echo "<h3>No results found.</h3>";
    }else{
        while($data=$result->fetch_array(MYSQLI_ASSOC   )){
            echo '<tr>';
                echo '<td>'.$data['type'].'</td>';
                echo '<td>'.$data['manufacture'].'</td>';
                echo '<td>'.$data['serial_number'].'</td>';
            echo '</tr>';
        }
    }
    echo '</table>';


    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";

} else {
    $db = db_iconnect('warehouse-works');
    $time_start = microtime(true);

    echo '<form method="post" action="">';
    echo '<label for="manufacture">Manufacture</label>';
    echo '<select name="manufacture" id="manufacture">';
        echo '<option value="%">Any</option>';
        $sql = "SELECT * FROM `manufacture`";
        $result = $db->query($sql) or
            die("Something went wrong with: $sql<br>".$db->error);
        while($data=$result->fetch_array(MYSQLI_ASSOC)){
            echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
        }
    // End of select
    echo '</select>';

    echo '<label for="type">Type</label>';
    echo '<select name="type" id="type">';
        echo '<option value="%">Any</option>';
        $sql = "SELECT * FROM `type`";
        $result = $db->query($sql) or
            die("Something went wrong with: $sql<br>".$db->error);
        while($data=$result->fetch_array(MYSQLI_ASSOC)){
            echo '<option value="'.$data['auto_id'].'">'.$data['name'].'</option>';
        }
    // End of select
    echo '</select>';

    echo "<label for='num'>Max number of results</label>";
    echo '<select name="num" id="num">';
        echo '<option value="10">10</option>';
        echo '<option value="25">25</option>';
        echo '<option value="50">50</option>';
        echo '<option value="100">100</option>';
        echo '<option value="250">250</option>';
        echo '<option value="500">500</option>';
        echo '<option value="1000">1000</option>';
    echo '</select>';

    echo '<button type="submit" name="submit" value="submit">Submit</button>';

    // End of Form
    echo '</form>';

    $time_end = microtime(true);
    $seconds = $time_end - $time_start;
    $execution_time = ($seconds) / 60;

    echo "<p>Execution time: $execution_time minutes or $seconds seconds. </p>";
}


?>