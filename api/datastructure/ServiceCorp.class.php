<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class SetSessionInfoReq { 
    public $pre_auth_code = null; // string
    public $session_info = null; // SessionInfo

    public function FormatArgs()
    { 
        Utils::checkNotEmptyStr($this->pre_auth_code, "pre_auth_code");

        $args = array();

        $args["pre_auth_code"] = $this->pre_auth_code;
        $args["session_info"] = $this->session_info->FormatArgs();

        return $args;
    }
} 

class SessionInfo { 
    public $appid = null; // uint array
    public $auth_type = 0; // uint, 授权类型：0 正式授权， 1 测试授权， 默认值为0

    public function FormatArgs()
    { 
        $args = array();

        $args["appid"] = $this->appid;
        $args["auth_type"] = $this->auth_type;

        return $args;
    }
}

class GetPermanentCodeRsp 
{
    public $access_token = null; // string
    public $expires_in = null; // uint 
    public $permanent_code = null; // string 
    public $auth_corp_info = null; // AuthCorpInfo 
    public $auth_info = null; // AuthInfo  
    public $auth_user_info = null; // AuthUserInfo 

    static public function ParseFromArray($arr)
    { 
        $info = new GetPermanentCodeRsp();

        $info->access_token = Utils::arrayGet($arr, "access_token"); 
        $info->expires_in = Utils::arrayGet($arr, "expires_in"); 
        $info->permanent_code = Utils::arrayGet($arr, "permanent_code");

        if (array_key_exists("auth_corp_info", $arr)) { 
            $info->auth_corp_info = AuthCorpInfo::ParseFromArray($arr["auth_corp_info"]);
        }
        if (array_key_exists("auth_info", $arr)) { 
            $info->auth_info = AuthInfo::ParseFromArray($arr["auth_info"]);
        }
        if (array_key_exists("auth_user_info", $arr)) { 
            $info->auth_user_info = AuthUserInfo::ParseFromArray($arr["auth_user_info"]);
        }

        return $info;
    } 
}

class AuthCorpInfo
{ 
    public $corpid = null; // string
    public $corp_name = null; // string
    public $corp_type = null; // string
    public $corp_square_logo_url = null; // string
    public $corp_user_max = null; // uint 
    public $corp_agent_max = null; // uint 
    public $corp_full_name = null; // string 
    public $verified_end_time = null; // uint 
    public $subject_type = null; // uint 
    public $corp_wxqrcode = null; // string 

    static public function ParseFromArray($arr)
    { 
        $info = new AuthCorpInfo();

        $info->corpid = Utils::arrayGet($arr, "corpid"); 
        $info->corp_name = Utils::arrayGet($arr, "corp_name"); 
        $info->corp_type = Utils::arrayGet($arr, "corp_type"); 
        $info->corp_square_logo_url = Utils::arrayGet($arr, "corp_square_logo_url"); 
        $info->corp_user_max = Utils::arrayGet($arr, "corp_user_max"); 
        $info->corp_agent_max = Utils::arrayGet($arr, "corp_agent_max"); 
        $info->corp_full_name = Utils::arrayGet($arr, "corp_full_name"); 
        $info->verified_end_time = Utils::arrayGet($arr, "verified_end_time"); 
        $info->subject_type = Utils::arrayGet($arr, "subject_type"); 
        $info->corp_wxqrcode = Utils::arrayGet($arr, "corp_wxqrcode"); 

        return $info;
    }
}
class AuthInfo 
{ 
    public $agent = null; // AgentBriefEx array

    static public function ParseFromArray($arr)
    { 
        $info = new AuthInfo();

        foreach($arr["agent"] as $item) { 
            $info->agent[] = AgentBriefEx::ParseFromArray($item);
        }

        return $info;
    }
}
class AgentBriefEx 
{ 
    public $agentid = null; // uint
    public $name = null; // string 
    public $round_logo_url = null; // string 
    public $square_logo_url = null; // string 
    public $appid = null; // uint 
    public $privilege = null; // AgentPrivilege 

    static public function ParseFromArray($arr)
    { 
        $info = new AgentBriefEx();

        $info->agentid = Utils::arrayGet($arr, "agentid"); 
        $info->name = Utils::arrayGet($arr, "name"); 
        $info->round_logo_url = Utils::arrayGet($arr, "round_logo_url"); 
        $info->square_logo_url = Utils::arrayGet($arr, "square_logo_url"); 
        $info->appid = Utils::arrayGet($arr, "appid"); 

        if (array_key_exists("privilege", $arr)) { 
            $info->privilege = AgentPrivilege::ParseFromArray($arr["privilege"]);
        }

        return $info;
    }
} 
class AgentPrivilege
{ 
    public $level = null; // uint
    public $allow_party = null; // uint array
    public $allow_user = null; // string array
    public $allow_tag = null; // uint array
    public $extra_party = null; // uint array
    public $extra_user = null; // string array
    public $extra_tag = null; // uint array

    static public function ParseFromArray($arr)
    { 
        $info = new AgentPrivilege();

        $info->level = Utils::arrayGet($arr, "level"); 
        $info->allow_party = Utils::arrayGet($arr, "allow_party"); 
        $info->allow_user = Utils::arrayGet($arr, "allow_user"); 
        $info->allow_tag = Utils::arrayGet($arr, "allow_tag"); 
        $info->extra_party = Utils::arrayGet($arr, "extra_party"); 
        $info->extra_user = Utils::arrayGet($arr, "extra_user"); 
        $info->extra_tag = Utils::arrayGet($arr, "extra_tag"); 

        return $info;
    }
}
class AuthUserInfo 
{ 
    public $email = null; // string 
    public $mobile = null; // string 
    public $userid = null; // string 
    public $name = null; // string 
    public $avatar = null; // string 

    static public function ParseFromArray($arr)
    { 
        $info = new AuthUserInfo();

        $info->email = Utils::arrayGet($arr, "email"); 
        $info->mobile = Utils::arrayGet($arr, "mobile"); 
        $info->userid = Utils::arrayGet($arr, "userid"); 
        $info->name = Utils::arrayGet($arr, "name"); 
        $info->avatar = Utils::arrayGet($arr, "avatar"); 

        return $info;
    }
}

class GetAuthInfoRsp
{ 
    public $auth_corp_info = null; // AuthCorpInfo
    public $auth_info = null; // AuthInfo 

    static public function ParseFromArray($arr)
    { 
        $info = new GetAuthInfoRsp();

        if (array_key_exists("auth_corp_info", $arr)) { 
            $info->auth_corp_info = AuthCorpInfo::ParseFromArray($arr["auth_corp_info"]);
        }
        if (array_key_exists("auth_info", $arr)) { 
            $info->auth_info = AuthInfo::ParseFromArray($arr["auth_info"]);
        }

        return $info;
    }
}

class GetAdminListRsp
{ 
    public $admin = null; // AppAdmin array

    static public function ParseFromArray($arr)
    { 
        $info = new GetAdminListRsp();

        foreach($arr["admin"] as $item) {
            $info->admin[] = AppAdmin::ParseFromArray($item);
        }

        return $info;
    }
}

class AppAdmin
{ 
    public $userid = null; // string
    public $auth_type = null; // uint, 该管理员对应用的权限：0=发消息权限，1=管理权限

    static public function ParseFromArray($arr)
    { 
        $info = new AppAdmin();

        $info->userid = Utils::arrayGet($arr, "userid"); 
        $info->auth_type = Utils::arrayGet($arr, "auth_type"); 

        return $info;
    }
}

class GetUserinfoBy3rdRsp
{ 
    public $CorpId = null; // string
    public $UserId = null; // string
    public $DeviceId = null; // string
    public $user_ticket = null; // string
    public $expires_in = null; // uint 
    public $OpenId = null; // string

    static public function ParseFromArray($arr)
    { 
        $info = new GetUserinfoBy3rdRsp();

        $info->CorpId = Utils::arrayGet($arr, "CorpId"); 
        $info->UserId = Utils::arrayGet($arr, "UserId"); 
        $info->DeviceId = Utils::arrayGet($arr, "DeviceId"); 
        $info->user_ticket = Utils::arrayGet($arr, "user_ticket"); 
        $info->expires_in = Utils::arrayGet($arr, "expires_in"); 
        $info->OpenId = Utils::arrayGet($arr, "OpenId"); 

        return $info;
    }
}

class GetUserDetailBy3rdRsp
{ 
    public $corpid = null; // string
    public $userid = null; // string
    public $name = null; // string
    public $department = null; // uint array 
    public $position = null; // string
    public $mobile = null; // string
    public $gender = null; // string
    public $email = null; // string
    public $avatar = null; // string

    static public function ParseFromArray($arr)
    { 
        $info = new GetUserDetailBy3rdRsp();

        $info->corpid = Utils::arrayGet($arr, "corpid"); 
        $info->userid = Utils::arrayGet($arr, "userid"); 
        $info->name = Utils::arrayGet($arr, "name"); 
        $info->department = Utils::arrayGet($arr, "department"); 
        $info->position = Utils::arrayGet($arr, "position"); 
        $info->mobile = Utils::arrayGet($arr, "mobile"); 
        $info->gender = Utils::arrayGet($arr, "gender"); 
        $info->email = Utils::arrayGet($arr, "email"); 
        $info->avatar = Utils::arrayGet($arr, "avatar"); 

        return $info;
    }
}
