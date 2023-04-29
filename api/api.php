<?php
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathComponents = explode("/", trim($path,"/"));

$endPoint = $pathComponents[1];

switch($endPoint) {
    case "search":
        echo "$path";
        echo "<pre>";
        print_r($pathComponents);
        echo "</pre>";
        include("search.php");
        break;

    default:
        $output[] = 'Status: Error';
        $output[] = "MSG: API Endpoint $endPoint not found";
        $output[] = 'Action: None';
        $responseData = json_encode($output);
        echo $responseData;
}
