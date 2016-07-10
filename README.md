# sMall 商城系统(开发中)

sMall是一个基于Yii2的商城系统

# 目录结构
```
build/                  内部编译工具
docs/                   项目文档
src/                    源代码
exclude/                排除目录，不进行版本控制
```

# 安装

+ 环境要求：PHP >= 5.5.9, MySql>=5.5

1. 下载项目

`git clone https://github.com/hustshenl/sMall small`

[composer](https://getcomposer.org/)安装第三方组件

```shell
cd small/src
composer update
```
2. 配置数据库信息、域名信息

`vim src/environments/prod/common/config/main-local.php`

填写正确的`dsn`,`username`,`password`,`charset`

3. 运行初始化命令

```shell
// TODO，
生成第三方数据表，
生成商城数据表，
初始化商城数据
```


### TODO

+ TODO
