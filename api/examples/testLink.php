<?php

/**
 * 注意使用时， linked_id  是关联企业的id，不是 关联企业的corpid.
 * 在获取部门相关信息时，用 linked_id 。如 linked_id/departmentid
 * 在用户信息的userid 时，用 关联企业的corpid。如 corpid/userid
 * 以上两个id容易混乱，请区分。查看方式：
 * 在企业微信管理后台，通讯录、互联企业，点其中一个互联企业，
 */

include_once (__DIR__."/../src/LinkAPI.class.php");
$config = require (__DIR__."/config_link.php");
//use LinkAPI;
//$config = require('./config.php');
$api = new LinkAPI($config['corpid'], $config['sec']);

try {
//    $LinkGetPermList = $api->LinkGetPermList();
//    echo "获取应用的可见范围:";
//    var_dump($LinkGetPermList);

//    $use_get = $api->Link_UserGet('ww5614ccf1c02e6d99/7086');
//    echo '\n获取用户成员详细信息：';
//    var_dump($use_get);

    echo '\n获取互联企业部门成员:（需要在“可见范围加该部门可见，否则会提示
    //Warning: wrong json format. user not in app perm';
    $simplelist = $api->Link_UserSimpleList('wh205582b532e12e3f/307');
    var_dump($simplelist);

    echo '\n获取互联企业部门成员详情:';
    $userList = $api->Link_UserList('wh205582b532e12e3f/307');
    var_dump($userList);

    echo '\n获取互联企业部门列表:';
    $dep_list = $api->Link_DepartmentList('wh205582b532e12e3f/2');
    var_dump($dep_list);

    echo '\n发送图文消息示例：';
    $message = new Link_Message();
    {
        //$message->sendToAll = false;
        $message->touser = array('ww5614ccf1c02e6d99/7086', );
//                $message->toparty = array(1, 2, 1111, 3333);
//                $message->totag= array(3, 4, 22233332, 33334444);
        $message->agentid = $wxconfig['agentid'];
        $message->safe = 0;

        $message->messageContent = new NewsMessageContent(
            array(
                new NewsArticle(
                    $title = "testing Got you !",
                    $description = "from auto.pw error! qywxMsg Warnning!",
                    $url = "https://work.weixin.qq.com/",
                    $picurl = "https://p.qpic.cn/pic_wework/167386225/f9ffc8f0a34f301580daaf05f225723ff571679f07e69f91/0",
                    $btntxt = "btntxt"
                ),
            )
        );
    }

    $invalidUserIdList = null;
    $invalidPartyIdList = null;
    $invalidTagIdList = null;

    $api->Link_MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);



} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
