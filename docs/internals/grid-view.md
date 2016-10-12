# GridView 关于Grid View的说明

原则上后台列表均采用`kartik\grid\GridView`，由于改项目默认设置了PDF导出，在没有加载PDF组件的时候会导致错误，若不需要PDF导出，请在配置Grid View时候增加`'export' => false,`，示例如下：
```
GridView::widget([
    ...
    'export' => false,
    ...
])
```

### Pjax与Editable
由于Pjax和默认的Editable存在冲突，kartik在editable添加了pjax支持，使用时添加具体pjax id
示例：
```
Pjax::begin(['id'=>'pjax-content']);
...调用GridView，在列里增加EditableColumn，EditableColumn配置如下
    [
        'class' => 'kartik\grid\EditableColumn',
        ..基本配置
        'editableOptions' => [
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            'pjaxContainerId'=>'pjax-content', //此处增加pjax支持，ID与Begin方法配置的一直
            'formOptions' => ['action' => $editableUrl]
        ],

    ],
... 其他代码
Pjax::end();
```

### CheckboxColumn 多选列

使用`kartik\grid\CheckboxColumn`,基本功能已经完善。

### 高级搜索

1. 在适当的地方添加出发元素
2. 适用`common\widgets\AdvanceSearch`挂件添加高级搜索表单，适用方式和普通表单类似，推荐写在搜索模板中。

### 列表状态更新
1. 编辑数据后pjax或者直接刷新当前页（仅针对简单表单，复杂表单需要在新窗口打开）
    1. action列拦截form内的表单提交，改用ajax方式提交；
    2. 收到ajax返回值后，默认弹出提示并隐藏弹出层，并pjax加载列表，列表需要开启pjax并且pjax id为pjax-content，若需自定义，请重写`yii.actionColumn.onSuccess(res, $e, modal)`
2. 执行详情页的操作后如何继续
    1. 详情页操作均采用ajax操作，由于页面无法加载js，所以需要重写`yii.actionColumn.onLoad($e, $obj)`，载入页面初始化方法，注意不要重复绑定事件。
    2. ajax返回数据处理视情况而定
    3. 视情况进行`$.pjax.reload("#pjax-content");`
    4. 推荐将查看和更新的全部自定义JS写到一个js文件，在需要的地方调用初始化即可
    5. Widgets自动添加的JS无法加载，若需要Widgets含有JS代码则不可使用。

