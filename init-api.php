<?php

require_once 'Reports.php'; 

$config = [
    'apiUrl' => 'https://plagiarismsearch.com/api/v3',
    'apiUser' => 'kalyesubulanicholas@my.uopeople.edu',
    'apiKey' => '4BMYTlPAg1KqeZ7BrDnIOjEgwrx99FZuwyQy3sfkRWg11XDHRP-201314956',
];

$api = new Reports($config); 

header("Content-type: application/json; charset=UTF-8");
