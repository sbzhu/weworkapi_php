<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File TagTest.php
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
    $tag = new Tag();
    { 
        $tag->tagname = "tag_1";
    }
    $tagid = $api->TagCreate($tag);
    echo $tagid . "\n";

    //
    $tag->tagid = $tagid;
    $tag->tagname = "tag_2";
    $api->TagUpdate($tag);

    //
    $invalidUserIdList = null;
    $invalidPartyIdList = null;
    $api->TagAddUser(
        $tagid, 
        array("ZhuShengBen", "abelzhu", "aaaa", "bbbb"), 
        array(1, 2, 2222, 3333), 
        $invalidUserIdList, 
        $invalidPartyIdList);
    var_dump($invalidUserIdList);
    var_dump($invalidPartyIdList);

    //
    $api->TagDeleteUser($tagid, null, array(1, 2, 222222), $invalidUserIdList, $invalidPartyIdList);

    //
    $tag = $api->TagGetUser($tagid);
    var_dump($tag);

    //
    $tagList = $api->TagGetList();
    var_dump($tagList);

    //
    $api->TagDelete($tagid);

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
    $api->TagDelete($tagid);
}

