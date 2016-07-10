# 数据字典


### 会员系列

+ 用户账户表（user）：用户（会员、商家、子帐号、管理员）基本登陆信息
+ 会员表（member）
+ 会员评价表（member_review）：用户收到的评价
+ 会员收货地址（address）
+ 会员定位记录（location）
+ 收藏表（favorites）：包括商家、商品
+ 消息表（message）
+ 消息设置表（message_setting）

### 商品系列
+ 商品表（goods）：存储商品共有信息，价格范围、描述等；
+ 商品元数据（goods_meta）；存储商品元数据；
+ 单品表（sku）；单品：对一种商品而言，当其品牌、型号、配置、等级、花色、包装容量、单位、生产日期、保质期、用途、价格、产地等属性与其他商品存在不同时，可称为一个单品；
+ 单品元数据（sku_meta）；存储规格数据等，前台根据规格数据组合单品选择项；
+ 库存表（stock）：sku在各个仓库的库存数据
+ 价格表（price）：存储商品价格；
+ 分类表（category）：存储分类信息，根据分类设定选择商品创建模板，保证金等；
+ 商品分类关系表（goods_category）：存储商品分类关系
+ 规格表（specification）：存储商品规格信息；
+ 规格数据表（spec_item）：存储商品规格数据信息
+ 品牌表（brand）：存储品牌信息
+ 分类品牌表（category_brand）：存储分类品牌对应关系
+ 分类模型表（category_model）：分类模型
+ 分类模型属性表（category_model_property）：分类模型属性；
+ 分类模型属性数据表（category_model_item）：分类模型属性数据
+ 单品模型关系表（sku_category_model_property）：存储分类与模型属性关系


### 商家系列

+ 商户表（merchant）：存储商户信息。
+ 商户等级表（merchant_grade）
+ 申请入驻（merchant_join）
+ 续签（merchant_renew）
+ 商户其他成本（merchant_cost）（购买促销工具、罚款、奖励等，正向为收入，负向为支持）
+ 商户账户分组（merchant_account_group）
+ 商户日志（merchant_log）
+ 店铺表（shop）：存储店铺信息。
+ 店铺导航（shop_navigation）
+ 连锁门店（chain）
+ 店铺自定义分类表（shop_category）：店铺自定义分类，与商品多对多。
+ 仓库表（warehouse）：存储仓库名称、地理位置等信息。拆单依据仓库拆分。仓库与店铺属于多对多关系，有一定权限
+ 店铺发货地址（shop_address）：
+ 店铺装修（shop_decoration）：
+ 店铺水印（shop_watermark）：
+ 店铺版式（shop_template）：
+ 店铺平均（shop_review）：用户针对店铺的评价
+ 运费模板（transport）
+ 运费模板扩展（transport_extend）
+ 供应商（supplier）
+ 结算表（settlement）：系统根据订单、结算周期、商家收支自动给商家进行结算


### 订单系列
+ 订单表（order）
+ 订单商品表（order_item）
+ 支付方式（payment_method）
+ 支付记录（payment）
+ 退款记录（refund）
+ 购物车（cart）
+ 购物车商品表（cart_item）
+ 发票表（invoice）


### 促销系列
+ 促销表（marketing）
+ 优惠券（coupon）
+ 团购（group_buy）
+ CPS推广（cps）

### 商家服务
+ 商家认证（certification）：商家认证情况
+ 认证项目（certification_item）：认证项目
+ 认证申请（certification_apply）：含加入和取消
+ 认证记录（certification_log）：


### 商品评价与讨论
+ 商品评价表（goods_review）：商品评价；
+ 商品评价回复表（goods_reply）：商品评价回复；
+ 商品印象（goods_impression）：买家对商品的印象
+ 商品讨论（discuss）：商品讨论；分为晒单、讨论、问答
+ 商品咨询（consultation）：商品咨询一问一答，包括商品，库存、支付、发票保修等

### 售前/售后
+ 反馈意见（feedback）（待定）
+ 交易纠纷裁定（referee）：裁定各类不能自动处理问题。此表以发起申请/记录为主，主要裁定以人工处理


### cms功能系列
+ 文章表（article）
+ 文章分类表（article_category）
+ 文章评论表（comment）
+ 单页专题表（page）
+ 活动表（activity）
+ 相册（album）
+ 相册分类（album_category）
+ 图片（image）
+ 布局表（layout）
+ 模块表（block）：兼具广告位功能
+ 模块数据表（block_item）
+ 模块样式表（block_template）(待定)



### 其他
+ 系统文档表（document）
+ 文件上传表（upload）
+ 任务计划（schedule）
+ 队列（queue）
+ 区域信息表（region）
+ 快递公司（express）
+ 快递单模板（express_template）
+ 合作伙伴/友情链接（link）



