# About
此项目是Fork自https://github.com/sbzhu/weworkapi_php。原项目基本无后续开发，因此自己加了一些新功能进来。
主要增加的有：

1. 互联企业相关（注：小程序暂不支持互联企业用户，因为无法解code）：参考 api\examples\testLink.php
    * 互联企业消息推送
    * 互联企业的通讯录信息获取（成员、部门等）
1. 消息发送：增加了新进企业微信消息发送功能：
    * MarkDown消息发送；
    * 小程序消息发送；
    * 任务卡片消息发送（需要企业微信应用有回调功能支持）；

## 其他新增功能：
请进入 https://github.com/logmecn/weworkapi 查看，除以上功能外还有：
1. 使用Redis缓存。在 config 文件中修改配置。
1. 使用composer加载

后续会继续增加丰富其功能。   
如果有需要新增功能，请发 issue 或 PR，会第一时间回复。

# 原说明
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
PHP 5.4 ~ 7.4 版本均可使用，PHP8.0未测试，理论上应该也ok。

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
xiqunpan@tencent.com  

# 
