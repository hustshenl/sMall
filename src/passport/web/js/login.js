/**
 * Created by Shen.L on 2016/11/10.
 */

var $document, $window, $body;
var login = function ($) {
    var pub = {
        init: function () {
            console.log('login init');
            intForm();
        },

    };

    function intForm() {
        var busy = false;
        var loginButton = $('#login-button');
        $("#login-form").submit(function (e) {
            if(busy)return false;
            busy = true;
            loginButton.text('正在登陆').attr('type','button').addClass('disabled');
            var $form = $(this);
            var data = getData($form);
            // 判断数据情况
            if ('' == data.username || '' == data.password) {
                showMessage('请填写账户名或者密码');
                busy = false;
                loginButton.html('登 &nbsp; 陆').attr('type','submit').removeClass('disabled');
                return false;
            }
            $.getJSON('/sso/salt?t=' + (new Date().getTime()) + '&callback=?')
                .done(function (res) {
                    if (res.status != 0) {
                        showMessage('请求失败');
                        busy = false;
                        loginButton.html('登 &nbsp; 陆').attr('type','submit').removeClass('disabled');
                        return false;
                    }
                    var salt = res.data;
                    console.log(salt);
                    // TODO 对password进行加密
                    data.password = security.encrypt(data.password, salt);
                    //data.password = security.encrypt(data.password);
                    //window.
                    // 提交表单
                    $.post(
                        '/login',
                        data,
                        function (res) {
                            // TODO 根据返回信息进行处理
                            console.log(res);
                            if (res.status > 0) {
                                showMessage(res.msg);
                                busy = false;
                                loginButton.html('登 &nbsp; 陆').attr('type','submit').removeClass('disabled');
                                return false;
                            }
                            if (res.redirect) window.location.href = res.redirect;
                            window.location.href = '/';
                        }
                    );
                })
                .fail(function (res) {
                    showMessage('请求失败');
                    busy = false;
                    loginButton.html('登 &nbsp; 陆').attr('type','submit').removeClass('disabled');
                    return false;
                });
            return false;
        });
    }

    function showMessage(message) {
        // TODO 展示错误信息
        $('#login-error').text(message);
        $('#login-message').fadeIn();
        console.log(message);
    }

    function getData(form) {
        var res = {};
        var items = form.serializeArray();
        $.each(items, function (index, item) {
            res[item.name] = item.value || '';
        });
        return res;
    }

    return pub;

}(jQuery);