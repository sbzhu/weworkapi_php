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

$config = require('./config.php');

//
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);

// ------------------------- 应用管理 --------------------------------------
try {
    //
    $agent = new Agent();
    {
        $agent->agentid = $config['APP_ID'];
        $agent->description = "I'm description";
    }
    $api->AgentSet($agent);

    //
    $agent = $api->AgentGet($config['APP_ID']);
    var_dump($agent);

    //
    $agentList = $api->AgentGetList();
    var_dump($agentList);

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
