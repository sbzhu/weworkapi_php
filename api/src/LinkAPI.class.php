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


    //=============================关联企业API接口 =====================================
    /**
     * @brief Link_Get_Perm_List :获取应用的可见范围
     * @desc 仅自建应用可调用。本接口只返回互联企业中非本企业内的成员和部门的信息，如果要获取本企业的可见范围，请调用“获取应用”接口
     * @link https://work.weixin.qq.com/api/doc/90000/90135/93172
     * @return array userids 示例："userids": ["CORPID/USERID"],
     * @return array department_ids 示例： "department_ids":["LINKEDID/DEPARTMENTID"]
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
     * @return : User
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
     * @param $departmentId : string
     * @param $fetchChild : 1/0 是否递归获取子部门下面的成员
     *
     * @return : User array
     */
    public function Link_UserSimpleList($department_id, $fetchChild=0)
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
     * @param $fetchChild : 1/0 是否递归获取子部门下面的成员
     *
     * @return
     */
    public function Link_UserList($departmentId, $fetchChild=0)
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
     * @return : Department array
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
     * @param $message : Message
     * @param $invalidUserIdList : string array
     * @param $invalidPartyIdList : uint array
     * @param $invalidTagIdList : uint array
     *
     * @return
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
}