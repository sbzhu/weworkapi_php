<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File BatchTest.php
 * @Brief 
 * @Author abelzhu, <AUTHOR_EMAIL>
 * @Version 1.0
 * @Date 2017-12-26
 *
 */
 
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");

$config = require('./config.php');

// 需启用 "管理工具" -> "通讯录同步", 并使用该处的secret, 才能通过API管理通讯录
//
$api = new CorpAPI($config['CORP_ID'], $config['CONTACT_SYNC_SECRET']);

try {
    //
    $batchJobArgs = new BatchJobArgs();
    {
        $batchJobArgs->media_id = "<MEDIA_ID>";
        $batchJobArgs->callback->url = "<CALLBACK_URL>";
        $batchJobArgs->callback->token = "<CALLBACK_TOKEN>";
    }
    $jobId = $api->BatchSyncUser($batchJobArgs);
    echo $jobId . "\n";

    //
    $jobResult = $api->BatchJobGetResult($jobId);
    var_dump($jobResult);

    //

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
