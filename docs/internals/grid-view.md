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

