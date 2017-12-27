<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File MessageTest.php
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
    $message = new Message();
    {
        $message->sendToAll = false;
        $message->touser = array("abelzhu", "ShengbenZhu");
        $message->toparty = array(1, 2, 1111, 3333);
        $message->totag= array(3, 4, 22233332, 33334444);
        $message->agentid = $agentId;
        $message->safe = 0;

        $message->messageContent = new NewsMessageContent(
            array(
                new NewsArticle("title_1", "description", "url", "picurl", "btntxt"),
                new NewsArticle("title_2", "description", "url", "picurl", "btntxt")
            )
        );
    }
    $invalidUserIdList = null;
    $invalidPartyIdList = null;
    $invalidTagIdList = null;

    $api->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
    var_dump($invalidUserIdList);
    var_dump($invalidPartyIdList);
    var_dump($invalidTagIdList);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
