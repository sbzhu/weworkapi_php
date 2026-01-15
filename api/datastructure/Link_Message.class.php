<?php

include_once(__DIR__."/../../utils/error.inc.php");
include_once(__DIR__."/../../utils/Utils.class.php");

class Link_Message
{
    public $sendToAll = false; // bool, 是否全员发送, 即文档所谓 @all
    public $touser = array(); // string array
    public $toparty = array(); // uint array
    public $totag = array(); // uint array
    public $agentid = null; // uint
    public $safe = null; // uint, 表示是否是保密消息，0表示否，1表示是，默认0
    public $messageContent = null; // xxxMessageContent

    public function CheckMessageSendArgs()
    {
        if (count($this->touser) > 1000) throw new QyApiError("touser should be no more than 1000");
        if (count($this->toparty) > 100) throw new QyApiError("toparty should be no more than 100");
        if (count($this->totag) > 100) throw new QyApiError("toparty should be no more than 100");

        if (is_null($this->messageContent)) throw new QyApiError("messageContent is empty");
        $this->messageContent->CheckMessageSendArgs();
    }

    public function Message2Array()
    {
        $args = array();
        Utils::setIfNotNull($this->touser, "touser", $args);
        Utils::setIfNotNull($this->toparty, "toparty", $args);
        Utils::setIfNotNull($this->totag, "totag", $args);
        
        //Utils::setIfNotNull($this->toall, "toall", $args);
        Utils::setIfNotNull($this->agentid, "agentid", $args);
        Utils::setIfNotNull($this->safe, "safe", $args);

        $this->messageContent->MessageContent2Array($args);

        return $args;
    }

     private  function setIfNotNull2array($var, $name, &$args)
        {
            if (!is_null($var)) {
                $args[$name] = $var;
            }else $args[$name] = [];
    }
}