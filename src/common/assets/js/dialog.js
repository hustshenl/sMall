/**
 * Created by Shen.L on 2016/10/19.
 */

yii.dialog = function ($) {

    var $$document = $(document);
    var pub = {
        clickableSelector: 'dlg',
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
        init: function () {
            initDataMethods();
        },
        notify: function (data) {
            if (!data) return;
            if (data.type == undefined || data.title == undefined) return;
            toastr[data.type](data.content == undefined ? null : data.content, data.title);
        },
        alert: function ($e, options) {
            krajeeDialog.options['title'] = '提示信息';
            krajeeDialog.options['type'] = 'type-'+(options.type||'danger');
            krajeeDialog.alert(options.alert);
        },
        confirm: function ($e, options) {
            krajeeDialog.options['title'] = options.title||'提示信息';
            krajeeDialog.options['type'] = 'type-'+(options.type||'info');
            krajeeDialog.confirm(options.confirm, function (res) {
                if (res) {
                    if (typeof options.success == 'function') return options.success();
                    var method = $e.data('method') || 'GET',
                        params = $e.data('params'),
                        url = $e.data('href'),
                        pjax = $e.data('pjax')||false,
                        reload = $e.data('reload') || false;
                    params = $.extend({},pub.params, params);
                    handleAction(url,method,params,reload,pjax);
                    /*$.ajax({
                        url: url, data: pub.params, type: method,
                        success: function (res) {
                            if (res.status == 0) {
                                if(reload){
                                    if(pjax)
                                        return $.pjax.reload("#content-body");
                                    return window.location.reload();
                                }
                                if(res.redirect){
                                    if(pjax) {
                                        return $.pjax({url:res.redirect,container:'.content-body'});
                                    }else{
                                        return window.location.href = res.redirect;
                                    }
                                }
                            }
                            if (typeof (res.data) == 'string') {
                                pub.notify({type: res.status == 0 ? 'success' : 'error', title: res.data});
                            } else {
                                pub.notify(res.data);
                            }
                        },
                        error: function (xhr,statusText,error) {
                            pub.notify({type: 'error', title: xhr.responseText});
                        },
                        dataType: 'json'
                    });*/
                } else {
                    if (typeof options.cancel == 'function') return options.cancel();
                }
            });
        },
        prompt: function ($e, options) {
            krajeeDialog.options['type'] = 'type-'+(options.type||'info');
            krajeeDialog.options['title'] = options.title||'提示信息';
            krajeeDialog.prompt({label: options.label, placeholder: options.placeholder}, function (res) {
                if (res !== null) {
                    if (typeof options.success == 'function') return options.success(res);
                    var method = $e.data('method') || 'GET',
                        params = $e.data('params'),
                        field = $e.data('field'),
                        url = $e.data('href'),
                        pjax = $e.data('pjax')||false,
                        reload = $e.data('reload') || false;
                    params = $.extend({},pub.params, params);
                    if(field) params[field] = res;
                    handleAction(url,method,params,reload,pjax);
                }
                console.log(res);
            });
        }
    };

    function initDataMethods() {
        var handler = function (event) {
            var $this = $(this),
                options = {
                    title:$this.data('title') || '提示信息',
                    type:$this.data('type') || 'info',
                    method: $this.data('method') || 'GET',
                    label: $this.data('label') || '请输入',
                    placeholder: $this.data('placeholder') || '',
                    reload: $this.data('reload') || false,
                    url: $this.data('href'),
                    params: $this.data('params'),
                    alert: $this.data('alert') || '操作失败！',
                    prompt: $this.data('prompt') || '确定要执行该操作吗？',
                    confirm: $this.data('confirm') || '确定要执行该操作吗？',
                },
                mode = $this.data('mode');
            if (mode === undefined) {
                return true;
            }
            pub[mode]($this, options);
            event.stopImmediatePropagation();
            return false;
        };
        pub.refreshCsrfToken();
        $(document).off('click.yiiDialog', pub.clickableSelector)
            .on('click.yiiDialog', pub.clickableSelector, handler);
    }
    function handleAction(url,method,params,reload,pjax) {
        $.ajax({
            url: url, data: params, type: method||'POST',
            success: function (res) {
                if (res.status == 0) {
                    if(reload){
                        if(pjax)
                            return $.pjax.reload("#content-body");
                        return window.location.reload();
                    }
                    if(res.redirect){
                        if(pjax) {
                            return $.pjax({url:res.redirect,container:'.content-body'});
                        }else{
                            return window.location.href = res.redirect;
                        }
                    }
                }
                if (typeof (res.data) == 'string') {
                    pub.notify({type: res.status == 0 ? 'success' : 'error', title: res.data});
                } else {
                    pub.notify(res.data);
                }
            },
            error: function (xhr,statusText,error) {
                pub.notify({type: 'error', title: xhr.responseText});
            },
            dataType: 'json'
        });
    }

    return pub;
}(jQuery);

