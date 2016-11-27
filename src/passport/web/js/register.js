/**
 * Created by Shen.L on 2016/11/21.
 */


var register = function ($) {
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

    var icons = {
        info: '<i class="fa fa-info-circle"></i> ',
        error: '<i class="fa fa-warning "></i> ',
        danger: '<i class="fa fa-minus-circle"></i> ',
        weak: '<i class="fa fa-warning text-danger"></i> ',
        medium: '<i class="fa fa-info-circle text-info"></i> ',
        strong: '<i class="fa fa-lock text-success"></i> '
    };
    var pwdStrength = {
        1: {
            reg: /^.*([\W_])+.*$/i,
            msg: icons.danger + '有被盗风险,建议使用大/小写字母、数字和符号两种及以上组合'
        },
        2: {
            reg: /^.*([a-z])+.*$/i,
            msg: icons.weak + '安全强度低，可以使用三种以上的组合来提高安全强度'
        },
        3: {
            reg: /^.*([A-Z])+.*$/i,
            msg: icons.medium + '安全强度适中，可以使用三种以上的组合来提高安全强度'
        },
        4: {
            reg: /^.*([0-9])+.*$/i,
            msg: icons.strong + '你的密码很安全'
        }
    };
    var weakPasswords = ["123456", "123456789", "111111", "5201314",
        "12345678", "123123", "password", "1314520", "123321",
        "7758521", "1234567", "5211314", "666666", "520520",
        "woaini", "520131", "11111111", "888888", "hotmail.com",
        "112233", "123654", "654321", "1234567890", "a123456",
        "88888888", "163.com", "000000", "yahoo.com.cn", "sohu.com",
        "yahoo.cn", "111222tianya", "163.COM", "tom.com", "139.com",
        "wangyut2", "pp.com", "yahoo.com", "147258369", "123123123",
        "147258", "987654321", "100200", "zxcvbnm", "123456a",
        "521521", "7758258", "111222", "110110", "1314521",
        "11111111", "12345678", "a321654", "111111", "123123",
        "5201314", "00000000", "q123456", "123123123", "aaaaaa",
        "a123456789", "qq123456", "11112222", "woaini1314",
        "a123123", "a111111", "123321", "a5201314", "z123456",
        "liuchang", "a000000", "1314520", "asd123", "88888888",
        "1234567890", "7758521", "1234567", "woaini520",
        "147258369", "123456789a", "woaini123", "q1q1q1q1",
        "a12345678", "qwe123", "123456q", "121212", "asdasd",
        "999999", "1111111", "123698745", "137900", "159357",
        "iloveyou", "222222", "31415926", "123456", "111111",
        "123456789", "123123", "9958123", "woaini521", "5201314",
        "18n28n24a5", "abc123", "password", "123qwe", "123456789",
        "12345678", "11111111", "dearbook", "00000000", "123123123",
        "1234567890", "88888888", "111111111", "147258369",
        "987654321", "aaaaaaaa", "1111111111", "66666666",
        "a123456789", "11223344", "1qaz2wsx", "xiazhili",
        "789456123", "password", "87654321", "qqqqqqqq",
        "000000000", "qwertyuiop", "qq123456", "iloveyou",
        "31415926", "12344321", "0000000000", "asdfghjkl",
        "1q2w3e4r", "123456abc", "0123456789", "123654789",
        "12121212", "qazwsxedc", "abcd1234", "12341234",
        "110110110", "asdasdasd", "123456", "22222222", "123321123",
        "abc123456", "a12345678", "123456123", "a1234567",
        "1234qwer", "qwertyui", "123456789a", "qq.com", "369369",
        "163.com", "ohwe1zvq", "xiekai1121", "19860210", "1984130",
        "81251310", "502058", "162534", "690929", "601445",
        "1814325", "as1230", "zz123456", "280213676", "198773",
        "4861111", "328658", "19890608", "198428", "880126",
        "6516415", "111213", "195561", "780525", "6586123",
        "caonima99", "168816", "123654987", "qq776491",
        "hahabaobao", "198541", "540707", "leqing123", "5403693",
        "123456", "123456789", "111111", "5201314", "123123",
        "12345678", "1314520", "123321", "7758521", "1234567",
        "5211314", "520520", "woaini", "520131", "666666",
        "RAND#a#8", "hotmail.com", "112233", "123654", "888888",
        "654321", "1234567890", "a123456"
    ];

    var getStringLength = function (str) {
        if (!str) {
            return;
        }
        var bytesCount = 0;
        for (var i = 0; i < str.length; i++) {
            var c = str.charAt(i);
            if (/^[\u0000-\u00ff]$/.test(c)) {
                bytesCount += 1;
            }
            else {
                bytesCount += 2;
            }
        }
        return bytesCount;
    };
    var validation = {
        validate: function ($obj, $e) {
            var name = $obj.attr('name'), required = $obj.attr('required'), $formGroup = $obj.parents('.form-group');
            if ('' == $obj.val()) {
                $formGroup.removeClass('has-error success');
                if ($e.type == 'blur') return showMessage($obj, '');
                return showMessage($obj);
            }
            if (typeof validation[name] == 'function') {
                validation[name]($obj, $e).done(function (res) {
                    if (res == 'success') {
                        $formGroup.removeClass('has-error has-warn').addClass('success');
                    } else if (res == 'warn') {
                        $formGroup.removeClass('has-error').addClass('success');
                    } else if (res == 'clear') {
                        $formGroup.removeClass('has-error success');
                        return showMessage($obj, '');
                    } else if (res == 'revert') {
                        $formGroup.removeClass('has-error success');
                        return showMessage($obj);
                    }
                }).fail(function (reason) {
                    $formGroup.removeClass('success').addClass('has-error');
                    return showMessage($obj, reason);
                });
            }
        },
        username: function ($obj, $e) {
            var defer = $.Deferred(), value = $obj.val();
            var reg = /^[A-Za-z0-9_\-\u4e00-\u9fa5]+$/;
            if (value != '' && !reg.test(value)) {
                defer.reject(icons.error + '格式错误，仅支持汉字、字母、数字、“-”“_”的组合');
            } else if ($e.type == 'blur' || $e.type == 'submit') {
                var len = getStringLength(value);
                if (len < 4 || len > 20) defer.reject(icons.error + '用户名长度必须介于4到20字符之间');
                else {
                    var $formGroup = $obj.parents('.form-group');
                    if ($formGroup.data('success') == value) defer.resolve('success');
                    else if ($formGroup.data('value') != value) {
                        $formGroup.addClass('busy').data('value', value);
                        $.post('/validator/username', {username: value})
                            .done(function (res) {
                                if ($formGroup.data('value') != value) {
                                    return defer.resolve();
                                }
                                $formGroup.removeClass('busy').data('value', '');
                                if (res.status === 0) {
                                    $formGroup.data('success', value);
                                    defer.resolve('success');
                                } else {
                                    defer.reject(icons.error + res.data);
                                }
                            })
                            .fail(function (reason) {
                                if ($formGroup.data('value') != value) {
                                    return defer.resolve();
                                }
                                $formGroup.removeClass('busy').data('value', '');
                                defer.reject(icons.error + reason.responseText);
                            });
                    }
                    showMessage($obj, '');
                }
            } else defer.resolve('revert');
            return defer.promise();
        },
        password: function ($obj, $e) {
            var defer = $.Deferred(), value = $obj.val(), len = getStringLength(value),
                $password2 = $('#password2'), value2 = $password2.val(), len2 = getStringLength(value2);
            if (len2 > 0) {
                var $password2FormGroup = $password2.parents('.form-group');
                if (value2 != value) {
                    $password2FormGroup.removeClass('success').addClass('has-error');
                    showMessage($password2, icons.error + '两次输入密码不一致');
                } else {
                    $password2FormGroup.removeClass('has-error').addClass('success');
                    showMessage($password2, '');
                }
            }
            if (len < 6 || len > 20) {
                if ($e.type == 'blur') defer.reject(icons.error + '密码长度必须介于6到20字符之间');
            } else {
                var typeCount = 0, level;
                for (var key in pwdStrength) {
                    if (pwdStrength[key].reg.test(value)) {
                        typeCount++;
                    }
                }
                level = len > 8 ? typeCount + 1 : typeCount;
                if ($.inArray(value, weakPasswords) !== -1) {
                    level = 0;
                }
                if (level > 1) {
                    showMessage($obj, pwdStrength[level].msg);
                    defer.resolve('success');
                } else {
                    defer.reject(pwdStrength[1].msg);
                }
            }
            defer.resolve('revert');
            return defer.promise();
        },
        password2: function ($obj, $e) {
            var defer = $.Deferred(), value = $obj.val(), len = getStringLength(value), $password = $('#password');
            if (len < 6 || len > 20) {
                if ($e.type == 'blur') defer.reject(icons.error + '密码长度必须介于6到20字符之间');
            } else {
                if (value != $password.val()) defer.reject(icons.error + '两次输入密码不一致');
                else {
                    showMessage($obj, '');
                    defer.resolve('success');
                }
            }
            defer.resolve('revert');
            return defer.promise();
        },
        phone: function ($obj, $e) {
            var defer = $.Deferred(), value = $obj.val();
            var reg = /^1[345678]\d{9}$/;
            if (value != '' && !reg.test(value)) {
                defer.reject(icons.error + '格式错误，仅支持中国大陆手机号码');
            } else if ($e.type == 'blur') {
                var $formGroup = $obj.parents('.form-group');
                if ($formGroup.data('success') == value) {
                    if ($formGroup.hasClass('has-warn')) {
                        showMessage($obj, icons.error + '手机号已注册，继续注册将与原账号解绑');
                        defer.resolve('warn');
                    } else {
                        defer.resolve('success');
                    }
                }
                else if ($formGroup.data('value') != value) {
                    $formGroup.addClass('busy').data('value', value);
                    $.post('/validator/phone', {phone: value})
                        .done(function (res) {
                            if ($formGroup.data('value') != value) {
                                return defer.resolve();
                            }
                            $formGroup.removeClass('busy').data('value', '');
                            if (res.status === 0) {
                                $formGroup.data('success', value);
                                defer.resolve('success');
                            } else if (res.status === 2) {
                                $formGroup.addClass('has-warn').data('success', value);
                                showMessage($obj, icons.error + res.data);
                                defer.resolve('warn');
                            } else {
                                defer.reject(icons.error + res.data);
                            }
                        })
                        .fail(function (reason) {
                            if ($formGroup.data('value') != value) {
                                return defer.resolve();
                            }
                            $formGroup.removeClass('busy').data('value', '');
                            defer.reject(icons.error + reason.responseText);
                        });
                    showMessage($obj, '');
                }
                //
            } else defer.resolve('revert');
            return defer.promise();
        },
        captcha: function ($obj, $e) {
            var defer = $.Deferred(), value = $obj.val(), len = getStringLength(value);
            if ($e.type == 'blur')
                showMessage($obj, '');
            defer.resolve('success');
            return defer.promise();
        },
        agree: function ($obj, $e) {
            var defer = $.Deferred(), checked = $obj.prop('checked');
            if (checked) {
                showMessage($obj, '');
                defer.resolve('success');
            } else
                defer.reject('您必须同意《注册协议》才能注册！');
            return defer.promise();
        },
        verification_code: function ($obj, $e) {
            var defer = $.Deferred();
            showMessage($obj, '');
            defer.resolve('success');
            return defer.promise();
        },
    };
    var verificationCodeEvent = function (e) {
        var defer = $.Deferred(), $this = $(this), $phone = $('#phone'), $captcha = $('#captcha'),
            $formGroup = $this.parents('.form-group'),
            $phoneGroup = $phone.parents('.form-group'),
            $captchaGroup = $captcha.parents('.form-group'),
            now = new Date().getTime(), lastSendVerificationCode = store.get('lastSendVerificationCode'),
            phone = $phone.val(), captcha = $captcha.val();
        if (!$phoneGroup.hasClass('success')) {
            $phone.focus();
            $phoneGroup.addClass('has-error');
            return showMessage($phone, '请输入正确的手机号码');
        }
        if ('' == captcha) {
            $captcha.focus();
            $captchaGroup.addClass('has-error');
            return showMessage($captcha, '请输入验证码');
        }
        if (lastSendVerificationCode && now - lastSendVerificationCode < 120 * 1000) {
            tick.start();
            $formGroup.addClass('has-error');
            return showMessage($this, '您已经获取过验证码，请稍后再次获取');
        }
        // 发送获取请求
        $.post('/validator/code', {captcha: captcha,phone:phone})
            .done(function (res) {
                if(res.status==1){
                    $captcha.focus();
                    $captchaGroup.addClass('has-error');
                    return showMessage($captcha, '验证码不正确');
                }else if(res.status ==2){
                    $phone.focus();
                    $phoneGroup.addClass('has-error');
                    return showMessage($captcha, '手机号码不正确，仅支持中国大陆手机号码');
                }
                store.set('lastSendVerificationCode', new Date().getTime());
                tick.start();
                $formGroup.removeClass('has-error');
                showMessage($this, res.data);
            })
            .fail(function (reason) {
                tick.start();
                $formGroup.addClass('has-error');
                showMessage($this, reason.responseText);
            });
        return defer.promise();
    };
    var tick = function () {
        var handler = null;
        var start = function () {
                if (handler != null) return true;
                handler = setInterval(tick.count, 1000);
            },
            count = function () {
                var lastSendVerificationCode = store.get('lastSendVerificationCode');
                var now = new Date().getTime();
                if (now - lastSendVerificationCode > 120 * 1000) {
                    tick.cancel();
                } else {
                    var text = Math.floor(120 - (now - lastSendVerificationCode) / 1000) + '秒后重新获取';
                    $('#get-verification-code').text(text);
                }
            },
            cancel = function () {
                window.clearInterval(handler);
                handler = null;
                $('#get-verification-code').text('获取手机验证码');

            };
        return {
            start: start,
            count: count,
            cancel: cancel
        }
    }();
    var formBusy = false;
    var submit = function (e) {
        var $this = $(this), $agree = $('#agree'), error = false, registerButton = $('#register-button');
        if (formBusy)return false;
        $this.find('input[required]').each(function (index, item) {
            var $item = $(item);
            if (!$item.parents('.form-group').hasClass('success')) {
                $item.focus();
                validation.validate($item, e);
                error = true;
                return false;
            }
        });
        if (error) return false;
        if (!$agree.prop('checked')) {
            $agree.focus();
            validation.validate($agree, e);
            return false;
        }
        var data = getData($this),
            registerError = function (error) {
                if (typeof error == 'object') {
                    for (var i in error) {
                        if (error.hasOwnProperty(i)) {
                            console.log(i,'yes');
                            var name = validation.hasOwnProperty(i) ? i : 'agree';
                            var $item = $('#' + name), message = typeof error[i] == 'string' ? error[i] : error[i].pop();
                            $item.parents('.form-group').addClass('has-error');
                            showMessage($item, message);
                        }
                    }
                } else {
                    $agree.parents('.form-group').addClass('has-error');
                    showMessage($agree, error);
                }
                formBusy = false;
                return registerButton.html('立即注册').attr('type', 'submit').removeClass('disabled');
            };
        formBusy = true;
        registerButton.text('正在注册...').attr('type', 'button').addClass('disabled');
        $.getJSON('/sso/salt?t=' + (new Date().getTime()) + '&callback=?')
            .done(function (res) {
                if (res.status != 0)  return registerError('请求失败');
                var salt = res.data;
                $.post('/passport/register', {
                    _csrf: data._csrf,
                    username: data.username,
                    password: security.encrypt(data.password, salt),
                    phone: data.phone,
                    verification_code: data.verification_code
                })
                    .done(function (res) {
                        if (res.status != 0)return registerError(res.data);
                        // TODO 注册成功跳转
                        alert('注册成功');
                    })
                    .fail(function (reason) {
                        return registerError(reason.responseText);
                    });
            })
            .fail(function (reason) {
                return registerError(reason.responseText);
            });

        return false;
    };

    var showMessage = function ($obj, message) {
        var $helpBlock = $obj.parents('.form-group').find('.help-block');
        var hint = $obj.data('hint');
        message = undefined !== message ? message : (undefined === hint ? '' : hint);
        $helpBlock.html(message);
    };

    var initEvent = function () {
        $('#register-form').submit(submit).find('input')
            .blur(function (e) {
                validation.validate($(this), e)
            })
            .focus(function (e) {
                validation.validate($(this), e)
            })
            .on('input', function (e) {
                validation.validate($(this), e)
            });
        $('#get-verification-code').click(verificationCodeEvent);
    };


    return {
        init: function () {
            // 初始化各个input框验证
            initEvent();
            // 初始化各个自定义事件
            // 初始化提交

        }

    };

    function getData(form) {
        var res = {};
        var items = form.serializeArray();
        $.each(items, function (index, item) {
            res[item.name] = item.value || '';
        });
        return res;
    }


}(jQuery);