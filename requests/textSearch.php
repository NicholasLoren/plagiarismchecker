<?php 
session_start();
/* @var $api Reports */
require_once '../init-api.php'; 
include_once("../Database.php");
require_once '../PlagiarismData.php';

$PlagiarismData = new PlagiarismData();
$userId = $_SESSION['user_id'];

$textContent = $_POST['textContent'];
$data = [
    'text' => $textContent,
    'show_relations' => 1
];

$fetchedData =  json_decode($api->createAction($data)); 
if($fetchedData->code == 200){
    $reportId = $fetchedData->data->id;
    //save the data to my database
    $result = $PlagiarismData->addUserReport(["userId"=>$userId,"reportId"=>$reportId]);

    if(empty($PlagiarismData->reportError())){
        return print json_encode(["reportId"=>$reportId]);
    }else{
        
        return print json_encode(["error"=>"Action failed". $PlagiarismData->reportError()]);
    }
}
