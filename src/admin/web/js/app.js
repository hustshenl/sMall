/**
 * Created by Shen.L on 2016/10/12.
 */
var $document,$window,$body;
var sMall = function ($) {
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
                yii.dialog.alert(null,{alert:'没有选择任何项目！'});
                return res;
            }
            if(message){
                yii.dialog.confirm(null,{confirm:message,success:function () {
                    !ok||ok(res);
                }});
            }else {
                !ok||ok(res);
            }
            return res;
        },
        ajaxReload:function (url,container) {
            $document.find(container||'#content-body').load(url||window.location.href);
        },
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