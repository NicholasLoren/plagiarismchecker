<?php
session_start();
/* @var $api Reports */
require_once '../init-api.php';
include_once("../Database.php");
require_once '../PlagiarismData.php';

$PlagiarismData = new PlagiarismData();
$userId = $_SESSION['user_id'];

$filename = filter_input(INPUT_POST, 'filename', FILTER_SANITIZE_STRING);

$data = [];
$files = [
    'file' => realpath('../uploads/' . $filename),
];

$fetchedData = json_decode($api->createAction($data, $files));



if ($fetchedData->code == 200) {
    $reportId = $fetchedData->data->id;
    //save the data to my database
    $result = $PlagiarismData->addUserReport(["userId" => $userId, "reportId" => $reportId]);

    if (empty($PlagiarismData->reportError())) {
        return print json_encode(["reportId" => $reportId]);
    } else {

        return print json_encode(["error" => "Action failed" . $PlagiarismData->reportError()]);
    }
}
