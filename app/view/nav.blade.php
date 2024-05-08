<nav class="mx-auto sticky top-0 z-40 lg:max-w-6xl w-full">
    <div class="flex justify-between flex-nowrap bg-white text-gray-700 flex flex-wrap items-center justify-center px-2 lg:px-10 py-4 font-2xl overflow-visible dark:bg-gray-900 dark:text-blue-200 ">
        <div class="hidden lg:block">
            <ul class="flex flex-wrap flex-row justify-start list-reset m-0 w-full">
                <li>
                    <a class="block md:inline-block pr-4 py-3 no-underline text-orange-600 hover:text-grey-darker font-bold text-xl">{{$global_config['name']}}</a>
                </li>
                <li>
                    <a href="{{route('PtBlog.index')}}" class="inline-block pr-4 py-3 no-underline text-grey-darkest hover:text-grey-darker font-semibold text-lg {{$select_nav==='home' ? 'text-indigo-600' : ''}}">Home</a>
                </li>
                @foreach ($global_cate as $cate)
                <li>
                    <a href="{{route('PtBlog.categories', ['id' => $cate['id']])}}" class="inline-block pr-4 py-3 no-underline text-grey-darkest hover:text-grey-darker font-semibold text-lg {{$select_nav==='categories_'.$cate['id'] ? 'text-indigo-600' : ''}}">{{$cate['name']}}</a>
                </li>
                @endforeach
                @foreach ($global_nav as $nav)
                <li>
                    <a href="{{$nav['url']}}" class="inline-block pr-4 py-3 no-underline text-grey-darkest hover:text-grey-darker font-semibold text-lg {{ request()->path() === $nav['url']  ? 'text-indigo-600' : ''}}" {{str_starts_with($nav['url'], 'http') ? 'target="_blank"' : ''}}>{{$nav['name']}}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="block lg:hidden relative flex items-center">
            <button type="button" class="text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300" id="left-dialog-show">
                <svg width="24" height="24"><path d="M5 6h14M5 12h14M5 18h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>
        <ul class="flex flex-wrap flex-row justify-end list-reset m-0">
            <li class="relative flex items-center">
                <div class="flex justify-between ml-auto text-slate-500 -my-1 flex items-center justify-center hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300 py-1.5 ring-1 ring-slate-900/10 rounded-md pl-2 pr-2 hover:ring-slate-300 dark:bg-slate-800 dark:highlight-white/5 dark:hover:bg-slate-700">
                    <input class="outline-none flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700 text-sm" aria-autocomplete="both" id="search-val" autocomplete="off" autocorrect="off" autocapitalize="off" enterkeyhint="go" spellcheck="false" placeholder="快速搜索..." maxlength="64" type="search" value="{{request()->get('keyword')}}"/>
                    <svg id="search" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m19 19-3.5-3.5"></path><circle cx="11" cy="11" r="6"></circle>
                    </svg>
                </div>
            </li>
            <li class="relative flex items-center">
                <div class="ml-2 -my-1 relative">
                    <button id="user-btn" type="button" class="text-slate-500 w-8 h-8 flex items-center justify-center hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300">
                        <svg width="24" height="24" fill="none" aria-hidden="true">
                            <path d="M12 6v.01M12 12v.01M12 18v.01M12 7a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <ul id="user-info" class="hidden absolute z-40 top-full right-0 bg-white rounded-lg ring-1 ring-slate-900/10 shadow-lg overflow-hidden w-36 py-1 text-sm text-slate-700 font-semibold dark:bg-slate-800 dark:ring-0 dark:highlight-white/5 dark:text-slate-300 mt-4">
                        <li class="{{$global_user['uid'] > 0 ? '' : 'hidden'}} py-1 px-2 flex items-center cursor-pointer pt-5 flex items-center cursor-pointer justify-center">
                            <img class="w-6 h-6 rounded-full bg-white mr-1" src="{{$global_user['avatar']}}" alt="{{$global_user['nickname']}}">
                            {{$global_user['nickname']}}
                        </li>
                        <li id="user-info-update" class="{{$global_user['uid'] > 0 ? '' : 'hidden'}} py-1 px-2 flex items-center cursor-pointer justify-center pt-5">修改资料
                        </li>
                        <li id="user-login-out" class="{{$global_user['uid'] > 0 ? '' : 'hidden'}}  py-1 px-2 flex items-center cursor-pointer justify-center pt-5">
                            退出登录
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="inline-block px-2 no-underline text-grey-darkest hover:text-grey-darker font-bold text-lg">
                    <div class="relative flex items-center border-slate-200 dark:border-slate-800">
                        <button type="button" id="change-theme" aria-haspopup="true" aria-expanded="true" data-headlessui-state="open">
                            <span class="dark:hidden">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" class="stroke-slate-400 dark:stroke-slate-500"></path><path d="M12 4v1M17.66 6.344l-.828.828M20.005 12.004h-1M17.66 17.664l-.828-.828M12 20.01V19M6.34 17.664l.835-.836M3.995 12.004h1.01M6 6l.835.836" class="stroke-slate-400 dark:stroke-slate-500"></path>
                                </svg>
                            </span>
                            <span class="hidden dark:inline">
                                <svg viewBox="0 0 24 24" fill="none" class="w-8 h-8"><path class="fill-transparent" fill-rule="evenodd" clip-rule="evenodd" d="M17.715 15.15A6.5 6.5 0 0 1 9 6.035C6.106 6.922 4 9.645 4 12.867c0 3.94 3.153 7.136 7.042 7.136 3.101 0 5.734-2.032 6.673-4.853Z"></path><path class="fill-slate-400 dark:fill-slate-500" d="m17.715 15.15.95.316a1 1 0 0 0-1.445-1.185l.495.869ZM9 6.035l.846.534a1 1 0 0 0-1.14-1.49L9 6.035Zm8.221 8.246a5.47 5.47 0 0 1-2.72.718v2a7.47 7.47 0 0 0 3.71-.98l-.99-1.738Zm-2.72.718A5.5 5.5 0 0 1 9 9.5H7a7.5 7.5 0 0 0 7.5 7.5v-2ZM9 9.5c0-1.079.31-2.082.845-2.93L8.153 5.5A7.47 7.47 0 0 0 7 9.5h2Zm-4 3.368C5 10.089 6.815 7.75 9.292 6.99L8.706 5.08C5.397 6.094 3 9.201 3 12.867h2Zm6.042 6.136C7.718 19.003 5 16.268 5 12.867H3c0 4.48 3.588 8.136 8.042 8.136v-2Zm5.725-4.17c-.81 2.433-3.074 4.17-5.725 4.17v2c3.552 0 6.553-2.327 7.622-5.537l-1.897-.632Z"></path><path class="fill-slate-400 dark:fill-slate-500" fill-rule="evenodd" clip-rule="evenodd" d="M17 3a1 1 0 0 1 1 1 2 2 0 0 0 2 2 1 1 0 1 1 0 2 2 2 0 0 0-2 2 1 1 0 1 1-2 0 2 2 0 0 0-2-2 1 1 0 1 1 0-2 2 2 0 0 0 2-2 1 1 0 0 1 1-1Z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="hidden fixed z-40 inset-0 overflow-y-auto lg:hidden" id="left-dialog">
    <div class="fixed inset-0 bg-black/20 backdrop-blur-sm dark:bg-slate-900/80" id="left-dialog-close1"></div>
    <div class="relative h-screen bg-white w-60 max-w-[calc(100%-3rem)] p-6 dark:bg-slate-800">
        <button type="button" class="absolute z-10 top-5 right-5 w-8 h-8 flex items-center justify-center text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300" tabindex="0" id="left-dialog-close2">
            <svg viewBox="0 0 10 10" class="w-2.5 h-2.5 overflow-visible">
                <path d="M0 0L10 10M10 0L0 10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
        </button>
        <nav class="relative">
            <ul class="list-reset m-0 w-full md:w-auto">
                <li>
                    <a class="inline-block pr-4 py-3 no-underline text-orange-600 hover:text-grey-darker font-bold text-xl">{{$global_config['name']}}</a>
                </li>
                <li>
                    <a href="{{route('PtBlog.index')}}" class="inline-block px-4 py-3 no-underline text-grey-darkest hover:text-grey-darker font-bold text-lg {{$select_nav==='home' ? 'text-indigo-600' : ''}}">Home</a>
                </li>
                @foreach ($global_cate as $cate)
                    <li>
                        <a href="{{route('PtBlog.categories', ['id' => $cate['id']])}}" class="inline-block px-4 py-3 no-underline text-grey-darkest hover:text-grey-darker font-bold text-lg {{$select_nav==='categories_'.$cate['id'] ? 'text-indigo-600' : ''}}">{{$cate['name']}}</a>
                    </li>
                @endforeach
                @foreach ($global_nav as $nav)
                    <li>
                        <a href="{{$nav['url']}}" class="inline-block px-4 py-3 no-underline text-grey-darkest hover:text-grey-darker font-bold text-lg {{ request()->path() === $nav['url']  ? 'text-indigo-600' : ''}}">{{$nav['name']}}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
