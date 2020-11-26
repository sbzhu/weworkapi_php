# About
weworkapi_php 是为了简化开发者对企业微信API接口的使用而设计的，API调用库系列之php版本    
包括企业API接口、消息回调处理方法、第三方开放接口等    
本库仅做示范用，并不保证完全无bug；  
另外，作者会不定期更新本库，但不保证与官方API接口文档同步，因此一切以[官方文档](https://work.weixin.qq.com/api/doc)为准。

更多来自个人开发者的其它语言的库推荐：   
python : https://github.com/sbzhu/weworkapi_python  abelzhu@tencent.com(企业微信团队)  
ruby ： https://github.com/mycolorway/wework  MyColorway(个人开发者)  
php : https://github.com/sbzhu/weworkapi_php  abelzhu@tencent.com(企业微信团队)  
golang : https://github.com/sbzhu/weworkapi_golang  ryanjelin@tencent.com(企业微信团队)  
golang : https://github.com/doubliekill/EnterpriseWechatSDK  1006401052yh@gmail.com(个人开发者)  

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
include_once("api/src/CorpAPI.class.php");

// 实例化 API 类
$api = new CorpAPI($corpId='ww55ca070cb9b7eb22', $secret='ktmzrVIlUH0UW63zi7-JyzsgTL9NfwUhHde6or6zwQY');

try { 
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
} catch {
    echo $e->getMessage() . "\n";
    $api->UserDelete("userid");
}
```
详细使用方法参考每个模块下的测试用例

# 关于token的缓存
token是需要缓存的，不能每次调用都去获取token，[否则会中频率限制](https://work.weixin.qq.com/api/doc#10013/%E7%AC%AC%E5%9B%9B%E6%AD%A5%EF%BC%9A%E7%BC%93%E5%AD%98%E5%92%8C%E5%88%B7%E6%96%B0access_token)  
在本库的设计里，token是以类里的一个变量缓存的  
比如api/src/CorpAPI.class.php 里的$accessToken变量  
在类的生命周期里，这个accessToken都是存在的， 当且仅当发现token过期，CorpAPI类会自动刷新token   
刷新机制在 api/src/API.class.php  
所以，使用时，只需要全局实例化一个CorpAPI类，不要析构它，就可一直用它调函数，不用关心 token  
```
$api = new CorpAPI(corpid, corpsecret);
$api->dosomething()
$api->dosomething()
$api->dosomething()
....
```
当然，如果要更严格的做的话，建议自行修改，```全局缓存token，比如存redis、存文件等```，失效周期设置为2小时。

# Contact us
abelzhu@tencent.com  
xiqunpan@tencent.com  

# 
