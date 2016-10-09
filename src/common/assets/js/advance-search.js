/**
 * Created by Shen.L on 2016/10/8.
 */

yii.advanceSearch = function ($) {
    var pub = {
        trigger:function (trigger) {
            $(document).off('click.yiiAdvanceSearch')
                .on('click.yiiAdvanceSearch',trigger,function (e) {
                var $body = $('body');
                if($body.hasClass('advance-search-open')){
                    $body.removeClass('advance-search-open');
                }else {
                    $body.addClass('advance-search-open');
                }
            });
            $("#advance-search-panel").find("form").slimscroll({
                height: 'auto',
                alwaysVisible: false,
                size: '5px'
            });
        }
    };
    return pub;
}(jQuery);