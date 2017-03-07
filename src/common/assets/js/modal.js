/**
 * Created by Lei on 2015/6/9.
 */


yii.modal = (function ($) {
    var pub = {
        clickableSelector: 'act, a.action-view',
        isActive: true,
        init: function () {
            initDataMethods();
        },
        notify: function (data) {
            if (!data) return;
            if (data.type == undefined || data.title == undefined) return;
            toastr[data.type](data.content == undefined ? null : data.content, data.title);
        },
        initModal: function (trigger,target,enableAjaxSubmit) {
            var $trigger = $(trigger);
            $trigger.click(function(e) {
                $('.modal-content').html('');
                var modal = $(document).find(target),
                    title = $trigger.data('title') || '',
                    url = $trigger.data('href');
                console.log(url);
                modal.find('.modal-content').load(url, function (res, status) {
                        if (status == 'error') {
                            return pub.notify({type: 'error', title: res});
                        } else if (status == 'timeout') {
                            return pub.notify({type: 'error', title: '连接超时'});
                        }
                        modal.modal('show');
                        if (false !== enableAjaxSubmit) {
                            modal.off('submit');
                            pub.handleModal($trigger, modal);
                        }
                    });
                e.preventDefault();
            });
        },
        handleModal: function ($trigger, modal) {
            var submitted = false;
            modal.on('submit', 'form',function (event) {
                event.preventDefault();
                if (submitted) return false;
                submitted = true;
                var $this = $(this);
                $this.ajaxSubmit(function (res) {
                    if (typeof yii.modal.onSuccess == 'function') {
                        yii.modal.onSuccess(res, modal);
                    }
                });
                return false;
            })

        },
        onSuccess: function (res, modal) {
            if (typeof (res.data) == 'string') {
                pub.notify({type: res.status == 0 ? 'success' : 'error', title: res.data});
            } else {
                pub.notify(res.data);
            }
            modal.modal('hide');
            $.pjax.reload("#pjax-content");
        },
    };

    function initDataMethods() {
    }

    return pub;

})(jQuery);