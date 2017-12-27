<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class UserInfoByCode 
{
	public $UserId = null; // string
	public $DeviceId = null; // string
	public $user_ticket = null; // string
	public $expires_in = null; // uint 
	public $OpenId = null; // string

    static public function Array2UserInfoByCode($arr)
    {
        $info = new UserInfoByCode();

        $info->UserId = Utils::arrayGet($arr, "UserId");
        $info->DeviceId = Utils::arrayGet($arr, "DeviceId");
        $info->user_ticket = Utils::arrayGet($arr, "user_ticket");
        $info->expires_in = Utils::arrayGet($arr, "expires_in");
        $info->OpenId = Utils::arrayGet($arr, "OpenId");

        return $info;
    }
}

class UserDetailByUserTicket
{ 
	public $userid = null; // string
	public $name = null; // string
	public $department = null; // uint array 
	public $position = null; // string
	public $mobile = null; // string, 成员手机号，仅在用户同意snsapi_privateinfo授权时返回
	public $gender = null; // uint, 性别。0表示未定义，1表示男性，2表示女性
	public $email = null; // string
	public $avatar = null; // string, 头像url。注：如果要获取小图将url最后的”/0”改成”/100”即可

    static public function Array2UserDetailByUserTicket($arr)
    {
        $info = null;

        $info->userid = Utils::arrayGet($arr, "userid");
        $info->name = Utils::arrayGet($arr, "name");
        $info->department = Utils::arrayGet($arr, "department");
        $info->position = Utils::arrayGet($arr, "position");
        $info->mobile = Utils::arrayGet($arr, "mobile");
        $info->gender = Utils::arrayGet($arr, "gender");
        $info->email = Utils::arrayGet($arr, "email");
        $info->avatar = Utils::arrayGet($arr, "avatar");

        return $info ;
    }
}
