/**
 * Created by Shen.L on 2016/10/12.
 */

sMall.member = function ($) {
    var $document = $(document);

    var pub = {
        init: function () {
            console.log('member init');
            $document.on('click','#test',function (e) {
                toastr['success']('test');
                console.log($document.find('.ajax-content').data('url'));
                $document.find('.ajax-content-wrap').load($document.find('.ajax-content').data('url') + ' .ajax-content');
            });
        },
    };
    return pub;

}(jQuery);