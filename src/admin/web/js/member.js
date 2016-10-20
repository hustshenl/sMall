/**
 * Created by Shen.L on 2016/10/12.
 */

sMall.member = function ($) {
    var pub = {
        init: function () {
            console.log('member init');
            $document.on('click','#test',function (e) {
                var $this = $(this),url = $this.data('url');
                toastr['success']('test');
                sMall.ajaxReload(url+' .member-view-body','.member-view');
            });
            $document.off('click','.multi-select').on('click','.multi-select',function (e) {
                var keys = sMall.getSelectedKeys(function (res) {
                    // TODO 根据选择的keys做后续操作
                    console.log('进行了操作');
                    toastr['success']('批量操作成功');
                    toastr['error']('你没有权限执行此操作');
                    $.pjax.reload("#pjax-content");
                    //sMall.ajaxReload();
                    console.log(res);
                },'确定要执行该批量操作？');
            });
        },
    };
    return pub;

}(jQuery);