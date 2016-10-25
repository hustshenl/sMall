# 系统参数配置方案
系统参数是指影响系统运行的相关参数，一般由技术人员进行配置，不包含运营相关参数。

系统参数配置主要包括代码配置，后台配置

1. 代码配置项目为代码部署后改动可能性较小的部分
2. 后台配置项目为较为经常改动的部分

## 代码配置
请参考Yii2 配置说明文档

## 后台配置

后台配置通过数据库保存，经过缓存读取

### 后台配置项目
+ 站点基本信息
+ 商城设置
+ 微信管理/设置
+ 邮件/短信设置

具体使用方法参考ConfigController，具体input问题具体解决

### 后台配置读写

1. 读取
```
Yii::$app->config->get($category,$key); //$key不填则返回整个分类配置
```
2. 写入；写入时使用Form load配置项目，然后
```
Yii::$app->config->set($category, $array);
//推荐使用Model load表单，然后Model属性数组写入配置，实例如下
Yii::$app->config->set("siteInfo", $model->attributes);
```
