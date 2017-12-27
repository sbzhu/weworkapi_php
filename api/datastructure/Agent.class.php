<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class Agent
{
    public $agentid = null; // string
    public $name = null; // string
    public $square_logo_url = null; // string
    public $description = null; // string
    public $allow_userinfos = null; // string array
    public $allow_partys = null; // uint array
    public $allow_tags = null; // uint array
    public $close = null; // uint, 企业应用是否被禁用
    public $redirect_domain = null; // string
    public $report_location_flag = null; // uint, 企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
    public $isreportenter = null; // uint, 是否上报用户进入应用事件。0：不接收；1：接收
    public $home_url = null; // string 

    public static function Array2Agent($arr)
    {
        $agent = new Agent();

        $agent->agentid = Utils::arrayGet($arr, "agentid");
        $agent->name = Utils::arrayGet($arr, "name");
        $agent->square_logo_url = Utils::arrayGet($arr, "square_logo_url");
        $agent->description = Utils::arrayGet($arr, "description");
        $agent->close = Utils::arrayGet($arr, "close");
        $agent->redirect_domain = Utils::arrayGet($arr, "redirect_domain");
        $agent->report_location_flag = Utils::arrayGet($arr, "report_location_flag");
        $agent->isreportenter = Utils::arrayGet($arr, "isreportenter");
        $agent->home_url = Utils::arrayGet($arr, "home_url");

        if (array_key_exists("allow_userinfos", $arr) && array_key_exists("user", $arr["allow_userinfos"])) {
            $userArr = $arr["allow_userinfos"]["user"];
            foreach($userArr as $item) {
                $agent->allow_userinfos[] = $item["userid"];
            }
        }

        if (array_key_exists("allow_partys", $arr)) {
            $partyAr = $arr["allow_partys"];
            $agent->allow_partys = Utils::arrayGet($partyAr, "partyid");
        }

        if (array_key_exists("allow_tags", $arr)) { 
            $tagArr= $arr["allow_tags"];
            $agent->allow_tags= Utils::arrayGet($tagArr, "tagid");
        }

        return $agent;
    }

    public static function Array2AgentList($arr)
    {
        $agentLIst = array();

        foreach($arr["agentlist"] as $item) {
            $agent = self::Array2Agent($item);
            $agentLIst[] = $agent;
        }

        return $agentLIst;
    }

    public static function Agent2Array($agent)
    { 
        $args = array();

		Utils::setIfNotNull($agent->agentid, "agentid", $args);
		Utils::setIfNotNull($agent->name, "name", $args);
		Utils::setIfNotNull($agent->square_logo_url, "square_logo_url", $args);
		Utils::setIfNotNull($agent->description, "description", $args);
		Utils::setIfNotNull($agent->close, "close", $args);
		Utils::setIfNotNull($agent->redirect_domain, "redirect_domain", $args);
		Utils::setIfNotNull($agent->report_location_flag, "report_location_flag", $args);
		Utils::setIfNotNull($agent->isreportenter, "isreportenter", $args);
		Utils::setIfNotNull($agent->home_url, "home_url", $args); 

        return $args;
    }

    public static function CheckAgentSetArgs($agent)
    { 
        utils::checkIsUInt($agent->agentid, "agentid");
    }
}
