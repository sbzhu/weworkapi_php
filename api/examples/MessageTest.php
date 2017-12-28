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

$config = require('./config.php');
// 
$agentId = $config['APP_ID'];
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);

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
                new NewsArticle(
                    $title = "Got you !", 
                    $description = "Who's this cute guy testing me ?", 
                    $url = "https://work.weixin.qq.com/wework_admin/ww_mt/agenda", 
                    $picurl = "https://p.qpic.cn/pic_wework/167386225/f9ffc8f0a34f301580daaf05f225723ff571679f07e69f91/0", 
                    $btntxt = "btntxt"
                ),
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
