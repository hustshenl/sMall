/**
 * Created by Shen.L on 2015/11/7.
 */
var ComicIndex = function () {

    var getSelection = function () {
        var selection = $("input[name='selection[]']:checked");
        var res = [];
        $.each(selection, function (i, item) {
            res.push(item.value);
        });
        return res;
    };
    var batchOperation = function (action) {
        var selection = getSelection();
        $.post(url, {ids: selection, action: 'approve'}, function (res) {
            window.location.reload();
        }, 'json');
    };

    return {

        init: function () {
            //handleBatchOperation();
        },
        modifyCategory: function (id) {
            var selection = getSelection();
            if (selection.length <= 0) {
                alert('没有选择项目！');
                return;
            }
            if (!confirm('确实要修改选中章节的类型吗?')) return;
            $.post('modify-category?cid='+id,{ids: selection}, function (res) {
                Notify.notify({type: res.status > 0 ? "error" : "success", title: res.data});
                window.location.reload();
                //$.pjax.reload({container:"#pjax-container"});
            }, 'json');
        },
        batchOperation: function (action) {
            var selection = getSelection();
            if(selection.length<=0) {alert('没有选择项目！');return;}
            if(!confirm('确实要执行该批量操作吗?')) return;
            var url = 'ajax-batch-operation';
            $.post(url, {ids: selection, action: action}, function (res) {
                Notify.notify({type:res.status>0?"error":"success",title:res.data});
                //$.pjax.reload({container:"#pjax-container"});
                window.location.reload();
            }, 'json');
        },
        deleteItem : function (id) {
            if(!confirm('确实要删除该漫画吗?')) return;
            $.post('delete?id='+id, function (res) {
                Notify.notify({type:res.status>0?"error":"success",title:res.data});
                window.location.reload();
                //$.pjax.reload({container:"#pjax-container"});
            }, 'json');
        },
        refreshItem : function (id) {
            if(!confirm('确实要刷新该漫画吗?')) return;
            $.post('refresh?id='+id, function (res) {
                Notify.notify({type:res.status>0?"error":"success",title:res.data});
                //window.location.reload();
                //$.pjax.reload({container:"#pjax-container"});
            }, 'json');
        }

    };
}();