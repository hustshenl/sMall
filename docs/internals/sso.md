# 单点登陆（SSO）


### 基本方案
单点登陆采用被动方式，登陆后直接跳转到指定，指定页面自行通过jsonp方式获取登陆信息并写入cookie。

+ 登陆流程
    + 应用发起登陆申请，浏览器跳转到通行证登陆页面
    + 用户登陆通行证，检查回跳URL，若存在则跳转到该URL，否则进入通行证管理中心
    + 应用通过jsonp获取授权URL，通过授权URL获得用户身份信息，写入cookie

+ 退出流程

    + 应用通过jsonp获取退出应用列表，根据列表逐个退出应用
    + 全部应用退出完毕后跳转到指定页面

+ 登陆加密
    
    服务端生成RSA公私密钥，将私钥保存在缓存中，公钥随JS写入页面，js通过公钥将密码加密，POST提交到服务端，服务端通过私钥解密，然后执行后续登陆操作

+ 授权加密

    后台填写各应用授权加密密钥，后台根据密钥加密用户信息，各应用解密后做登陆处理

### 使用说明

首先在应用配置文件变量
```
var config = {
    sso: {
        host: '//passport.small.dev.com',
    }
};
```
然后引入@resource/js/sso.js；

使用：

```
<p><a href="javascript:sso.verify(function(res) {console.log(res)}).done(function (res) {console.log(res);});">验证用户信息</a></p>
<p><a href="javascript:console.log(sso.getUser());">打印本地用户信息</a></p>
<p><a href="javascript:sso.exit().done(function(res) {console.log(res);window.location.href='/';}).fail(function (res) {console.log(res);});">退出登陆</a></p>
```