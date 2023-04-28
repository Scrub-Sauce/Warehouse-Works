<?php
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');

$output[] = 'Status: API Main';
$output[] = 'MSG: Primary Endpoint Reached';
$output[] = 'Action: none';

$responseData = json_encode($output);

echo $responseData;
