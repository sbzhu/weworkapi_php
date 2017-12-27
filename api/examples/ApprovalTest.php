<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File ApprovalTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-27
 *
 */
 
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");
// 
$config = require('./config.php');
// 
$api = new CorpAPI($config['CORP_ID'], $config['APPROVAL_APP_SECRET']);
 
try {
    $ApprovalDataList = $api->ApprovalDataGet(1513649733, 1513770113);
    var_dump($ApprovalDataList);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

