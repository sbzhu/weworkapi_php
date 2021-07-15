<?php


/**
 * 向企业微信调用对应的接口方法参考。
 * 原理：调用 php_qywx 中的相关API，将 corpid/agentid 参数传递过去（注意不同的企业微信使用不同的corpid和agentid），将返回结果返回，并自动判断错误。
 * 如有调用企业微信API的问题，请联系
 * author: ywq
 * date: 2021/07/13
 */

namespace App\Common;
include_once "../src/CorpAPI.class.php"; //互联企业用LinkAPI.class.php
include_once "../datastructure/MessageExt.class.php";

use CorpAPI;
use Exception;
use MDMessageContent;
use Message;
use MinaMessageContent;
use NewsArticle;
use NewsMessageContent;
use ParameterError;
use TaskCardMessageContent;

class Qywx
{
    private $config;
    private $workApi;

    /**
     * 初始化企业微信的参数，传入不同的 corpid，可使用对应不同的企业微信接口
     * Qywx constructor.
     * @param string $corpId
     */
    public function __construct()
    {
        $config = require('../../config.php');
        if (empty($this->config))
            return 'corpId is empty';
        try {
            $this->workApi = new CorpAPI($config['corpId'], $config['secretKey']);
        } catch (ParameterError $e) {
            echo ('初始化 WorkApi 失败，App/Common/Qywx.php: '. $e->getMessage());
            return 'Initial WorkApi failed!';
        }
        return $this;
    }

    /**
     * 发送消息示例
     * @desc 消息推送的一个例子，发送图文消息
     * @param array $toUser
     * @param array $toParty
     * @param array $toTag
     * @param string $title
     * @param string $desc
     * @param string $url
     * @param string $picurl
     * @return array
     */
    public function SendMessage(array $toUser = [], array $toParty = [], array $toTag = [], $title = '', $desc = '', $url = '', $picurl = '')
    {

        try {
            //以下为发送一个图文消息例子，其他接口具体请参考 php_qywx 中的例子
            $message = new Message();
            {
                $message->sendToAll = false;
//                $message->touser = $toUser?$toUser:array("XingGuang");
                if (!empty($toUser)) $message->touser = $toUser;
                if (!empty($toParty)) $message->toparty = $toParty; // 发给指定部门
                if (!empty($toTag)) $message->totag = $toTag;
//                $message->totag= array(3, 4, 22233332, 33334444); // 发给指定标签
                $message->agentid = $this->config['agentId'];
                $message->safe = 0;

                $message->messageContent = new NewsMessageContent(
                    array(
                        new NewsArticle(
                            $title,
                            $desc,
                            $url,
                            $picurl,
                            $btntxt = "btntxt"
                        ),
                    )
                );
            }
            $invalidUserIdList = null;
            $invalidPartyIdList = null;
            $invalidTagIdList = null;

            $this->workApi->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
            return ['failedList' => ['invalidUserIdList' => $invalidUserIdList, 'invalidPartyIdList' => $invalidPartyIdList, 'invalidTagIdList' => $invalidTagIdList]];
        } catch (Exception $e) {
            print ('QYWX_Api MessageSend send failed: '. $e->getMessage());
            return ['error_msg' => 'QYWX_Api MessageSend send failed. ', 'error' => $e->getMessage()];
        }
    }

    /*
     * 发送小程序消息通知
     * @desc 发送小程序消息通知测试
     * @param array $toUser
     * @param array $toParty
     * @param array $toTag
     * @param string $title
     * @param string $desc
     * @return array
     */
    public function SendMinaMessage(array $toUser, array $toParty, array $toTag, $appid, $page, $title, $desc, $emp, array $content_item)
    {
        try {
            $message = new Message();
            {
                $message->sendToAll = false;
//                $message->touser = $toUser?$toUser:array("XingGuang");
                if (!empty($toUser)) $message->touser = $toUser;
                if (!empty($toParty)) $message->toparty = $toParty; // 发给指定部门
                if (!empty($toTag)) $message->totag = $toTag;
//                $message->totag= array(3, 4, 22233332, 33334444); // 发给指定标签
                $message->agentid = $this->config['agentId'];
                $message->safe = 0;
            }
            $message->messageContent = new MinaMessageContent(
                $appid,
                $page,
                $title,
                $desc,
                $emp,
                $content_item
            );
            $invalidUserIdList = null;
            $invalidPartyIdList = null;
            $invalidTagIdList = null;

            $this->workApi->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
            return ['failedList' => ['invalidUserIdList' => $invalidUserIdList, 'invalidPartyIdList' => $invalidPartyIdList, 'invalidTagIdList' => $invalidTagIdList]];
        } catch (Exception $e) {
            print('QYWX_Api Mina MessageSend send failed: '. $e->getMessage());
            return ['error_msg' => 'QYWX_Api Mina MessageSend send failed. ', 'error' => $e->getMessage()];
        }
    }


    /*
 * 发送 MarkDown 消息通知
 * @desc 发送MD消息通知测试
 * @param array $toUser
 * @param array $toParty
 * @param string $content_item
 * @return array
 */
    public function SendMDMessage(array $toUser, array $toParty, array $toTag, $content_item)
    {
        try {
            $message = new Message();
            {
                $message->sendToAll = false;
//                $message->touser = $toUser?$toUser:array("XingGuang");
                if (!empty($toUser)) $message->touser = $toUser;
                if (!empty($toParty)) $message->toparty = $toParty; // 发给指定部门
                if (!empty($toTag)) $message->totag = $toTag;
//                $message->totag= array(3, 4, 22233332, 33334444); // 发给指定标签
                $message->agentid = $this->config['agentId'];
                $message->safe = 0;
            }
            $message->messageContent = new MDMessageContent(
                $content_item
            );
            $invalidUserIdList = null;
            $invalidPartyIdList = null;
            $invalidTagIdList = null;

            $this->workApi->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
            return ['failedList' => ['invalidUserIdList' => $invalidUserIdList, 'invalidPartyIdList' => $invalidPartyIdList, 'invalidTagIdList' => $invalidTagIdList]];
        } catch (Exception $e) {
            print('QYWX_Api MD MessageSend send failed: '. $e->getMessage());
            return ['error_msg' => 'QYWX_Api MD MessageSend send failed. ', 'error' => $e->getMessage()];
        }
    }


    /*
* 发送 任务卡片 消息通知
* @desc 发送 任务卡片消息 通知测试
* @param array $toUser
* @param array $toParty
* @param array $toTag
* @param array $interactive_taskcard
* @return array
*/
    public function SendTaskCardMessage(array $toUser, array $toParty, array $toTag,
                                        array $interactive_taskcard)
    {
        try {
            $message = new Message();
            {
                $message->sendToAll = false;
//                $message->touser = $toUser?$toUser:array("XingGuang");
                if (!empty($toUser)) $message->touser = $toUser;
                if (!empty($toParty)) $message->toparty = $toParty; // 发给指定部门
                if (!empty($toTag)) $message->totag = $toTag;
//                $message->totag= array(3, 4, 22233332, 33334444); // 发给指定标签
                $message->agentid = $this->config['agentId'];
//                $message->safe = 0;
            }
            $message->messageContent = new TaskCardMessageContent(
                $interactive_taskcard['title'],
                $interactive_taskcard['description'],
                $interactive_taskcard['url'],
                $interactive_taskcard['task_id'],
                $interactive_taskcard['btn']
            );
            $invalidUserIdList = null;
            $invalidPartyIdList = null;
            $invalidTagIdList = null;

            $this->workApi->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
            return ['failedList' => ['invalidUserIdList' => $invalidUserIdList, 'invalidPartyIdList' => $invalidPartyIdList, 'invalidTagIdList' => $invalidTagIdList]];
        } catch (Exception $e) {
            print ('QYWX_Api TaskCard MessageSend send failed: '. $e->getMessage());
            return ['error_msg' => 'QYWX_Api TaskCard MessageSend send failed. ', 'error' => $e->getMessage()];
        }
    }
}



$qywx = new Qywx();

/*
 * 以下为发送图文消息示例
*/
//        $aa = $qywx->SendMessage(["XingGuang"], [], [], '发送消息主题', '消息描述',
//            'https://scrm15.bydauto.com.cn/',
//            'http://wx.qlogo.cn/mmhead/Q3auHgzwzM44XoVIlx6YvtVicjt5IOgbL6cBiajBPic6tWA63kxTyfq2Q/0');

/*
 以下为发送小程序消息示例
*/
//        $aa = $qywx->SendMinaMessage(["XingGuang"], [], [],
//            $appid, "/page/index", "发送小程序消息", "小程序消息描述",
//            true, [["key"=>"会议室", "value"=>"402"],
//                ["key"=>"会议地点", "value"=>"B区156"], [
//                "key"=>"会议时间", "value"=>"2021/09/22 09:30-10:00"]]);

/*
以下为发送md格式消息示例
*/
//        $mdMessage = <<<EOT
//            您的会议室已经预定，稍后会同步到`邮箱`
//                >**事项详情**
//                >事　项：<font color=\"info\">开会</font>
//                >组织者：@miglioguan
//                >参与者：@miglioguan、@kunliu、@jamdeezhou、@kanexiong、@kisonwang
//                >
//                >会议室：<font color=\"info\">广州TIT 1楼 301</font>
//                >日　期：<font color=\"warning\">2018年5月18日</font>
//                >时　间：<font color=\"comment\">上午9:00-11:00</font>
//                >
//                >请准时参加会议。
//                >
//                >如需修改会议信息，请点击：[修改会议信息](https://work.weixin.qq.com)
//        EOT;
//        $aa = $qywx->SendMDMessage(["XingGuang"], [], [], $mdMessage);

/* 以下为发送任务卡片消息.。注意：此方法需要先设置应用的回调url，才能调用成功。如，点了“批准”或“驳回”后，会到
   回调url中，在后续的操作中进行处理。否则会提示：{\"errcode\":43012,\"errmsg\":\"require agent with callback url,
*/
$tc = [
    "title" => "赵明登的礼物申请",
    "description" =>  "礼品：A31茶具套装\n用途：赠与小黑科技张总经理",
    "url"  => "URL",
    "task_id"  =>  "taskid123",
    "btn" => [[
        "key" => "key111",
        "name" =>  "批准",
        "color" => "red",
        "is_bold" =>  true
    ],
        [
            "key" =>  "key222",
            "name" =>  "驳回"
        ]]
];
$aa = $qywx->SendTaskCardMessage(["XingGuang"], [], [], $tc);

// 返回结果
return $aa;
