<div id="user-login" class="hidden fixed z-40 inset-0 overflow-y-auto flex items-center justify-center">
    <div class="fixed inset-0 bg-black/20 backdrop-blur-sm dark:bg-slate-900/80"
         id="user-login-layer"></div>
    <div class="relative bg-white w-60 p-6 w-96 z-10 rounded-xl shadow-xl ring-1 ring-slate-900/5 dark:bg-slate-800 dark:highlight-white/10">
        <form id="user-login-form" class="flex flex-wrap text-base">
            <div id="user-login-head" class="w-full flex-none flex items-center justify-center py-1 ">
                <div class="w-24 h-24">
                    <img  id="head-upload" class="w-24 h-24 rounded-full bg-white mr-1 border dark:border-sky-500 border-solid" src="{{$global_user['avatar'] ?: '/app/pt_blog/image/default.png'}}" alt="">
                    <input id="head-upload-input"  class="hidden" name="file" type="file" value=""/>
                </div>
            </div>
            <div id="user-login-nick_name" class="w-full flex-none flex items-center py-1 border-b border-slate-200 dark:border-slate-200/5">
                <input class="outline-none flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700 rounded-md p-2"
                       placeholder="昵称"  type="text"
                       name="nickname"
                       value="{{$global_user['nickname']}}"/>
            </div>
            <div id="user-login-username" class="w-full flex-none flex items-center py-1 border-b border-slate-200 dark:border-slate-200/5">
                <input class="outline-none flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700 rounded-md p-2"
                       name="username" placeholder="用户名" type="text"
                       value="" />
            </div>
            <div id="user-login-email" class="w-full flex-none flex items-center py-1 border-b border-slate-200  dark:border-slate-200/5">
                <input class="outline-none flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700 rounded-md p-2"
                       name="email" placeholder="邮箱" type="email"
                       value=""/>
            </div>
            <div id="user-login-code" class="w-full flex-none flex items-center py-1 border-b border-slate-200 dark:border-slate-200/5">
                <input class="outline-none flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700 rounded-md p-2"
                       name="code" placeholder="验证码" type="number"
                       value=""/>
                <button id="user-login-send-code" class="pl-2" type="button">获取邮箱验证码</button>
            </div>
            <div id="user-login-password" class="w-full flex-none flex items-center py-1 border-b border-slate-200 dark:border-slate-200/5">
                <input class="outline-none flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700 rounded-md p-2"
                       name="password" placeholder="密码" type="password"
                       value=""/>
            </div>
        </form>
        <div class="p-4 px-6 py-5 flex flex-col text-sm">
            <div id="user-login-btn" data-type="login" class="text-base font-medium rounded-lg bg-sky-500 text-white py-2 text-center cursor-pointer dark:highlight-white/20">
                登录
            </div>
            <div class="flex flex-row justify-between py-2">
                <button id="user-login-btn-register" data-type="register" type="button">
                    没有账号？<a class="text-sky-500">点击注册</a>
                </button>
                <button id="user-login-reset" type="button">
                    找回密码
                </button>
            </div>
        </div>
        @if($global_config['github-client_id'])
        <a id="user-github-login" class="flex items-center justify-center border-t pt-3 border-gray-100 dark:border-slate-700" href="/app/pt_blog/user/github?redirect_url={{urlencode(request()->path())}}">
            <img class="w-8 h-8 pr-1" src="/app/pt_blog/image/github.svg" alt="github">
            <span>快捷登录</span>
        </a>
        @else
        <a id="user-github-login"></a>
        @endif
    </div>
</div>