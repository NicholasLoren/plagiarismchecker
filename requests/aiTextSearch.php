<?php
session_start();
/* @var $api Reports */
require_once '../init-api.php';
include_once ("../Database.php");
require_once '../PlagiarismData.php';

$PlagiarismData = new PlagiarismData();
$userId = $_SESSION['user_id'];

$textContent = $_POST['textContent'];
$data = [
    'text' => $textContent,
    'show_relations' => 1
];

$fetchedData = json_decode($api->createActionAI($data));
if ($fetchedData->code == 202) {
    $reportId = $fetchedData->data->id;
    //save the data to my database
    $result = $PlagiarismData->addUserReport(["userId" => $userId, "reportId" => $reportId,"type"=>"AI"]);

    return print json_encode(empty($PlagiarismData->reportError()) ? ["reportId" => $reportId] : ["error" => "Action failed" . $PlagiarismData->reportError()]);
}
