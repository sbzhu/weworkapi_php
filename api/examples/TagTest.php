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

// 需启用 "管理工具" -> "通讯录同步", 并使用该处的secret, 才能通过API管理通讯录
$api = new CorpAPI("wwfedd7e5292d63a35", "CyeISAmDEps8gzRDQtLlvAr4B9PIjH1uQpbNmHH0Gj8");

try { 
    //
    $tag = new Tag();
    { 
        $tag->tagname = "tag_701";
    }
    $tagId = $api->TagCreate($tag);
    echo $tagId . "\n";

    //
    $tag->tagid = $tagId;
    $tag->tagname = "tag_801";
    $api->TagUpdate($tag);

    //
    $invalidUserIdList = null;
    $invalidPartyIdList = null;
    $api->TagAddUser(
        $tagId, 
        array("ZhuShengBen", "abelzhu", "aaaa", "bbbb"), 
        array(1, 2, 2222, 3333), 
        $invalidUserIdList, 
        $invalidPartyIdList);
    var_dump($invalidUserIdList);
    var_dump($invalidPartyIdList);

    //
    $api->TagDeleteUser($tagId, null, array(2, 222222), $invalidUserIdList, $invalidPartyIdList);

    //
    $tag = $api->TagGetUser($tagId);
    var_dump($tag);

    //
    $tagList = $api->TagGetList();
    var_dump($tagList);

    //
    $api->TagDelete($tagId);

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
    $api->TagDelete($tagId);
}

