<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class GetLoginInfoRsp 
{
    public $usertype = null; // uint 
    public $user_info = null; // LoginUserInfo 
    public $corp_info = null; // LoginCorpInfo 
    public $agent = null; // LoginAgentInfo array 
    public $auth_info = null; // LoginAuthInfo

    static public function ParseFromArray($arr)
    { 
        $info = new GetLoginInfoRsp();

        $info->usertype = Utils::arrayGet($arr, "usertype"); 

        if (array_key_exists("user_info", $arr)) { 
            $info->user_info = LoginUserInfo::ParseFromArray($arr["user_info"]);
        }
        if (array_key_exists("corp_info", $arr)) { 
            $info->corp_info = LoginCorpInfo::ParseFromArray($arr["corp_info"]);
        }
        foreach($arr["agent"] as $item) {
            $info->agent[] = LoginAgentInfo::ParseFromArray($item);
        }
        if (array_key_exists("auth_info", $arr)) { 
            $info->auth_info = LoginAuthInfo::ParseFromArray($arr["auth_info"]);
        }

        return $info;
    } 
}

class LoginUserInfo
{
    public $userid = null; // string
    public $name = null; // string
    public $avatar = null; // string
    public $email = null; // string 

    static public function ParseFromArray($arr)
    { 
        $info = new LoginUserInfo();

        $info->userid = Utils::arrayGet($arr, "userid"); 
        $info->name = Utils::arrayGet($arr, "name"); 
        $info->avatar = Utils::arrayGet($arr, "avatar"); 
        $info->email = Utils::arrayGet($arr, "email"); 

        return $info;
    } 
}
class LoginCorpInfo
{ 
    public $corpid = null; // string

    static public function ParseFromArray($arr)
    { 
        $info = new LoginCorpInfo();

        $info->corpid = Utils::arrayGet($arr, "corpid"); 

        return $info;
    } 
}
class LoginAgentInfo 
{ 
    public $agentid = null; // uint 
    public $auth_type = null; // uint 

    static public function ParseFromArray($arr)
    { 
        $info = new LoginAgentInfo();

        $info->agentid = Utils::arrayGet($arr, "agentid"); 
        $info->auth_type = Utils::arrayGet($arr, "auth_type"); 

        return $info;
    } 
}
class LoginAuthInfo
{ 
    public $department = null; // PartyInfo Array 

    static public function ParseFromArray($arr)
    { 
        $info = new LoginAuthInfo();

        foreach($arr["department"] as $item) {
            $info->department[] = PartyInfo::ParseFromArray($item);
        }
        return $info;
    } 
}
class PartyInfo 
{ 
    public $id = null; // uint 
    public $writable = null; // bool 

    static public function ParseFromArray($arr)
    { 
        $info = new PartyInfo();

        $info->id= Utils::arrayGet($arr, "id"); 
        $info->writable = Utils::arrayGet($arr, "writable"); 

        return $info;
    } 
}

class GetRegisterCodeReq
{ 
    public $template_id = null; // string 
    public $corp_name = null; // string 
    public $admin_name = null; // string
    public $admin_mobile = null; // string

    public function FormatArgs()
    { 
        Utils::checkNotEmptyStr($this->template_id, "template_id");

        $args = array();

		Utils::setIfNotNull($this->template_id, "template_id", $args);
		Utils::setIfNotNull($this->corp_name, "corp_name", $args);
		Utils::setIfNotNull($this->admin_name, "admin_name", $args);
		Utils::setIfNotNull($this->admin_mobile, "admin_mobile", $args);

        return $args;
    }
}

class GetRegisterInfoRsp
{
    public $corpid = null; // string
    public $contact_sync = null; // ContactSync 
    public $auth_user_info = null; // RegisterAuthUserInfo 

    static public function ParseFromArray($arr)
    { 
        $info = new GetRegisterInfoRsp();

        $info->corpid = Utils::arrayGet($arr, "corpid"); 

        if (array_key_exists("contact_sync", $arr)) { 
            $info->contact_sync = ContactSync::ParseFromArray($arr["contact_sync"]);
        }
        if (array_key_exists("auth_user_info", $arr)) { 
            $info->auth_user_info = RegisterAuthUserInfo::ParseFromArray($arr["auth_user_info"]);
        }

        return $info;
    } 
}
class ContactSync
{ 
    public $access_token = null; // string
    public $expires_in = null; // uint 

    static public function ParseFromArray($arr)
    { 
        $info = new ContactSync();

        $info->access_token = Utils::arrayGet($arr, "access_token"); 
        $info->expires_in = Utils::arrayGet($arr, "expires_in"); 

        return $info;
    } 
}
class RegisterAuthUserInfo 
{
    public $email = null; // string
    public $mobile = null; // string
    public $userid = null; // string

    static public function ParseFromArray($arr)
    { 
        $info = new RegisterAuthUserInfo();

        $info->email = Utils::arrayGet($arr, "email"); 
        $info->mobile = Utils::arrayGet($arr, "mobile"); 
        $info->userid = Utils::arrayGet($arr, "userid"); 

        return $info;
    } 
}

class SetAgentScopeReq 
{ 
    public $agentid = null; // uint
    public $allow_user = null; // string array 
    public $allow_party = null; // uint array 
    public $allow_tag = null; // uint array 

    public function FormatArgs()
    { 
        $args = array();

		Utils::setIfNotNull($this->agentid, "agentid", $args);
		Utils::setIfNotNull($this->allow_user, "allow_user", $args);
		Utils::setIfNotNull($this->allow_party, "allow_party", $args);
		Utils::setIfNotNull($this->allow_tag, "allow_tag", $args);

        return $args;
    }
}

class SetAgentScopeRsp 
{
    public $invaliduser = null; // string array
    public $invalidparty = null; // uint array
    public $invalidtag = null; // uint array

    static public function ParseFromArray($arr)
    { 
        $info = new SetAgentScopeRsp();

        $info->invaliduser = Utils::arrayGet($arr, "invaliduser"); 
        $info->invalidparty = Utils::arrayGet($arr, "invalidparty"); 
        $info->invalidtag = Utils::arrayGet($arr, "invalidtag"); 

        return $info;
    } 
}
