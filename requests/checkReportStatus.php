<?php

/* @var $api Reports */
require_once '../init-api.php';
 
$id = filter_input(INPUT_POST, 'reportId', FILTER_SANITIZE_STRING);

$data = [
    "show_relations" => -1
];

$fetchedData = json_decode($api->statusAction($id, $data));

$maxRetries = 20;
$retryCount = 0;

while ($fetchedData->code != 200 && $retryCount < $maxRetries) {
    $fetchedData = json_decode($api->statusAction($id, $data));
    $retryCount++;
    sleep(10);
}
 

if ($fetchedData->code == 200) {
    return print json_encode($fetchedData);
} else {
    return print json_encode(["error" => "No details found"]);
}
