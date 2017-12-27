<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File ServiceCorpTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");
 
try { 
    $authCorpId = "AUTH_CORPID";
    $authAgentId = 1000040;

    // 下面是第三方应用接口的使用
    //
    $ServiceCorpAPI = new ServiceCorpAPI(
        "SUITE_ID", 
        "SUITE_SECRET",
        "SUITE_TICKET" 
    );

    $pre_auth_code = $ServiceCorpAPI->GetPreAuthCode();
    echo $pre_auth_code . "\n";

    //
    $SetSessionInfoReq = new SetSessionInfoReq();
    {
        $SetSessionInfoReq->pre_auth_code = $pre_auth_code;

        $session_info = new SessionInfo();
        { 
            $session_info->appid = array(1, 2, 3, 4, 5, 6, 7);
            $session_info->auth_type = 0;
        }
        $SetSessionInfoReq->session_info = $session_info;
    }
    $ServiceCorpAPI->SetSessionInfo($SetSessionInfoReq);

    //
    $GetAdminListRsp = $ServiceCorpAPI->GetAdminList($authCorpId, $authAgentId);
    var_dump($GetAdminListRsp);

    // permanentCode 的获取方法
    //
    $temp_auth_code = "TEMP_AUTH_CODE";
    $GetPermanentCodeRsp = $ServiceCorpAPI->GetPermanentCode($temp_auth_code);
    var_dump($GetPermanentCodeRsp);

    $permanentCode = $GetPermanentCodeRsp->permanent_code;

    $GetAuthInfoRsp = $ServiceCorpAPI->GetAuthInfo($authCorpId, $permanentCode);
    var_dump($GetAuthInfoRsp);

    // 
    $code = "xxxxxxxxxx";
    $GetUserinfoBy3rdRsp = $ServiceCorpAPI->GetUserinfoBy3rd($code);
    var_dump($GetUserinfoBy3rdRsp);

    //
    $user_ticket = $GetUserInfoByCode->user_ticket;
    if ( ! is_null($user_ticket)) {
        $GetUserDetailBy3rdRsp = $ServiceCorpAPI->GetUserDetailBy3rd($user_ticket);
        var_dump($GetUserDetailBy3rdRsp);
    }

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

try { // 第三方服务商使用永久授权码调用企业接口 
    $authCorpId = "AUTH_CORPID";
    $permanentCode = "PERMANENT_CODE"; 
    $authAgentId = 1000040;

    $ServiceCorpAPI = new ServiceCorpAPI(
        "SUITE_ID", 
        "SUITE_SECRET",
        "SUITE_TICKET", // suite_ticket
        $authCorpId,
        $permanentCode
    );
    $message = new Message();
    {
        $message->sendToAll = false;
        $message->touser = array("abelzhu", "ShengbenZhu");
        $message->toparty = array(1, 2, 1111, 3333);
        $message->totag= array(3, 4, 22233332, 33334444);
        $message->agentid = $authAgentId;
        $message->safe = 0;

        $message->messageContent = new NewsMessageContent(
            array(
                new NewsArticle("title_1", "description", "url", "picurl", "btntxt"),
                new NewsArticle("title_2", "description", "url", "picurl", "btntxt")
            )
        );
    }
    $ServiceCorpAPI->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList); 

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

