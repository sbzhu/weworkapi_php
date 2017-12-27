<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File MenuTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */
 
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");
// 
$agentId = 1000029;
$api = new CorpAPI("wwfedd7e5292d63a35", "EL39AdrLeo0wkTR2Taiczl9KDw-V4YFumfV4zmGtKxY");

try { 
    //
    $subMenu = new SubMenu(
        "subMenu_1", 
        array(
            new viewMenu("viewMenu_1", "www.qq.com"), 
            new viewMenu("viewMenu_2", "www.baidu.com")
        )
    );
    $scanCodePushMenu = new ScanCodePushMenu(
        "ScanCodePushMenu", 
        null, 
        array(
            new viewMenu("viewMenu_3", "www.qq.com"), 
            new PicWeixinMenu( "PicWeixinMenu", "keykeykey", null),
        )
    );

    $menu = new Menu(
        array(
            $subMenu,
            $scanCodePushMenu
        )
    );
    $api->MenuCreate($agentId, $menu);

    //
    $menu = $api->MenuGet($agentId);
    var_dump($menu);

    //
    $api->MenuDelete($agentId);

} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}

