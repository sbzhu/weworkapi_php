<?php

include_once(__DIR__."/../../utils/error.inc.php");
include_once(__DIR__."/../../utils/Utils.class.php");

class Message 
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

        if (true == $this->sendToAll) {
		    Utils::setIfNotNull("@all", "touser", $args);
        } else { 
            //
            $touser_string = null;
            foreach($this->touser as $item) { 
                $touser_string = $touser_string . $item . "|";
            }
		    Utils::setIfNotNull($touser_string, "touser", $args);

            //
            $toparty_string = null;
            foreach($this->toparty as $item) { 
                $toparty_string = $toparty_string . $item . "|";
            }
		    Utils::setIfNotNull($toparty_string, "toparty", $args);

            //
            $totag_string = null;
            foreach($this->totag as $item) { 
                $totag_string = $totag_string . $item . "|";
            }
		    Utils::setIfNotNull($totag_string, "totag", $args);
        }

        Utils::setIfNotNull($this->agentid, "agentid", $args);
        Utils::setIfNotNull($this->safe, "safe", $args);

        $this->messageContent->MessageContent2Array($args);

        return $args;
    }
}

// --------------------- 各种类型的 MessageContent -----------------------------
//

class TextMessageContent
{
    public $msgtype = "text"; 
	private $content = null; // string

	public function __construct($content=null)
	{
		$this->content = $content;
	}

	public function CheckMessageSendArgs()
	{
		$len = strlen($this->content);
		if ($len == 0 || $len > 2048) {
            throw new QyApiError("invalid content length " . $len);
		}
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array("content" => $this->content);
		Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
	}
}

class ImageMessageContent
{
    public $msgtype = "image"; 
	private $media_id = null; // string

	public function __construct($media_id=null)
	{
		$this->media_id = $media_id;
	}

	public function CheckMessageSendArgs()
	{
        Utils::checkNotEmptyStr($this->media_id, "media_id");
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array("media_id" => $this->media_id);
		Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
	}
}

class VoiceMessageContent
{
    public $msgtype = "voice"; 
	private $media_id = null; // string

	public function __construct($media_id=null)
	{
		$this->media_id = $media_id;
	}

	public function CheckMessageSendArgs()
	{
        Utils::checkNotEmptyStr($this->media_id, "media_id");
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array("media_id" => $this->media_id);
		Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
	}
} 

class VideoMessageContent
{
    public $msgtype = "video"; 
	public $media_id = null; // string
	public $title = null; // string
	public $description = null; // string

	public function __construct($media_id=null, $title=null, $description=null)
	{
		$this->media_id = $media_id;
		$this->title = $title;
		$this->description = $description;
	}

	public function CheckMessageSendArgs()
	{
        Utils::checkNotEmptyStr($this->media_id, "media_id");
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array();
        {
		    Utils::setIfNotNull($this->media_id, "media_id", $contentArr);
		    Utils::setIfNotNull($this->title, "title", $contentArr);
		    Utils::setIfNotNull($this->description, "description", $contentArr);
        }
		Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
	}
}

class FileMessageContent
{
    public $msgtype = "file"; 
	public $media_id = null; // string

	public function __construct($media_id=null)
	{
		$this->media_id = $media_id;
	}

	public function CheckMessageSendArgs()
	{
        Utils::checkNotEmptyStr($this->media_id, "media_id");
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array();
        {
		    Utils::setIfNotNull($this->media_id, "media_id", $contentArr);
        }
		Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
	}
}

class TextCardMessageContent
{
    public $msgtype = "textcard"; 
	public $title = null; // string
	public $description = null; // string
	public $url = null; // string
	public $btntxt = null; // string

	public function __construct($title=null, $description=null, $url=null, $btntxt=null)
	{
		$this->title = $title;
		$this->description = $description;
		$this->url = $url;
		$this->btntxt = $btntxt;
	}

	public function CheckMessageSendArgs()
	{
        Utils::checkNotEmptyStr($this->title, "title");
        Utils::checkNotEmptyStr($this->description, "description");
        Utils::checkNotEmptyStr($this->url, "url");
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array();
        {
		    Utils::setIfNotNull($this->title, "title", $contentArr);
		    Utils::setIfNotNull($this->description, "description", $contentArr);
		    Utils::setIfNotNull($this->url, "url", $contentArr);
		    Utils::setIfNotNull($this->btntxt, "btntxt", $contentArr);
        }
		Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
	}
}

class NewsArticle { 
    public $title = null; // string
    public $description = null; // string
    public $url = null; // string
    public $picurl = null; // string
    public $btntxt = null; // string

    public function __construct($title=null, $description=null, $url=null, $picurl=null, $btntxt=null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->picurl = $picurl;
        $this->btntxt = $btntxt;
    }

    public function CheckMessageSendArgs()
    { 
        Utils::checkNotEmptyStr($this->title, "title");
        Utils::checkNotEmptyStr($this->url, "url");
    }

    public function Article2Array() 
    {
        $args = array();

        Utils::setIfNotNull($this->title, "title", $args); 
        Utils::setIfNotNull($this->description, "description", $args); 
        Utils::setIfNotNull($this->url, "url", $args); 
        Utils::setIfNotNull($this->picurl, "picurl", $args); 
        Utils::setIfNotNull($this->btntxt, "btntxt", $args); 

        return $args;
    }
}


class NewsMessageContent
{
    public $msgtype = "news"; 
    public $articles = array(); // NewsArticle array

	public function __construct($articles)
	{
		$this->articles = $articles;
	}

	public function CheckMessageSendArgs()
	{
        $size = count($this->articles);
        if ($size < 1 || $size > 8) throw QyApiError("1~8 articles should be given");

        foreach($this->articles as $item) { 
            $item->CheckMessageSendArgs();
        }
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $articleList = array();
        foreach($this->articles as $item) {
            $articleList[] = $item->Article2Array();
        }
        $arr[$this->msgtype]["articles"] = $articleList;
	}
}

class MpNewsArticle { 
	public $title = null; // string
	public $thumb_media_id = null; // string
	public $author = null; // string
	public $content_source_url = null; // string
	public $content = null; // string
	public $digest = null; // string

    public function __construct(
        $title=null, 
        $thumb_media_id=null, 
        $author=null, 
        $content_source_url=null, 
        $content=null,
        $digest=null)
	{
		$this->title = $title;
		$this->thumb_media_id = $thumb_media_id;
		$this->author = $author;
		$this->content_source_url = $content_source_url;
		$this->content = $content;
		$this->digest = $digest;
	}

    public function CheckMessageSendArgs()
    { 
        Utils::checkNotEmptyStr($this->title, "title");
        Utils::checkNotEmptyStr($this->thumb_media_id, "thumb_media_id");
        Utils::checkNotEmptyStr($this->content, "content");
    }

    public function Article2Array() 
    {
        $args = array();

		    Utils::setIfNotNull($this->title, "title", $args);
		    Utils::setIfNotNull($this->thumb_media_id , "thumb_media_id", $args);
		    Utils::setIfNotNull($this->author, "author", $args);
		    Utils::setIfNotNull($this->content_source_url, "content_source_url", $args);
		    Utils::setIfNotNull($this->content, "content", $args);
		    Utils::setIfNotNull($this->digest, "digest", $args);

        return $args;
    }
}


class MpNewsMessageContent
{
    public $msgtype = "mpnews"; 
    public $articles = array(); // MpNewsArticle array

	public function __construct($articles)
	{
		$this->articles = $articles;
	}

	public function CheckMessageSendArgs()
	{
        $size = count($this->articles);
        if ($size < 1 || $size > 8) throw QyApiError("1~8 articles should be given");

        foreach($this->articles as $item) { 
            $item->CheckMessageSendArgs();
        }
	}

	public function MessageContent2Array(&$arr)
	{
		Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $articleList = array();
        foreach($this->articles as $item) {
            $articleList[] = $item->Article2Array();
        }
        $arr[$this->msgtype]["articles"] = $articleList;
	}
}
