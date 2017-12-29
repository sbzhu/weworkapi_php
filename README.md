# About
weworkapi_php 是为了简化开发者对企业微信API接口的使用而设计的，API调用库系列之php版本  
包括企业API接口、消息回调处理方法、第三方开放接口等  

# Requirement
经测试，PHP 5.3.3 ~ 7.2.0 版本均可使用

# Director 

├── api // API 接口  
│   ├── datastructure // API接口需要使用到的一些数据结构  
│   ├── examples // API接口的测试用例  
│   ├── README.md  
│   └── src // API接口的关键逻辑  
├── callback // 消息回调的一些方法  
├── config.php   
├── README.md  
└── utils // 一些基础方法  

# Usage
将本项目下载到你的目录，既可直接引用相关文件  
```
// 实例化 API 类
$api = new CorpAPI($corpId='ww55ca070cb9b7eb22', $secret='ktmzrVIlUH0UW63zi7-JyzsgTL9NfwUhHde6or6zwQY');

// 创建 User
$user = new User();
{
        $user->userid = "userid";
        $user->name = "name";
        $user->mobile = "131488888888";
        $user->email = "sbzhu@ipp.cas.cn";
        $user->department = array(1); 
} 
$api->UserCreate($user);

// 获取User
$user = $api->UserGet("userid");

// 删除User
$api->UserDelete("userid");
```
详细使用方法参考每个模块下的测试用例

# Contact us
abelzhu@tencent.com  
xiqunpan@tencent.com  
