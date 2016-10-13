/**
 * Created by Shen.L on 2016/10/12.
 */
var $document,$window,$body;
var sMall = function ($) {
    var alertModal = '<div class="modal fade" id="app-alert-modal" tabindex="-1" role="dialog" aria-labelledby="appAlertModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="appAlertModalLabel">提示信息</h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary modal-confirm-ok">确定</button></div> </div> </div> </div>';
    var confirmModal = '<div class="modal fade" id="action-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="appConfirmModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="appConfirmModalLabel">提示信息</h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="button" class="btn btn-primary modal-confirm-ok">确定</button></div> </div> </div> </div>';
    var pub = {
        init: function () {
            console.log('app init');
        },
        getSelectedKeys:function (ok,message) {
            var selection = $("input[name='selection[]']:checked"),
                res = [];
            $.each(selection, function (i, item) {
                res.push(item.value);
            });
            if(res.length<=0) {
                sMall.alert('没有选择项目！');
                return res;
            }
            console.log(res);
            if(message){
                sMall.confirm(message,function () {
                    !ok||ok(res);
                });
            }else {
                !ok||ok(res);
            }
            return res;
        },
        reloadAjaxContent:function () {
            $document.find('.ajax-content-wrap').load($document.find('.ajax-content').data('url') + ' .ajax-content');
        },
        alert:function (message,ok) {
            var isOk = false;
            var modal = $(document).find('#action-alert-modal');
            if (modal.length <= 0) modal = $(alertModal);
            modal.find('.modal-body').text(message);
            modal.modal('show');
            modal.find('.modal-confirm-ok').one('click', function (e) {
                isOk = true;
                modal.modal('hide');
                !ok || ok();
            });
            modal.one('hide.bs.modal', function (e) {
                modal.find('.modal-confirm-ok').off('click');
            });
        },
        confirm:function (message, ok, cancel) {
            var isOk = false;
            var modal = $(document).find('#action-confirm-modal');
            if (modal.length <= 0) modal = $(confirmModal);
            modal.find('.modal-body').text(message);
            modal.modal('show');
            modal.find('.modal-confirm-ok').one('click', function (e) {
                isOk = true;
                modal.modal('hide');
                !ok || ok();
            });
            modal.one('hide.bs.modal', function (e) {
                modal.find('.modal-confirm-ok').off('click');
                isOk || !cancel || cancel();
            });
        }
    };
    return pub;

}(jQuery);

jQuery(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $document = $(document);
    $window = $(window);
    $body = $('body');
    yii.initModule(sMall);
});