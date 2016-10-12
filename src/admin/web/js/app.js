/**
 * Created by Shen.L on 2016/10/12.
 */

var sMall = function ($) {
    var pub = {
        init: function () {
            console.log('app init');
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
    yii.initModule(sMall);
});