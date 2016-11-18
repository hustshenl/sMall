/**
 * 单点登陆JS，
 * 引入本JS之前请务必引入jQuery，以及配置文件（无比包含域名），否则报错
 * Created by Shen.L on 2016/11/13.
 * version 1.0.0
 */

var config = {
    sso: {
        host: '//passport.small.dev.com',
    }
};

var sso = function ($) {
    var store = function () {
        return {
            get: function (key) {
                if (window.localStorage.getItem(key)) {
                    return JSON.parse(window.localStorage.getItem(key));
                }
                return null;
            },
            set: function (key, value) {
                if (value === undefined) {
                    window.localStorage.removeItem(key);
                } else {
                    window.localStorage.setItem(key, JSON.stringify(value));
                }
                return window.localStorage.getItem(key);
            },
        }
    }();

    var modal = function () {
        var ossModal = $('<div style="left: 0;right: 0;top: 0;bottom:0;position: fixed;background-color: rgba(0,0,0,.5);z-index: 9999; display: none;"><div style="margin: 0 auto; text-align: center;display:table;height:100%;"><div style="display: table-cell;vertical-align:middle;"><div style="background: #FFF;position: relative;"><div id="oss-close" style="position: absolute;top: 0;right: 0; font-size: 24px; cursor: pointer;width: 32px;height: 32px">×</div><div id="oss-body" style="height: auto;"><div id="oss-container"></div></div></div></div></div></div>');
        var $body = $('body');
        var ossBody = ossModal.find('#oss-body');
        var ossContainer = ossModal.find('#oss-container');
        ossModal.find('#oss-close').on('click', function (e) {
            modal.hide();
        });
        $body.append(ossModal);
        return {
            show: function (url) {
                $body.addClass('oss-modal');
                ossContainer.html('<span style="line-height: 64px;font-size: 20px;">Loading...</span>');
                ossModal.fadeIn(900);
                ossContainer.load(undefined === url ? config.sso.host + '/sso' : url, function (res) {
                });
            },
            loading:function (message) {
                $body.addClass('oss-modal');
                ossContainer.html('<div style="line-height: 64px;font-size: 20px; width: 320px;">'+message+'</div>');
                ossModal.fadeIn(100);
            },
            hide: function () {
                $body.removeClass('oss-modal');
                ossModal.fadeOut(900);
            }
        }
    }();

    var ssoCallback;

    /**
     * 初始化用户信息
     * @param mode string blank|modal|空字符串
     */
    var initUser = function (mode) {
        var defer = $.Deferred(),
            user = store.get('ssoUser');
        mode = undefined == mode ? 'blank' : mode;
        if (typeof mode === 'function') {
            ssoCallback = mode;
            mode = 'modal';
        }
        //  从localStrong读取用户，若用户为空则从通行证中心读取，若仍然为空则跳转到登陆页面
        if (null !== user) {
            defer.resolve(user);
        } else {
            getSsoUser()
                .done(function (res) {
                    defer.resolve(res);
                })
                .fail(function (res) {
                    if (mode == 'blank') {
                        window.location.href = config.sso.host + '/login';
                    } else if (mode == 'modal') {
                        modal.show(); // 弹出登陆框，登陆完成后执行callback操作（若存在）
                    }
                    defer.reject(res);
                })
        }
        return defer.promise();
    };
    var exit = function () {
        modal.loading('正在退出...');
        var defer = $.Deferred();
        store.set('ssoUser'); // 清除本地用户信息
        syncLogout().done(function (res) {
            modal.hide();
            defer.resolve(res);
        }).fail(function (res) {
            modal.hide();
            defer.reject(res);
        });
        return defer.promise();
    };
    /**
     *
     * @returns {*}|null
     */
    var getUser = function () {
        return store.get('ssoUser');
    };
    /**
     * Ajax获取用户信息
     * @returns {*}
     */
    var getSsoUser = function () {
        var defer = $.Deferred(),
            url = config.sso.host + '/sso/user?t=' + (new Date().getTime()) + '&callback=?';
        $.getJSON(url)
            .done(function (res) {
                if (res.status > 0) {
                    defer.reject(false);
                } else {
                    store.set('ssoUser', res.data);
                    syncLogin().done(function (res) {
                        typeof ssoCallback === 'function' && ssoCallback(res);
                    }).fail(function (res) {
                        typeof ssoCallback === 'function' && ssoCallback(res);
                    });
                    defer.resolve(res.data);
                }
            })
            .fail(function (res) {
                defer.reject(false);
            });
        return defer.promise();

    };

    /**
     * 初始化单点登陆表单
     */
    var initSsoForm = function () {
        var busy = false;
        var loginButton = $('#login-button');
        $("#sso-form").submit(function (e) {
            if (busy)return false;
            busy = true;
            loginButton.text('正在登陆').attr('type', 'button').addClass('disabled');
            var $form = $(this);
            var data = getData($form);
            // 判断数据情况
            if ('' == data.username || '' == data.password) {
                showMessage('请填写账户名或者密码');
                busy = false;
                loginButton.html('登 &nbsp; 陆').attr('type', 'submit').removeClass('disabled');
                return false;
            }
            $.getJSON(config.sso.host + '/sso/salt?t=' + (new Date().getTime()) + '&callback=?').done(function (res) {
                if (res.status != 0) {
                    showMessage('请求失败');
                    busy = false;
                    loginButton.html('登 &nbsp; 陆').attr('type', 'submit').removeClass('disabled');
                    return false;
                }
                var salt = res.data;
                data.password = security.encrypt(data.password, salt);
                $.getJSON(
                    config.sso.host + '/sso/login?t=' + (new Date().getTime()) + '&callback=?',
                    data
                )
                    .done(function (res) {
                        if (res.status > 0) {
                            showMessage(res.msg);
                            busy = false;
                            loginButton.html('登 &nbsp; 陆').attr('type', 'submit').removeClass('disabled');
                            return false;
                        }
                        store.set('ssoUser', res.data);
                        if (typeof ssoCallback === 'function') {
                            // 登录成功，执行回调
                            syncLogin().done(function (res) {
                                modal.hide();
                                ssoCallback(res);
                            }).fail(function (res) {
                                modal.hide();
                                ssoCallback(res);
                            });
                        } else {
                            //  登录成功，刷新页面
                            window.location.reload();
                        }
                    })
                    .fail(function (res) {
                        showMessage('登陆失败');
                        busy = false;
                        loginButton.html('登 &nbsp; 陆').attr('type', 'submit').removeClass('disabled');
                    });

            }).fail(function (res) {
                showMessage('请求失败');
                busy = false;
                loginButton.html('登 &nbsp; 陆').attr('type', 'submit').removeClass('disabled');
            });
            return false;
        });

    };

    /**
     * 同步登陆全部应用
     * @returns {*}
     */
    var syncLogin = function () {
        var defer = $.Deferred();
        $.getJSON(
            config.sso.host + '/sso/sign-links?t=' + (new Date().getTime()) + '&callback=?'
        )
            .done(function (res) {
                if (res.status > 0) {
                    showMessage(res.msg);
                    return false;
                }
                if (typeof res.data !== 'object') {
                    return defer.reject('同步登录返回数据错误！');
                }
                var domain = document.domain;
                $.each(res.data, function (index, item) {
                    var match = item.match(/(http:|https:|ftp:|^)\/\/([\w\._-]+)/i),
                        isCurrent = false;
                    if (null !== match && match.length >= 3) {
                        isCurrent = domain == match[2];
                    }
                    $.getJSON(item + '&t=' + (new Date().getTime()) + '&callback=?').done(function (res) {
                        if (isCurrent) {
                            return defer.resolve('本站同步登录成功。');
                        }
                    }).fail(function (res) {
                        if (isCurrent) {
                            return defer.reject('本站同步登录失败。');
                        }
                    });
                    return true;
                })
            })
            .fail(function (res) {
                return defer.reject('读取同步登陆链接失败。');
            });
        return defer.promise();

    };
    var syncLogout = function () {
        var defer = $.Deferred();
        $.getJSON(
            config.sso.host + '/sso/exit-links?t=' + (new Date().getTime()) + '&callback=?'
        )
            .done(function (res) {
                if (res.status > 0) {
                    return defer.reject(res.data);
                }
                if (typeof res.data !== 'object') {
                    return defer.reject('同步退出返回数据错误！');
                }
                var count = 0, len = res.data.length;
                $.each(res.data, function (index, item) {
                    $.getJSON(item + '&t=' + (new Date().getTime()) + '&callback=?').done(function (res) {
                        count++;
                        if (count>=len) {
                            return defer.resolve('同步退出完毕。');
                        }
                    }).fail(function (res) {
                        count++;
                        if (count>=len) {
                            return defer.resolve('同步退出完毕。');
                        }
                    });
                    return true;
                })
            })
            .fail(function (res) {
                return defer.reject('读取同步退出链接失败。');
            });
        return defer.promise();

    };


    function getData(form) {
        var res = {};
        var items = form.serializeArray();
        $.each(items, function (index, item) {
            res[item.name] = item.value || '';
        });
        return res;
    }


    /**
     * 显示错误提示
     * @param message
     */
    var showMessage = function (message) {
        var $body = $('body');
        $body.find('#sso-error').text(message);
        $body.find('#sso-message').show();
    };

    return {
        initUser: initUser,
        exit: exit,
        getUser: getUser,
        modal: modal,
        initSsoForm: initSsoForm,
        syncLogin: syncLogin,
        setSsoCallback: function (fn) {
            ssoCallback = fn;
        },
    }

}(jQuery);
