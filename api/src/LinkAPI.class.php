<?php

include_once(__DIR__."/../datastructure/Link_Message.class.php");
include_once ("CorpAPI.class.php");
//use User;
//use Utils;

class LinkAPI extends CorpAPI {

    //linkCorp 关联企业相关接口添加，by ywq
    const Link_Get_Perm_List     = '/cgi-bin/linkedcorp/agent/get_perm_list?access_token=ACCESS_TOKEN';//获取应用的可见范围
    const Link_USER_GET          = '/cgi-bin/linkedcorp/user/get?access_token=ACCESS_TOKEN'; //获取互联企业成员详细信息
    const Link_USER_SIMPLE_LIST  = '/cgi-bin/linkedcorp/user/simplelist?access_token=ACCESS_TOKEN'; //获取互联企业部门成员
    const Link_USER_LIST         = '/cgi-bin/linkedcorp/user/list?access_token=ACCESS_TOKEN'; //获取互联企业部门成员详情
    const Link_DEPARTMENT_LIST   = '/cgi-bin/linkedcorp/department/list?access_token=ACCESS_TOKEN'; //获取互联企业部门列表
    const Link_MESSAGE_SEND      = '/cgi-bin/linkedcorp/message/send?access_token=ACCESS_TOKEN'; //互联企业的应用支持推送文本、图片、视频、文件、图文等类型。

    //以下为企业互联相关
    const Corp_List_App_ShareInfo= '/cgi-bin/corpgroup/corp/list_app_share_info?access_token=ACCESS_TOKEN';// 获取应用共享信息
    const Corp_Get_Token         = '/cgi-bin/corpgroup/corp/gettoken?access_token=ACCESS_TOKEN'; //获取下级企业的access_token
    const Corp_Mina_Session      = '/cgi-bin/miniprogram/transfer_session?access_token=ACCESS_TOKEN';//获取下级企业的小程序session


    //=============================关联企业API接口 =====================================
    /**
     * @brief Link_Get_Perm_List :获取应用的可见范围
     * @desc 仅自建应用可调用。本接口只返回互联企业中非本企业内的成员和部门的信息，如果要获取本企业的可见范围，请调用“获取应用”接口
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93172
     * @return array userids 示例："userids": ["CORPID/USERID"],
     * @return array department_ids 示例： "department_ids":["LINKEDID/DEPARTMENTID"]
     * @throws QyApiError
     */
    public function LinkGetPermList(){
        self::_HttpCall(self::Link_Get_Perm_List, 'POST', '');
        $ret = is_array($this->rspJson) ? $this->rspJson: json_decode($this->rspJson,true);
        return [$ret['userids'], $ret['department_ids']];
    }

    /**
     * @brief Link_USER_GET : 关联企业读取成员详细信息
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93171
     * @param $userid : string
     * @return User : User
     * @throws ParameterError
     * @throws QyApiError
     */
    public function Link_UserGet($userid)
    {
        Utils::checkNotEmptyStr($userid, "userid");
        self::_HttpCall(self::Link_USER_GET, 'POST', array('userid' => $userid));
        return User::Array2User($this->rspJson['user_info']);
    }


    /**
     * @brief UserSimpleList : 获取关联企业部门成员
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93168
     * @param $department_id
     * @param bool $fetchChild : true/false 是否递归获取子部门下面的成。（官方文档中不严谨，这里如果用0、1会提示json格式不正确。查了很久原因）
     *
     * @return array : User array
     * @throws ParameterError
     * @throws QyApiError
     */
    public function Link_UserSimpleList($department_id, $fetchChild=false)
    {
        Utils::checkNotEmptyStr($department_id, "department_id");
        self::_HttpCall(self::Link_USER_SIMPLE_LIST, 
            'POST', 
            json_encode( array('department_id'=>$department_id, 'fetch_child'=>$fetchChild), JSON_UNESCAPED_UNICODE));
//        self::_HttpCall(self::Link_USER_SIMPLE_LIST, 'POST',
//            '{"department_id": "wh205582b532e12e3f/307"');
        return $this->Array2UserList($this->rspJson);
    }

    /**
     * @brief UserList : 获取关联企业部门成员详情
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93169
     * @param $departmentId : string
     * @param bool $fetchChild : true/false  是否递归获取子部门下面的成员
     *
     * @return array
     * @throws ParameterError
     * @throws QyApiError
     */
    public function Link_UserList($departmentId, $fetchChild=false)
    {
        Utils::checkNotEmptyStr($departmentId, "departmentId");
        self::_HttpCall(self::Link_USER_LIST, 'POST', array('department_id'=>$departmentId, 'fetch_child'=>$fetchChild));
        return User::Array2UserList($this->rspJson);
    }

    /**
     * @brief DepartmentList : 获取互联企业部门列表
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93170
     *
     * @param $departmentId : string, 该字段用的是互联应用可见范围接口返回的department_ids参数，用的是 linkedid + ’/‘ + department_id 拼成的字符串
     *
     * @return array : Department array
     * @throws QyApiError
     */
    public function Link_DepartmentList($departmentId)
    {
        self::_HttpCall(self::Link_DEPARTMENT_LIST, 'POST', array('department_id'=>$departmentId));
        return $this->Link_Array2DepartmentList($this->rspJson);
    }

    // --------------------------- 关联企业消息推送 -----------------------------------

    /**
     * @brief Link_MessageSend : 发送消息
     *
     * @link https://work.weixin.qq.com/api/doc#10167
     *
     * @param Link_Message $message : Message
     * @param $invalidUserIdList : string array
     * @param $invalidPartyIdList : uint array
     * @param $invalidTagIdList : uint array
     *
     * @return void
     * @throws QyApiError
     */
    public function Link_MessageSend(Link_Message $message, &$invalidUserIdList, &$invalidPartyIdList, &$invalidTagIdList)
    {
        $message->CheckMessageSendArgs();
        $args = $message->Message2Array();
        $args = json_encode($args);
//        $args['agentid'] = $message->agentid;
        self::_HttpCall(self::Link_MESSAGE_SEND, 'POST', $args);

        $invalidUserIdList = utils::arrayGet($this->rspJson, "invaliduser");
        $invalidPartyIdList = utils::arrayGet($this->rspJson, "invalidparty");
        $invalidTagIdList = utils::arrayGet($this->rspJson, "invalidtag");
    }


    // =========  关联企业的其他关联方法，与本企业的方法有不同之处 =======
    private function Array2UserList($arr)
    {
        $userList = $arr["userlist"];

        $retUserList = array();
        if (is_array($userList)) {
            foreach ($userList as $item) {
                $user = $this->Link_Array2User($item);
                $retUserList[] = $user;
            }
        }
        return $retUserList;
    }

    private function Link_Array2User($arr)
    {
        $user['userid'] = Utils::arrayGet($arr, "userid");
        $user['name'] = Utils::arrayGet($arr, "name");
        $user['department'] = Utils::arrayGet($arr, "department");
        $user['corpid'] = Utils::arrayGet($arr, "corpid");
        return $user;
    }

    private function Link_Array2DepartmentList($arr)
    {
        $list = $arr["department_list"];

        $departmentList = array();
        if (is_array($list)) {
            foreach ($list as $item) {
                $department = $this->Link_Array2Department($item);
                $departmentList[] = $department;
            }
        }
        return $departmentList;
    }
    private function Link_Array2Department($arr)
    {
        $department = [];
        $department['department_name'] = Utils::arrayGet($arr, "department_name");
        $department['->department_id'] = Utils::arrayGet($arr, "department_id");
        $department['parentid'] = Utils::arrayGet($arr, "parentid");
        $department['order'] = Utils::arrayGet($arr, "order");
        return $department;
    }

    // =================== 以下为 企业互联 相关API接口 =================================
    /**
     * @desc 获取应用共享信息
     * 上级企业通过该接口获取某个应用分享给的所有企业列表。
     * 特别注意，对于有敏感权限的应用，需要下级企业确认后才能共享成功，若下级企业未确认，则不会存在于该接口的返回列表
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93403
     * @param integer $agentid  上级企业应用agentid
     * @return array $share_info
     * share_info	应用共享信息
    share_info.corpid	下级企业corpid
    share_info.corp_name	下级企业名称
    share_info.agentid	下级企业应用id
     * 示例
     {"errcode": 0,
    "errmsg": "ok",
    "share_info":[{
        "corpid": "wwcorpid1",
        "corp_name": "测试企业1"
        "agentid": 1111
    }]}
     * @throws QyApiError  如果没有做企业互联
     */
    public function Corp_ListAppShareInfo($agentid)
    {
        self::_HttpCall(self::Corp_List_App_ShareInfo, 'POST', array('agentid'=>$agentid));
        return $this->rspJson['share_info'];
    }

    /**
     * @desc 获取下级企业的access_token。注意，此token需要另外缓存，避免多次调用，且“一定”不要与当前应用混淆
     * 获取应用可见范围内下级企业的access_token，该access_token可用于调用下级企业通讯录的只读接口。
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93359
     * @param string $corpid 	已授权的下级企业corpid  注意是 "下级企业的corpid"
     * @param integer $agentid  已授权的 "下级" 企业 "应用ID"，不是当前企业的
     * @return array $share_info
     * @return string $access_token 获取到的下级企业调用凭证，最长为512字节
     * @return string $expires_in	凭证的有效时间（秒）
    {   "errcode": 0,
    "errmsg": "ok",
    "access_token": "accesstoken000001",
    "expires_in": 7200
    }
     * @throws QyApiError
     */
    public function Corp_GroupAccessToken($corpid, $agentid)
    {
        self::_HttpCall(self::Corp_Get_Token, 'POST', array("corpid"=>$corpid, 'agentid'=>$agentid));
        return [$this->rspJson['access_token'], $this->rspJson['expires_in']];
    }

    /**
     * @desc 获获取下级企业的小程序session
     * 上级企业通过该接口转换为下级企业的小程序session
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93355
     * @param string $userid 通过code2Session接口获取到的加密的userid，不多于64字节
     * @param string $session_key 通过code2Session接口获取到的属于上级企业的会话密钥-不多于64字节
     * @return array
     * @return string $userid, 下级企业用户的ID。此时是解密后的明文ID
     * @return string $session_key 属于下级企业的会话密钥
    {
    "errcode": 0,
    "errmsg": "ok"
    "userid": "jack",
    "session_key": "DGAuy2KVaGcnsUrXk8ERgw==",
    }
     * @throws QyApiError
     */
    public function Corp_MinaSession($userid, $session_key)
    {
        self::_HttpCall(self::Corp_Mina_Session, 'POST', array("userid"=>$userid, 'session_key'=>$session_key));
        return [$this->rspJson['userid'], $this->rspJson['session_key']];
    }

}