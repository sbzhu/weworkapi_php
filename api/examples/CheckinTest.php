<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File CheckinTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");
// 
$agentId = 1000029;
$api = new CorpAPI("wwfedd7e5292d63a35", "EL39AdrLeo0wkTR2Taiczl9KDw-V4YFumfV4zmGtKxY");
 
try {
    $api = new CorpAPI("wwfedd7e5292d63a35", "soENuQULV0WCXNzTfnVilqyUEeSGzaOiNGmFbZK2AQs");

    //
    $checkinOption = $api->CheckinOptionGet(1513760113, array("abelzhu"));
    var_dump($checkinOption);

    //
    $checkinDataList = $api->CheckinDataGet(1, 1513649733, 1513770113, array("abelzhu"));
    var_dump($checkinDataList);

    $api = new CorpAPI("wwfedd7e5292d63a35", "nyJUOE9k9Ha9IH2ZcdapIYQUwULYXPTAV-YAU-taFTo");
    //
    $ApprovalDataList = $api->ApprovalDataGet(1513649733, 1513770113);
    var_dump($ApprovalDataList);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

