<?php
session_start();
require_once "../Database.php";
require_once "../PlagiarismData.php";
/* @var $api Reports */
require_once '../init-api.php';

$PlagiarismData = new PlagiarismData();
$userId = $_SESSION['user_id'];

//Fetch the user reports
$reports = $PlagiarismData->getAllUserChecks($userId, "AI");

$reportIds = [];

foreach ($reports as $report) {
    array_push($reportIds, $report['report_id']);
}


//Using the fetched Ids, Use API to get these ids

$data = [
    'limit' => 100,
    'ids' => $reportIds, 
]; 

$json_data = $api->indexActionAI($data);
print $json_data;

