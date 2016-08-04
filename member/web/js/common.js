/**
 * Created by Shen.L on 2015/11/7.
 */

var SinMH = function () {
    return {

        init: function () {
        },
        handleSearchForm : function (trigger,form) {
            $(trigger).click(function () {
                if($(form).hasClass('hide')){
                    $(form).removeClass('hide');
                }else{
                    $(form).addClass('hide');
                }
            });
        }
    };
}();