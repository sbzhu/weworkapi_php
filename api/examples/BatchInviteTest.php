<?php /*
 * Copyright (C) 2018 All rights reserved.
 *   
 * @File BatchInviteTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2018-01-02
 *
 */
 
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");


$config = require('./config.php');
// 需启用 "管理工具" -> "通讯录同步", 并使用该处的secret, 才能通过API管理通讯录
//
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);


try { 
    //
    $invalidUserIdList = null;
    $invalidPartyIdList = null;
    $invalidTagIdList = null;
    $api->BatchInvite(
        array('ZhuShengBen', 'abelzhu', 'userid_for_invite_test'), array(1, 2, 111), array(1, 222), 
        $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
    var_dump($invalidUserIdList);
    var_dump($invalidPartyIdList);
    var_dump($invalidTagIdList);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
