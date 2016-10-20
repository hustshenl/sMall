# 对话框

### 基本方案

添加`dialog.js`处理所有基本弹出层。
依据html自身data属性进行ajax交互，然后视情况reload `.content-body`

dialog支持alert confirm prompt三种形式，下面分别介绍三种形式的使用方法

### alert
1. PHP调用
```

<?= \common\widgets\Dialog::alert(
    Yii::t('rbac-admin', 'Alert'),
    [
        'class' => 'btn btn-danger',
        'data-alert' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
        'data-method' => 'post',
    ]
); ?>
```
2. JS调用
```
yii.dialog.alert(null,{
    alert:'没有选择任何项目！',
    title:'警告',
    type:'danger',
});
```
### confirm
1. PHP调用
```

<?= \common\widgets\Dialog::confirm(
    Yii::t('rbac-admin', 'Confirm'),
    [
        'class' => 'btn btn-info',
        'data-href' => ['delete', 'id' => $model->id],
        'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
        'data-method' => 'post',
    ]
); ?>
```
2. JS调用
```
yii.dialog.alert(null,{
    confirm:'确定要执行该操作',
    title:'警告',
    type:'info',
    success:function(){}
});
```
### confirm
1. PHP调用
```
<?= \common\widgets\Dialog::prompt(
    Yii::t('rbac-admin', 'Prompt'),
    [
        'class' => 'btn btn-danger',
        'data-href' => ['delete', 'id' => $model->id],
        'data-label' => '请输入文字',
        'data-method' => 'post',
    ]
); ?>
```
2. JS调用
```
yii.dialog.alert(null,{
    label:'请输入内容',
    placeholder:'输入提示',
    title:'警告',
    type:'info',
    success:function(){}
});
```


