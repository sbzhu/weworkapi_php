<?php

include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");

/*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File MediaTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */
 
$api = new CorpAPI("wwfedd7e5292d63a35", "EL39AdrLeo0wkTR2Taiczl9KDw-V4YFumfV4zmGtKxY");
try {
    //
    $mediaId = $api->MediaUpload("test.php", "file");
    echo $mediaId."\n";

    //
    $data = $api->MediaGet($mediaId);
    var_dump($data);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
}
