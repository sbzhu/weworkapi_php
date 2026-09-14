<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File config.php
 * @Brief 
 * @Author abelzhu, <AUTHOR_EMAIL>
 * @Version 1.0
 * @Date 2017-12-27
 *
 */

// 请将下面参数改为自己的企业相关参数再进行测试

return array (
    // 企业的id，在管理端->"我的企业" 可以看到
    "CORP_ID"               => "<CORP_ID>",

    // "通讯录同步"应用的secret, 开启api接口同步后，可以在管理端->"通讯录同步"看到
    "CONTACT_SYNC_SECRET"   => "<CONTACT_SYNC_SECRET>",

    // 某个自建应用的id及secret, 在管理端 -> 企业应用 -> 自建应用, 点进相应应用可以看到
    "APP_ID"                => "<APP_ID>",
    "APP_SECRET"            => "<APP_SECRET>",

    // 打卡应用的 id 及secrete， 在管理端 -> 企业应用 -> 基础应用 -> 打卡，
    // 点进去，有个"api"按钮，点开后，会看到
    "CHECKIN_APP_ID"        => "<CHECKIN_APP_ID>",
    "CHECKIN_APP_SECRET"    => "<CHECKIN_APP_SECRET>",

    // 审批应用的 id 及secrete， 在管理端 -> 企业应用 -> 基础应用 -> 审批，
    // 点进去，有个"api"按钮，点开后，会看到
    "APPROVAL_APP_ID"       => "<APPROVAL_APP_ID>",
    "APPROVAL_APP_SECRET"   => "<APPROVAL_APP_SECRET>",
);
