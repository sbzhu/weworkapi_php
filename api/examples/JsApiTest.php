<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File JsApiTest.php
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
    //
    $ticket = $api->TicketGet();
    echo $ticket . "\n";

    //
    $ticket = $api->JsApiTicketGet();
    echo $ticket . "\n";
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

