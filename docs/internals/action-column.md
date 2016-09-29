# ActionColumn(操作列)

操作列定义好一系列操作，在GridView可以直接调用，一般包括查看，更新，删除。

### 使用方法

```
[
    'class' => 'common\widgets\ActionColumn',
    'template' => '{view:view:_self} {update} {delete}'
]
```

每个操作格式为 {操作类型:操作名称:打开方式}
操作名称省略默认为操作类型，打开方式省略默认为弹出层，自定义操作方法参考yii相关文档。

### 详细说明

+ 查看。分为三种模式：新窗口{view::_blank}、弹出层{view}、当前列下方{view::bottom}
+ 更新。分两种模式：新窗口{update::_blank}、弹出层{update}
+ 删除。弹窗提示然后ajax删除数据并隐藏当前行{delete}

