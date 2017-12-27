<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File ServiceProviderTest.php
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
    $ServiceProviderAPI = new ServiceProviderAPI(
        "wxd1165b872e863a03", 
        "YHNbNRku4fwLPgs1UTk-girOIG7AO9N-fqtvztiIBU3pH0llME_6-g1UdBO6cwbi"
    );
    //

    //
    $GetRegisterCodeReq = new GetRegisterCodeReq();
    {
        $GetRegisterCodeReq->template_id = "template_id";
        $GetRegisterCodeReq->corp_name = "corp_name";
    }
    $register_code = $ServiceProviderAPI->GetRegisterCode($GetRegisterCodeReq);
    var_dump($register_code);

    //
    $GetLoginInfoRsp = $ServiceProviderAPI->GetLoginInfo("xxxxxxxxxxxxxx");
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

try {
    $ServiceProviderAPI = new ServiceProviderAPI();

    $access_token = "xxxxxxxxxxxxxx";
    //
    $SetAgentScopeReq = new SetAgentScopeReq();
    {
        $SetAgentScopeReq->agentid = 11111111;
    }
    $SetAgentScopeRsp = $ServiceProviderAPI->SetAgentScope($access_token, $SetAgentScopeReq);
    var_dump($SetAgentScopeRsp);

    //
    $ServiceProviderAPI->SetContactSyncSuccess($access_token);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}


try {
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

