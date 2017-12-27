<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File AgentTest.php
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

// ------------------------- 应用管理 --------------------------------------
try {
    //
    $agent = new Agent();
    {
        $agent->agentid = $agentId;
        $agent->description = "I'm description";
    }
    $api->AgentSet($agent);

    //
    $agent = $api->AgentGet($agentId);
    var_dump($agent);

    //
    $agentList = $api->AgentGetList();
    var_dump($agentList);

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
