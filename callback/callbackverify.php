<?php
include_once "WXBizMsgCrypt.php";

// 假设企业号在公众平台上设置的参数如下
$encodingAesKey = "xxxxxxxxxxxxx";
$token = "xxxxxxxxxxxxx";
$receiveid = "wx5823bf96d3bd56c7";


$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $receiveid);

// http://cq.xuduan.tech:62606/weworkapi_php/callback_json/callbackverify.php?msg_signature=5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3&timestamp=1409659589&nonce=263014780&echostr=P9nAzCzyDtyTWESHep1vC5X9xho%2FqYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp%2B4RPcs8TgAE7OaBO%2BFZXvnaqQ%3D%3D
//
// get the paramters
$sVerifyMsgSig = $_GET['msg_signature'];
$sVerifyTimeStamp = $_GET['timestamp'];
$sVerifyNonce = $_GET['nonce'];
$sVerifyEchoStr = $_GET['echostr'];

$sEchoStr = "";

// call verify function
$errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
if ($errCode == 0) {
	echo $sEchoStr . "\n";
} else {
	print("ERR: " . $errCode . "\n\n");
}


?>
