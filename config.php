<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File config.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-27
 *
 */
 
return array(
    'DEBUG' => true, // 是否打印debug信息。注意，此为true时，会在返回结果中带curl 请求详情，而不仅仅是 json。正式使用时需要改成 false。
    'corp' => [
        'corpId' => 'ww913f78bb23341760',
        'agentId' => '',
        'secretKey' => '', // agent所对应的 secret
    ],
    'redis' => [
        'host'=>'',
        'auth'=>'',
        'db'=>0,
    ]
);
