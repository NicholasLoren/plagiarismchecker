<?php

require_once 'Reports.php';

$config = [
    'apiUrl' => 'https://plagiarismsearch.com/api/v3',
    'apiUser' => 'lorennicosir@gmail.com',
    'apiKey' => '7UJ9LDiomsclvkddeQCrsnb5E1yQZNvjfWjHaSzl3xWMEnTp-191111661',
];

$api = new Reports($config);

header("Content-type: application/json; charset=UTF-8");
