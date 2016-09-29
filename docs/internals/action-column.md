# ActionColumn(操作列)

操作列定义好一系列操作，在GridView可以直接调用，一般包括查看，更新，删除。

### 使用方法


```
[
    'class' => 'common\widgets\ActionColumn',
    'template' => '{:view} {:update} {:delete}'
]
```

### 方案说明

+ 查看。分为三种模式：新窗口{view::_blank}、弹出层{view}、当前列下方{view::bottom}
+ 更新。分两种模式：新窗口{:update-blank}、弹出层{:update}
+ 删除。弹窗提示然后ajax删除数据并隐藏当前行{:delete}

