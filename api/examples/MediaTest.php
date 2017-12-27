<?php

include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");

/*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File MediaTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */
 
$config = require('./config.php');

$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);
try {
    //
    $mediaId = $api->MediaUpload("TestConfig.php", "file");
    echo $mediaId."\n";

    //
    $data = $api->MediaGet($mediaId);
    var_dump($data);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
