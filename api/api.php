<?php
//header('Content-Type: application/json');
//header('HTTP/1.1 200 OK');
//
//$output[] = 'Status: API Main';
//$output[] = 'MSG: Primary Endpoint Reached';
//$output[] = 'Action: none';
//
//$responseData = json_encode($output);
//
//echo $responseData;

$url = $_SERVER['REQUEST_URI'];
echo "<h3>$url</h3>";

$path = parse_url($url, PHP_URL_PATH);
echo "<h3>$path</h3>";

$pathComponents = explode("/", trim($path,"/"));
echo '<h3>Number of URL components: '.count($pathComponents).'</h3>';

echo "<pre>";
print_r($pathComponents);
echo "</pre>";

$endPoint = $pathComponents[1];

switch($endPoint) {
    case "search_manufacture":
        echo "<h3>Load Manufactures Endpoint";
        break;
}
