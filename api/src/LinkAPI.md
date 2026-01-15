# 关联企业API调用说明
（不是企业互联：https://work.weixin.qq.com/api/doc/90000/90135/93360）

互联企业的功能调用：参考https://work.weixin.qq.com/api/doc/90000/90135/93167

主要功能有：
1. 获取应用可见范围
1. 获取互联企业成员详细信息
1. 获取互联企业部门成员
1. 获取互联企业部门成员详情
1. 获取互联企业列表
1. 发送应用消息
1. 接收消息与事件（回调模式，需要应用支持）

##有关代码：
直接在文档中加载 LinkAPI.class.php 即可
include_once (__DIR__."/../src/LinkAPI.class.php");

##调用说明：
使用方法参考：examples\testLink.php
    //linkCorp 关联企业相关接口添加，增加功能清单如下：
    const Link_Get_Perm_List     = '/cgi-bin/linkedcorp/agent/get_perm_list?access_token=ACCESS_TOKEN';//获取应用的可见范围
    const Link_USER_GET          = '/cgi-bin/linkedcorp/user/get?access_token=ACCESS_TOKEN'; //获取互联企业成员详细信息
    const Link_USER_SIMPLE_LIST  = '/cgi-bin/linkedcorp/user/simplelist?access_token=ACCESS_TOKEN'; //获取互联企业部门成员
    const Link_USER_LIST         = '/cgi-bin/linkedcorp/user/list?access_token=ACCESS_TOKEN'; //获取互联企业部门成员详情
    const Link_DEPARTMENT_LIST   = '/cgi-bin/linkedcorp/department/list?access_token=ACCESS_TOKEN'; //获取互联企业部门列表
    const Link_MESSAGE_SEND      = '/cgi-bin/linkedcorp/message/send?access_token=ACCESS_TOKEN'; //互联企业的应用支持推送文本、图片、视频、文件、图文等类型。

后续将加入企业互联的相关功能。
