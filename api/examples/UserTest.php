<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File UserTest.php
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
// 需启用 "管理工具" -> "通讯录同步", 并使用该处的secret, 才能通过API管理通讯录
//
$api = new CorpAPI($config['CORP_ID'], $config['CONTACT_SYNC_SECRET']);


try { 
    //
    $user = new User();
    {
        $user->userid = "userid";
        $user->name = "name";
        $user->mobile = "131488888888";
        $user->email = "sbzhu@ipp.cas.cn";
        $user->department = array(1); 

        $ExtattrList = new ExtattrList();
        $ExtattrList->attrs = array(new ExtattrItem("s_a_2", "aaa"), new ExtattrItem("s_a_3", "bbb"));
        $user->extattr = $ExtattrList;
    } 
    $api->UserCreate($user);

    //
    $user = $api->UserGet("userid");
    var_dump($user);

    //
    $user->mobile = "1219887219873";
    $api->UserUpdate($user); 

    //
    $userList = $api->userSimpleList(1, 0);
    var_dump($userList);

    //
    $userList = $api->UserList(1, 0);
    var_dump($userList);

    //
    $openId = null;
    $api->UserId2OpenId("ZhuShengBen", $openId);
    echo "openid: $openId\n";

    //
    $userId = null;
    $api->openId2UserId($openId, $userId);
    echo "userid: $userId\n";

    //
    $api->UserAuthSuccess("userid");

    //
    $api->UserBatchDelete(array("userid", "aaa"));

    //
    $api->UserDelete("userid"); 
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
    $api->UserDelete("userid"); 
}
