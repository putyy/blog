function createBgCanvas() {
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    var stars = [], /* Array to hold our stars */ FPS = 60, /* Frames per second */ x = 100, /* Number of stars */
        mouse = {x: 0, y: 0,};/* Push stars to array */
    for (var i = 0; i < x; i++) stars.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: Math.random() * 1 + 1,
        vx: Math.floor(Math.random() * 50) - 25,
        vy: Math.floor(Math.random() * 50) - 25
    });
    ;/* Draw the scene */
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.globalCompositeOperation = "lighter";
        for (var i = 0, x = stars.length; i < x; i++) {
            var s = stars[i];
            ctx.fillStyle = "#38c6f6";
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.radius, 0, 2 * Math.PI);
            ctx.fill();
            ctx.fillStyle = 'black';
            ctx.stroke();
        }
        ;ctx.beginPath();
        for (var i = 0, x = stars.length; i < x; i++) {
            var starI = stars[i];
            ctx.moveTo(starI.x, starI.y);
            if (distance(mouse, starI) < 150) ctx.lineTo(mouse.x, mouse.y);
            for (var j = 0, x = stars.length; j < x; j++) {
                var starII = stars[j];
                if (distance(starI, starII) < 150) {/* ctx.globalAlpha = (1 / 150 * distance(starI, starII).toFixed(1)); */
                    ctx.lineTo(starII.x, starII.y);
                }
                ;
            }
            ;
        }
        ;ctx.lineWidth = 0.05;
        ctx.strokeStyle = '#1cbef5';
        ctx.stroke();
    };

    function distance(point1, point2) {
        var xs = 0;
        var ys = 0;
        xs = point2.x - point1.x;
        xs = xs * xs;
        ys = point2.y - point1.y;
        ys = ys * ys;
        return Math.sqrt(xs + ys);
    };/* Update star locations */
    function update() {
        for (var i = 0, x = stars.length; i < x; i++) {
            var s = stars[i];
            s.x += s.vx / FPS;
            s.y += s.vy / FPS;
            if (s.x < 0 || s.x > canvas.width) s.vx = -s.vx;
            if (s.y < 0 || s.y > canvas.height) s.vy = -s.vy;
        }
        ;
    };canvas.addEventListener('mousemove', function (e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });/* Update and draw */
    function tick() {
        draw();
        update();
        requestAnimationFrame(tick);
    };tick();
}

var $ = function (selector) {
    var elements;
    if (selector.indexOf('body') !== -1) {
        elements = [document.body];
    } else if (selector.indexOf('.') !== -1) {
        elements = document.querySelectorAll(selector);
    } else if (selector.indexOf('#') !== -1) {
        elements = [document.getElementById(selector.substring(1))];
    } else {
        elements = Array.from(document.getElementsByTagName(selector));
    }
    return {
        ...elements,
        // 添加类
        addClass: function (className) {
            elements.forEach(function (element) {
                element.classList.add(className);
            });
            return this;
        },
        // 移除类
        removeClass: function (className) {
            elements.forEach(function (element) {
                element.classList.remove(className);
            });
            return this;
        },
        // 事件监听
        on: function (event, callback) {
            elements.forEach(function (element) {
                element.addEventListener(event, function () {
                    callback.call(this, arguments); // 使用 call 方法将当前元素和事件参数传递给回调函数
                });
            });
            return this;
        }
    };
};

$.get = function (url, callback, isJson) {
    isJson = isJson === undefined ? true : isJson
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    isJson && xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            callback(JSON.parse(xhr.responseText));
        }
    };
    xhr.send();
};

$.post = function (url, data, callback, isJson) {
    isJson = isJson === undefined ? true : isJson
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    if (isJson){
        xhr.setRequestHeader("Content-Type", "application/json");
        data = JSON.stringify(data)
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            callback(JSON.parse(xhr.responseText));
        }
    };
    xhr.send(data);
};

function search() {
    var keyword = $("#search-val")[0].value
    var param = {}
    if (location.search) {
        var urlParams = new URLSearchParams(window.location.search);
        urlParams.forEach(function (v, k) {
            param[k] = v
        })
    }
    param['keyword'] = keyword ? encodeURI(keyword) : ''

    if (location.pathname.includes('/categories/')) {
        window.location.href = location.origin + location.pathname + "?" + Object.entries(param)
            .map(([key, value]) => key + '=' + value)
            .join('&')
        return
    }
    window.location.href = "/?" + Object.entries(param)
        .map(([key, value]) => key + '=' + value)
        .join('&')
}

function showLogin(type) {
    $("#user-login").removeClass('hidden')
    switch (type) {
        case 'login':
            $("#user-login-username").removeClass('hidden');
            $("#user-login-head").addClass('hidden');
            $("#user-login-password").removeClass('hidden');
            $("#user-login-nick_name").addClass('hidden');
            $("#user-login-email").addClass('hidden');
            $("#user-login-code").addClass('hidden');
            $("#user-login-btn")[0].innerHTML = '登录';
            $("#user-login-btn")[0].setAttribute('data-type', 'login')
            $("#user-login-btn-register")[0].innerHTML = '没有账号？<a class="text-sky-500">点击注册</a>';
            $("#user-login-btn-register")[0].setAttribute('data-type', 'register')
            $("#user-login-reset").removeClass('hidden');
            $("#user-github-login").removeClass('hidden');
            break;
        case 'register':
            $("#user-login-password").removeClass('hidden');
            $("#user-login-username").removeClass('hidden');
            $("#user-login-head").removeClass('hidden');
            $("#user-login-nick_name").removeClass('hidden');
            $("#user-login-email").removeClass('hidden');
            $("#user-login-code").removeClass('hidden');
            $("#user-login-btn")[0].innerHTML = '注册';
            $("#user-login-btn")[0].setAttribute('data-type', 'register')
            $("#user-login-btn-register")[0].innerHTML = '已有账号？<a class="text-sky-500">点击登录</a>';
            $("#user-login-btn-register")[0].setAttribute('data-type', 'login')
            $("#user-login-reset").removeClass('hidden');
            $("#user-github-login").removeClass('hidden');
            break;
        case 'reset':
            $("#user-login-password").removeClass('hidden');
            $("#user-login-username").addClass('hidden');
            $("#user-login-head").addClass('hidden');
            $("#user-login-nick_name").addClass('hidden');
            $("#user-login-email").removeClass('hidden');
            $("#user-login-code").removeClass('hidden');
            $("#user-login-btn")[0].innerHTML = '提交';
            $("#user-login-btn")[0].setAttribute('data-type', 'reset')
            $("#user-login-btn-register")[0].innerHTML = '已有账号？<a class="text-sky-500">点击登录</a>';
            $("#user-login-btn-register")[0].setAttribute('data-type', 'login')
            $("#user-login-reset").addClass('hidden')
            $("#user-github-login").addClass('hidden');
            break;
        case 'update':
            $("#user-login-btn-register").addClass('hidden');
            $("#user-login-reset").addClass('hidden');
            $("#user-login-username").addClass('hidden');
            $("#user-login-email").addClass('hidden');
            $("#user-login-code").addClass('hidden');
            $("#user-login-password").removeClass('hidden');
            $("#user-login-head").removeClass('hidden');
            $("#user-login-nick_name").removeClass('hidden');
            $("#user-login-btn")[0].innerHTML = '提交';
            $("#user-login-btn")[0].setAttribute('data-type', 'update')
            $("#user-github-login").addClass('hidden');
            break;
    }
}

(function () {
    createBgCanvas()
    document.addEventListener("DOMContentLoaded", function (event) {
        $("#left-dialog-close2").on('click', function (event) {
            $("#left-dialog").addClass('hidden')
        })

        $("#left-dialog-close1").on('click', function (event) {
            $("#left-dialog").addClass('hidden')
        })

        $("#left-dialog-show").on('click', function (event) {
            $("#left-dialog").removeClass('hidden')
        })

        $("#change-theme").on('click', function (event) {
            if (tailwind.config.darkMode === 'class') {
                localStorage.theme = ""
                tailwind.config.darkMode = ""
            } else {
                localStorage.theme = "class"
                tailwind.config.darkMode = "class"
            }
        })

        $("#search").on('click', function (event) {
            search()
        })


        $("#search-val").on('keydown', function (event) {
            if (event[0].code === 'Enter') {
                search()
            }
        })

        $("#user-btn").on('click', function (event) {
            if ($("#user-info")[0].classList.contains('hidden')) {
                if (window.global_user.uid > 0) {
                    $("#user-info").removeClass('hidden')
                } else {
                    showLogin('login')
                }
            } else {
                $("#user-info").addClass('hidden')
            }
            event[0].stopPropagation()
        })


        $("#user-login-btn-register").on('click', function (event) {
            showLogin($("#user-login-btn-register")[0].getAttribute('data-type'))
        })

        $("#user-login-reset").on('click', function (event) {
            showLogin('reset')
        })

        $("#user-login-layer").on('click', function (event) {
            $("#user-login").addClass('hidden')
            event[0].stopPropagation()
        })

        $("#head-upload").on('click', function (event) {
            $("#head-upload-input")[0].dispatchEvent(new MouseEvent("click"))
        })

        $("#user-login-out").on('click', function (event) {
            $.post('/app/pt_blog/user/loginOut', {}, function (res) {
                if (res.code === 200) {
                    message.info("退出成功");
                    location.reload();
                }
            })
        });

        $("#user-info-update").on('click', function (event) {
            showLogin("update")
        });

        $("#head-upload-input").on('change', function (event) {
            var url = URL.createObjectURL(this.files[0]);
            $("#head-upload")[0].setAttribute('src', url)
        });

        var sendTime = 0
        var sendTimeInterval = null
        $("#user-login-send-code").on('click', function (event) {
            if (sendTime > 0) {
                return;
            }
            var from = $('#user-login-form')[0];
            var formData = new FormData(from);
            for ([name, value] of formData.entries()) {
                if (name === 'email' && !value) {
                    message.error("邮箱不能为空");
                    return;
                }
            }

            $.post('/app/pt_blog/user/sendEmail', formData, function (res) {
                if (res.code === 500) {
                    message.error(res.msg);
                    return;
                }
                sendTime = 60
                $("#user-login-send-code")[0].innerHTML = '60s后重新获取';
                sendTimeInterval = setInterval(() => {
                    if (sendTime <= 1) {
                        sendTime = 0
                        clearInterval(sendTimeInterval)
                        sendTimeInterval = null
                        $("#user-login-send-code")[0].innerHTML = '重新获取';
                    } else {
                        sendTime = sendTime - 1
                        $("#user-login-send-code")[0].innerHTML = sendTime + 's后重新获取';
                    }
                }, 1000)
            }, false)
        })

        $("#user-login-btn").on('click', function (event) {
            var from = $('#user-login-form')[0];
            var formData = new FormData(from);

            switch (this.getAttribute('data-type')) {
                case 'login':
                    for ([name, value] of formData.entries()) {
                        if (name === 'username' && !/^[a-zA-Z0-9]{5,10}$/.test(value)) {
                            message.error("用户名只能包含字母数字且控制在5-10位");
                            return;
                        }
                        if (name === 'password' && !/^[a-zA-Z0-9]{5,10}$/.test(value)) {
                            message.error("密码只能包含字母数字且控制在5-10位");
                            return;
                        }
                    }
                    $.post('/app/pt_blog/user/login', formData, function (res) {
                        if (res.code === 500) {
                            message.error(res.msg);
                            return;
                        }
                        message.info("登录成功");
                        location.reload();
                    }, false)
                    break;
                case 'reset':
                    for ([name, value] of formData.entries()) { // 遍历数据
                        if (name === 'email' && !value) {
                            message.error("邮箱不能为空");
                            return;
                        }
                        if (name === 'password' && !/^[a-zA-Z0-9]{5,10}$/.test(value)) {
                            message.error("密码只能包含字母数字且控制在5-10位");
                            return;
                        }
                        if (name === 'code' && !/^[0-9]{5}$/.test(value)) {
                            message.error("请输入5位验证码");
                            return;
                        }
                    }
                    $.post('/app/pt_blog/user/reset', formData, function (res) {
                        if (res.code === 500) {
                            message.error(res.msg);
                            return;
                        }
                        message.info("重置成功");
                        sendTime = 0
                        clearInterval(sendTimeInterval)
                        sendTimeInterval = null
                        $("#user-login-send-code")[0].innerHTML = '获取邮箱验证码';
                        showLogin('login')
                    }, false)
                    break;
                case 'register':
                    for ([name, value] of formData.entries()) { // 遍历数据
                        if (name === 'nickname' && !value) {
                            message.error("昵称不能为空");
                            return;
                        }
                        if (name === 'username' && !value) {
                            message.error("用户名不能为空");
                            return;
                        }
                        if (name === 'email' && !value) {
                            message.error("邮箱不能为空");
                            return;
                        }
                        if (name === 'password' && !/^[a-zA-Z0-9]{5,10}$/.test(value)) {
                            message.error("密码只能包含字母数字且控制在5-10位");
                            return;
                        }
                        if (name === 'code' && !/^[0-9]{5}$/.test(value)) {
                            message.error("请输入5位验证码");
                            return;
                        }
                    }
                    $.post('/app/pt_blog/user/register', formData, function (res) {
                        if (res.code === 500) {
                            message.error(res.msg);
                            return;
                        }
                        message.info("注册成功");
                        showLogin('login')
                    }, false);
                    break;
                case 'update':
                    for ([name, value] of formData.entries()) { // 遍历数据
                        if (name === 'nickname' && !value) {
                            message.error("昵称不能为空");
                            return;
                        }

                        if (name === 'password' && value && !/^[a-zA-Z0-9]{5,10}$/.test(value)) {
                            message.error("密码只能包含字母数字且控制在5-10位");
                            return;
                        }
                    }
                    $.post('/app/pt_blog/user/update', formData, function (res) {
                        if (res.code === 500) {
                            message.error(res.msg);
                            return;
                        }
                        message.info("更新成功");
                        location.reload();
                    }, false);
                    break;
            }
        })

        var commentTextareaObj = $("#comment-textarea")[0];
        if (commentTextareaObj){
            var commentDescObj = $("#pt-comment-desc");
            var commentTotal = parseInt(commentDescObj[0].getAttribute("data-total"))
            $(".comment-reply").on('click', function (event){
                commentTextareaObj.setAttribute("data-pid", this.getAttribute("data-id"))
                commentTextareaObj.setAttribute("data-nickname", this.getAttribute("data-nickname"))
                commentTextareaObj.setAttribute("placeholder", "回复: " + this.getAttribute("data-nickname"))
                commentTextareaObj.focus()
            })

            $("#comment-send").on('click', function (event){
                if (!window.global_user.uid){
                    message.error("请先登录");
                    return;
                }
                var data = {
                    article_id: commentTextareaObj.getAttribute("data-id"),
                    pid: commentTextareaObj.getAttribute("data-pid"),
                    content: commentTextareaObj.value,
                };

                if (!data.content){
                    message.error("内容不能为空");
                    return;
                }

                $.post('/app/pt_blog/index/comment', data, function (res) {
                    if (res.code === 500) {
                        message.error(res.msg);
                        return;
                    }
                    var html = '<div class="comment">\n' +
                        '                        <div class="flex">\n' +
                        '                            <img src="'+(window.global_user.avatar ? window.global_user.avatar : '/app/pt_blog/image/default.png')+'"\n' +
                        '                                 alt="' +window.global_user.nickname+ '" class="w-10 h-10 mr-2 rounded-md"/>\n' +
                        '                            <div>\n' +
                        '                                <label class="text-cyan-500">'+window.global_user.nickname+'</label>\n' +
                        '                                <p class="text-gray-600 text-sm">刚刚</p>\n' +
                        '                            </div>\n' +
                        '                        </div>\n' +
                        '                        <p class="text-slate-700 dark:text-slate-400 pb-4 pt-2 pl-12 text-md">\n' +
                        (data.pid > 0 ? '<label class="text-teal-700 text-xs">@'+commentTextareaObj.getAttribute("data-nickname")+'</label>' : '') +
                        '                           ' +data.content+
                        '                        </p>\n' +
                        '                    </div>';

                    var parser = new DOMParser();
                    var parsedHtml = parser.parseFromString(html, "text/html");
                    var frag = document.createDocumentFragment();
                    while (parsedHtml.body.firstChild) {
                        frag.appendChild(parsedHtml.body.firstChild);
                    }
                    document.getElementById("comments").appendChild(frag)
                    commentTextareaObj.value = ""
                    commentTextareaObj.setAttribute("data-pid", 0)
                    commentTextareaObj.setAttribute("data-nickname", "")
                    commentTextareaObj.setAttribute("placeholder", "请输入你的评论")
                    commentTotal += 1
                    commentDescObj[0].innerHTML = commentTotal + '条回复 · ' + res.data.created_at
                    commentDescObj.removeClass('hidden')
                })
            })

            $("#comment-cancel").on('click', function (event){
                commentTextareaObj.setAttribute("data-pid", 0)
                commentTextareaObj.setAttribute("data-nickname", "")
                commentTextareaObj.setAttribute("placeholder", "请输入你的评论")
            })
        }

        $("body").on('click', function (event) {
            if (!$("#user-info")[0].classList.contains('hidden')) {
                $("#user-info")[0].classList.add('hidden')
            }
        });

    });
})()


