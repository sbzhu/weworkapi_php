<?php
/*
 * 新增几个新加企业微信发送消息的功能，原基础库中没有。
 * "msgtype" : "interactive_taskcard", 任务卡片消息
 *  "msgtype" : "miniprogram_notice", 小程序通知消息
 * "msgtype": "markdown",markdown消息
 * author ywq
 * date: 2021/07/15
 */
include_once(__DIR__."/../../utils/error.inc.php");
include_once(__DIR__."/../../utils/Utils.class.php");

/*
 * MD文档消息类型
 */
class MDMessageContent
{
    public $msgtype = "markdown";
    private $content = null; // string

    public function __construct($content=null)
    {
        $this->content = $content;
    }

    public function CheckMessageSendArgs()
    {
        if (mb_detect_encoding($this->content, 'UTF-8') != 'UTF-8') {
            throw new QyApiError("invalid MarkDown is not UTF-8");
        }
        $len = strlen($this->content);
        if ($len == 0 || $len > 2048) {
            throw new QyApiError("invalid MarkDown content length " . $len);
        }
    }

    public function MessageContent2Array(&$arr)
    {
        Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array("content" => $this->content);
        Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
    }
}

/*
 * 小程序消息类型
 */
class MinaMessageContent
{
    public $msgtype = "miniprogram_notice";

    public function __construct($appid=null, $page=null, $title=null,
            $description=null, bool $emphasis_first_item=true, array $content_item=[])
    {
        $this->appid = $appid;
        $this->page = $page;
        $this->title = $title;
        $this->description = $description;
        $this->emphasis_first_item = $emphasis_first_item; //是否放大第一个content_item(default true)
        $this->content_item = $content_item;
    }

    public function CheckMessageSendArgs()
    {
        $len_title = strlen($this->title);
        $len_desc = strlen($this->description);
        if (($len_title<4 || $len_title>24) || ($len_desc<4 ||$len_desc>24)) {
            throw new QyApiError("Mina Title or Desc len is not allowed!");
        }
        if(count($this->content_item)>10){
            throw new QyApiError("Mina content_item is big than 10");
        }
        foreach ($this->content_item as $k => $v){
            if (strlen($k)>10 || strlen($v)>30){
                throw new QyApiError("Mina key or value more than 10 or 30". $k);
            }
        }
    }

    public function MessageContent2Array(&$arr)
    {
        Utils::setIfNotNull($this->msgtype, "msgtype", $arr);
        $contentArr = array();
        {
            Utils::setIfNotNull($this->appid, "appid", $contentArr);
            Utils::setIfNotNull($this->page,"page",$contentArr);
            Utils::setIfNotNull($this->title, "title", $contentArr);
            Utils::setIfNotNull($this->description, "description", $contentArr);
            Utils::setIfNotNull($this->emphasis_first_item, "emphasis_first_item", $contentArr);
            Utils::setIfNotNull($this->content_item, "content_item", $contentArr);
        }
        Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
    }
}

/*
 * 任务卡片消息类型，其中的消息类型示例：
 *    "interactive_taskcard" : {
        "title" : "赵明登的礼物申请",
        "description" : "礼品：A31茶具套装\n用途：赠与小黑科技张总经理",
        "url" : "URL",
        "task_id" : "taskid123",
        "btn":[
            {
                "key": "key111",
                "name": "批准",
                "color":"red",
                "is_bold": true
            },
            {
                "key": "key222",
                "name": "驳回"
            }
        ]
   },
  其中：
btn:key	是	按钮key值，用户点击后，会产生任务卡片回调事件，回调事件会带上该key值，只能由数字、字母和“_-@”组成，最长支持128字节
btn:name	是	按钮名称，最长支持18个字节，超过则截断
btn:color	否	按钮字体颜色，可选“red”或者“blue”,默认为“blue”
btn:is_bold	否	按钮字体是否加粗，默认false
enable_id_trans	否	表示是否开启id转译，0表示否，1表示是，默认0
 */
class TaskCardMessageContent
{
    public $msgtype = "interactive_taskcard";

    public function __construct($title=null, $description=null,$url=null,
                                $task_id=null, array $btn=[])
    {
        $this->title = $title; //	标题，不超过128个字节，超过会自动截断（支持id转译）
        $this->description = $description; //描述，不超过512个字节，超过会自动截断（支持id转译）
        $this->url = $url; //点击后跳转的链接。最长2048字节，请确保包含了协议头(http/https)
        $this->task_id = $task_id; //任务id，同一个应用发送的任务卡片消息的任务id不能重复，只能由数字、字母和“_-@”组成，最长支持128字节
        $this->btn = $btn; //按钮列表，按钮个数为1~2个。
    }

    public function CheckMessageSendArgs()
    {
        $len_title = strlen($this->title);
        $len_desc = strlen($this->description);
        if ( $len_title>128 || $len_desc>512 || strlen($this->url)>2048) {
            throw new QyApiError("TaskCard Title or Desc or url len is not allowed!");
        }
        if(count($this->btn)>2){
            throw new QyApiError("TaskCard content_item is big than 2");
        }
        foreach ($this->btn as $k => $v){
            if (strlen($k)>128 || strlen($v)>30){
                throw new QyApiError("TaskCard key or value more than 10 or 30". $k);
            }
        }
    }

    public function MessageContent2Array(&$arr)
    {
        Utils::setIfNotNull($this->msgtype, "msgtype", $arr);
        $contentArr = array();
        {
            Utils::setIfNotNull($this->title, "title", $contentArr);
            Utils::setIfNotNull($this->description, "description", $contentArr);
            Utils::setIfNotNull($this->url, "url", $contentArr);
            Utils::setIfNotNull($this->task_id,"task_id",$contentArr);
            Utils::setIfNotNull($this->btn, "btn", $contentArr);
        }
        Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
    }
}
