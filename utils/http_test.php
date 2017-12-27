<?php

include_once(__DIR__.'/HttpUtils.class.php');

// $output = HttpUtils::httpGet("http://localhost:8080");
// var_dump($output);

$output = HttpUtils::httpPost("http://localhost:8080", "hello");
var_dump($output);
