# 页面自定义DIY

可以DIY的页面包括`商城首页`，`page`，`店铺首页`。

### 基本设计

+ 各个页面模板设计时加载DIY挂件；
+ DIY挂件根据ID从layout表读取布局样式；
+ 然后根据layout的ID从block表读取模块数据；
+ 若有手工添加的数据，则从block_item表读取



