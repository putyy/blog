<div id="user-login" class="hidden fixed inset-0 z-40 overflow-y-auto flex items-center justify-center">
    <div id="user-login-layer" class="fixed inset-0 bg-black/30 backdrop-blur-sm dark:bg-slate-900/80"></div>
    <div class="relative mx-4 z-10 w-full max-w-md bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-xl ring-1 ring-slate-200/50 dark:ring-slate-700/50 transition-all duration-300">
        <form id="user-login-form" class="flex flex-col gap-4 text-base">
            <div id="user-login-head" class="flex justify-center mb-4">
                <div class="w-28 h-28 relative group">
                    <img id="head-upload" class="w-full h-full rounded-full border-2 border-gray-200 dark:border-sky-600 object-cover transition-transform duration-300 group-hover:scale-105" src="{{$global_user['avatar'] ?: '/app/pt_blog/image/default.png'}}" alt="">
                    <input id="head-upload-input" class="hidden" name="file" type="file" value=""/>
                </div>
            </div>
            <div id="user-login-nick_name" class="relative">
                <input class="w-full bg-gray-50 dark:bg-slate-800/50 text-sm p-4 rounded-xl border border-gray-200 dark:border-slate-600 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500" placeholder="昵称" type="text" name="nickname" value="{{$global_user['nickname']}}"/>
            </div>
            <div id="user-login-username" class="relative">
                <input class="w-full bg-gray-50 dark:bg-slate-800/50 text-sm p-4 rounded-xl border border-gray-200 dark:border-slate-600 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500" name="username" placeholder="用户名" type="text" value="" />
            </div>
            <div id="user-login-email" class="relative">
                <input class="w-full bg-gray-50 dark:bg-slate-800/50 text-sm p-4 rounded-xl border border-gray-200 dark:border-slate-600 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500" name="email" placeholder="邮箱" type="email" value=""/>
            </div>
            <div id="user-login-code" class="flex items-center gap-3">
                <input class="flex-grow bg-gray-50 dark:bg-slate-800/50 text-sm p-4 rounded-xl border border-gray-200 dark:border-slate-600 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500" name="code" placeholder="验证码" type="number" value=""/>
                <button id="user-login-send-code" class="text-sky-500 hover:text-sky-600 dark:hover:text-sky-400 font-medium text-sm px-4 py-2 rounded-lg transition-colors duration-200" type="button">获取邮箱验证码</button>
            </div>
            <div id="user-login-password" class="relative">
                <input class="w-full bg-gray-50 dark:bg-slate-800/50 text-sm p-4 rounded-xl border border-gray-200 dark:border-slate-600 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500" name="password" placeholder="密码" type="password" value=""/>
            </div>
        </form>

        <div class="px-0 py-6 flex flex-col text-sm gap-4">
            <div id="user-login-btn" data-type="login" class="text-base font-semibold rounded-xl bg-sky-500 hover:bg-sky-600 dark:hover:bg-sky-700 text-white py-3 text-center cursor-pointer transition-colors duration-200 shadow-md hover:shadow-lg">
                登录
            </div>
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                <button id="user-login-btn-register" data-type="register" type="button" class="text-sky-500 hover:text-sky-600 dark:hover:text-sky-400 hover:underline transition-colors duration-200">
                    没有账号？点击注册
                </button>
                <button id="user-login-reset" type="button" class="text-gray-600 dark:text-gray-400 hover:text-sky-500 dark:hover:text-sky-400 hover:underline transition-colors duration-200">
                    找回密码
                </button>
            </div>
        </div>

        @if($global_config['github-client_id'])
            <a id="user-github-login" class="flex items-center justify-center gap-3 border-t pt-5 border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-300 hover:text-sky-500 dark:hover:text-sky-400 transition-colors duration-200" href="/app/pt_blog/user/github?redirect_url={{urlencode(request()->path())}}">
                <img class="w-6 h-6" src="/app/pt_blog/image/github.svg" alt="github">
                <span class="text-sm font-medium">快捷登录</span>
            </a>
        @else
            <a id="user-github-login"></a>
        @endif
    </div>
</div>