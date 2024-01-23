<?php

/* @var $api Reports */
require_once '../init-api.php';

$id = $_POST['reportId'];
$data = [
    "show_relations" => -1
];

$fetchedData =  json_decode($api->viewAction($id, $data));

if($fetchedData->code == 200){
    return print json_encode($fetchedData);
}else{
    return print json_encode(["error"=>"No details found"]);
}
