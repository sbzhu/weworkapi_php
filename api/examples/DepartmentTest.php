<?php /*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File DepartmentTest.php
 * @Brief 
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */

include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");

// 需启用 "管理工具" -> "通讯录同步", 并使用该处的secret, 才能通过API管理通讯录
$api = new CorpAPI("wwfedd7e5292d63a35", "CyeISAmDEps8gzRDQtLlvAr4B9PIjH1uQpbNmHH0Gj8");

 
try { 
    //
    $department = new Department();
    {
        $department->name = "department_32";
        $department->parentid = 1;
        $department->id = 9;
    }
    $departmentId = $api->DepartmentCreate($department);
    echo $departmentId . "\n";

    //
    $department->name = "department_33";
    $api->DepartmentUpdate($department);

    //
    $departmentList = $api->DepartmentList($departmentId);
    var_dump($departmentList);

    //
    $api->DepartmentDelete($departmentId);
} catch (Exception $e) { 
    echo $e->getMessage() . "\n";
    $api->DepartmentDelete($departmentId);
}
