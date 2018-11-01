<?php

include_once "WXBizMsgCrypt.php";

// 假设企业号在公众平台上设置的参数如下
$encodingAesKey = "jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C";
$token = "QDG6eK";
$sReceiveId = "wx5823bf96d3bd56c7";

/*
------------使用示例一：验证回调URL---------------
*企业开启回调模式时，企业号会向验证url发送一个get请求 
假设点击验证时，企业收到类似请求：
* GET /cgi-bin/wxpush?msg_signature=5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3&timestamp=1409659589&nonce=263014780&echostr=P9nAzCzyDtyTWESHep1vC5X9xho%2FqYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp%2B4RPcs8TgAE7OaBO%2BFZXvnaqQ%3D%3D 
* HTTP/1.1 Host: qy.weixin.qq.com

接收到该请求时，企业应
1.解析出Get请求的参数，包括消息体签名(msg_signature)，时间戳(timestamp)，随机数字串(nonce)以及公众平台推送过来的随机加密字符串(echostr),
这一步注意作URL解码。
2.验证消息体签名的正确性 
3. 解密出echostr原文，将原文当作Get请求的response，返回给公众平台
第2，3步可以用公众平台提供的库函数VerifyURL来实现。

*/

$sVerifyMsgSig = "5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3";
$sVerifyTimeStamp = "1409659589";
$sVerifyNonce = "263014780";
$sVerifyEchoStr = "P9nAzCzyDtyTWESHep1vC5X9xho/qYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp+4RPcs8TgAE7OaBO+FZXvnaqQ==";

// 需要返回的明文
$sEchoStr = "";

$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $sReceiveId);
$errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
if ($errCode == 0) {
	print("done VerifyURL, sEchoStr : \n");
    var_dump($sEchoStr);
	//
	// 验证URL成功，将sEchoStr返回
	// HttpUtils.SetResponce($sEchoStr);
} else {
	print("ERR: " . $errCode . "\n\n");
}

print("===============================\n");
;

/*
------------使用示例二：对用户回复的消息解密---------------
用户回复消息或者点击事件响应时，企业会收到回调消息，此消息是经过公众平台加密之后的密文以post形式发送给企业，密文格式请参考官方文档
假设企业收到公众平台的回调消息如下：
POST /cgi-bin/wxpush?msg_signature=1f3153b7abd0ba99b4ab2e57fac2376110d03a3c&timestamp=1409659813&nonce=1372623149 HTTP/1.1

{
	"ToUserName": "wx5823bf96d3bd56c7",
	"Encrypt": "jYKl5gAKBiSvZ694aryRMNxKJhUJFtNCSDS9TgfV7rDtEe0x6FjiuCWenK3dCDOah+qOJ8yS6RERDoFhe4dYsHpyImaoZwiGjTp1RGXr7GEW5Tn21BdmYId4Pzvoi6ieOKWbrzag5v2TzcF9syQtry2Ujg5hLEgmMP1Y3GPKHLJ8Rg1kpASRriNKeoHWnokLHlpVt3Ai45y2Bfqn+GxT7qz+yODK3f9Ygxhkpkvp6EaIDIzvk77r26t6Q/sTGfzBYPsNYI8t811B9UFyr38gwslPQUHYuOUXalAUnqpiZW0=";
	"AgentID": 218
}

企业收到post请求之后应该
1.解析出url上的参数，包括消息体签名(msg_signature)，时间戳(timestamp)以及随机数字串(nonce)
2.验证消息体签名的正确性。
3.将post请求的数据进行xml解析，并将<Encrypt>标签的内容进行解密，解密出来的明文即是用户回复消息的明文，明文格式请参考官方文档
第2，3步可以用公众平台提供的库函数DecryptMsg来实现。
*/

$sReqMsgSig = "1f3153b7abd0ba99b4ab2e57fac2376110d03a3c";
$sReqTimeStamp = "1409659813";
$sReqNonce = "1372623149";

// post请求的密文数据
$sReqData = '{ "ToUserName": "wx5823bf96d3bd56c7", "Encrypt": "pvXgeha3nZ7UQ2DG3WD3IVsNJR38QVl1+h+wmLQHIAwEG3Jey2aTZtvAWzhEZ9JEKGwIUMBWX3JlUhfo7O7WbvI10vHIsdSNr1nr3LuOwAfnwLJAMQNDxi5tHUl08Op59jxOL73r8+g60KOxMTaFwXzlr9Yxgq5ey5nzNb/2vDjjvDZNXkJVmL/XWnv6PXrVbTpNxphqWRv2BpPYqvwRMkHgdFliatljMVlkkRHS40FOHmtBhj/4RXtIexfDx8opBXwi0L9RTlYNQzGx+FA+74xVHG7Le/pmNDwc2Ri5mbw=", "AgentID": 218 }';
$sMsg = "";  // 解析之后的明文
$errCode = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
if ($errCode == 0) {
	// 解密成功，sMsg即为xml格式的明文
	print("done DecryptMsg, sMsg : \n");
    var_dump($sMsg);
	// TODO: 对明文的处理
} else {
	print("ERR: " . $errCode . "\n\n");
	//exit(-1);
}

print("===============================\n");

/*
------------使用示例三：企业回复用户消息的加密---------------
企业被动回复用户的消息也需要进行加密，并且拼接成密文格式的xml串。
假设企业需要回复用户的明文如下：

{ 
	"ToUserName": "mycreate",
	"FromUserName":"wx5823bf96d3bd56c7",
	"CreateTime": 1348831860,
	"MsgType": "text",
	"Content": "this is a test",
	"MsgId": 1234567890123456,
	"AgentID": 128,
}

为了将此段明文回复给用户，企业应：
1.自己生成时间时间戳(timestamp),随机数字串(nonce)以便生成消息体签名，也可以直接用从公众平台的post url上解析出的对应值。
2.将明文加密得到密文。
3.用密文，步骤1生成的timestamp,nonce和企业在公众平台设定的token生成消息体签名。
4.将密文，消息体签名，时间戳，随机数字串拼接成xml格式的字符串，发送给企业号。
以上2，3，4步可以用公众平台提供的库函数EncryptMsg来实现。
*/

// 需要发送的明文
$sRespData = '{ "ToUserName": "mycreate", "FromUserName":"wx5823bf96d3bd56c7", "CreateTime": 1348831860, "MsgType": "text", "Content": "this is a test", "MsgId": 1234567890123456, "AgentID": 128, }';
$sEncryptMsg = ""; //xml格式的密文
$errCode = $wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
if ($errCode == 0) {
	print("done EncryptMsg, sEncryptMsg : \n");
    var_dump($sEncryptMsg);
	// TODO:
	// 加密成功，企业需要将加密之后的sEncryptMsg返回
	// HttpUtils.SetResponce($sEncryptMsg);  //回复加密之后的密文
	print("done \n");
} else {
	print("ERR: " . $errCode . "\n\n");
	// exit(-1);
}

print("===============================\n");
