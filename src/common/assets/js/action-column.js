/**
 * Created by Lei on 2015/6/9.
 */


yii.actionColumn = (function ($) {
    var messageModal = '<div class="modal fade" id="action-message-modal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="messageModalLabel">提示信息</h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="button" class="btn btn-primary modal-confirm-ok">确定</button></div> </div> </div> </div>';
    var viewModal = '<div class="modal fade" id="action-view-modal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="viewModalLabel"></h4></div><div class="modal-body"></div> </div> </div> </div>';
    var bottomView = '<tr id="action-bottom-view"><td style="padding: 8px 0;"></td></tr>';
    var pub = {
        clickableSelector: 'act, a.action-view',
        isActive: true,
        params: {},
        getCsrfParam: function () {
            return $('meta[name=csrf-param]').prop('content');
        },
        getCsrfToken: function () {
            return $('meta[name=csrf-token]').prop('content');
        },
        setCsrfToken: function (name, value) {
            $('meta[name=csrf-param]').prop('content', name);
            $('meta[name=csrf-token]').prop('content', value)
        },
        refreshCsrfToken: function () {
            var token = pub.getCsrfToken();
            if (token) {
                pub.params[pub.getCsrfParam()] = token;
            }
        },
        confirm: function (message, ok, cancel) {
            var isOk = false;
            var modal = $(document).find('#action-message-modal');
            if (modal.length <= 0) modal = $(messageModal);
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
        },
        handleAction: function ($e) {
            var method = $e.data('method'),
                url = $e.data('href'),
                action = $e.data('action'),
                params = $e.data('params'),
                mode = $e.data('mode'),
                pjax = $e.data('pjax');

            //通过Ajax处理删除和刷新
            if (!url || !url.match(/(^\/|:\/\/)/)) {
                url = window.location.href;
            }
            $.extend(pub.params, params);
            if (mode == 'ajax') {
                $.post(url, pub.params,
                    function (res) {
                        if (action == 'delete' && res.status == 0) {
                            $e.parents('tr').hide();
                        }
                        if (typeof (res.data) == 'string') {
                            pub.notify({type: res.status == 0 ? 'success' : 'error', title: res.data});
                        } else {
                            pub.notify(res.data);
                        }
                    },
                    'json'
                );
            } else if (mode == 'bottom') {
                var view = $(document).find('#action-bottom-view');
                var tr = $e.parents('tr');
                if (view.length <= 0) {
                    view = $(bottomView);
                    view.find('td').attr('colspan', tr.find('td').length);
                }
                if (view.data('key') == tr.data('key')) {
                    return tr.parent().append(view.hide().data('key', 0));
                }
                view.show().data('key', tr.data('key'));
                var content = view.find('td');
                content.load(url + ' .action-ajax-content');
                tr.after(view);
                $("html,body").animate({scrollTop: $("#action-bottom-view").prev().offset().top}, 800);
            } else {
                var modal = $(document).find('#action-view-modal');
                if (modal.length <= 0) modal = $(viewModal);
                modal.modal('show');
                modal.find('.modal-body').empty().load(url + ' .action-ajax-content');
            }

        },
        init: function () {
            initDataMethods();
        },
        notify: function (data) {
            if (!data) return;
            if (data.type == undefined || data.title == undefined) return;
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
            toastr[data.type](data.content == undefined ? null : data.content, data.title);
        }

    };

    function initDataMethods() {
        var handler = function (event) {
            var $this = $(this),
                method = $this.data('method'),
                message = $this.data('confirm'),
                raw = $this.data('raw');
            if (raw) {
                event.stopImmediatePropagation();
                return true;
            }
            if (method === undefined && message === undefined) {
                return true;
            }
            if (message !== undefined) {
                pub.confirm(message, function () {
                    pub.handleAction($this);
                });
            } else {
                pub.handleAction($this);
            }
            event.stopImmediatePropagation();
            return false;
        };
        pub.refreshCsrfToken();
        $(document)
            .on('click.yiiAction', pub.clickableSelector, handler);
    }

    return pub;

})(jQuery);