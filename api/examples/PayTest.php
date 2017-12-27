<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File PayTest.php
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
$config = require('./config.php');
// 
$agentId = $config['APP_ID'];
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);
 
try { 
    $SendWorkWxRedpackReq = new SendWorkWxRedpackReq();
    {
        $SendWorkWxRedpackReq->nonce_str = "nonce_str";
    }
    $api->SendWorkWxRedpack($SendWorkWxRedpackReq);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
