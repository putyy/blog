<nav class="sticky top-0 z-50 w-full bg-white dark:bg-gray-900 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between flex-wrap gap-4">
        <div class="hidden lg:flex items-center space-x-6">
            <a href="/" class="text-orange-600 hover:text-orange-700 font-bold text-xl transition-colors duration-200">
                {{ $global_config['name'] }}
            </a>
            <ul class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('PtBlog.index') }}"
                       class="text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-lg transition-colors duration-200 {{ $select_nav === 'home' ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                        Home
                    </a>
                </li>
                @foreach ($global_cate as $cate)
                    <li>
                        <a href="{{ route('PtBlog.categories', ['id' => $cate['id']]) }}"
                           class="text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-lg transition-colors duration-200 {{ $select_nav === 'categories_' . $cate['id'] ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                            {{ $cate['name'] }}
                        </a>
                    </li>
                @endforeach
                @foreach ($global_nav as $nav)
                    <li>
                        <a href="{{ $nav['url'] }}"
                           class="text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-lg transition-colors duration-200 {{ request()->path() === $nav['url'] ? 'text-indigo-600 dark:text-indigo-400' : '' }}"
                           {{ strpos($nav['url'], 'http') === 0 ? 'target="_blank"' : '' }}
                        >
                            {{ $nav['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="lg:hidden flex items-center">
            <button type="button" id="left-dialog-show"
                    class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div class="flex items-center space-x-4">
            <div class="relative flex items-center">
                <input type="search" id="search-val"
                       class="pl-3 pr-10 py-1.5 text-sm text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none placeholder-gray-400 dark:placeholder-gray-500"
                       placeholder="快速搜索..." maxlength="64" value="{{ request()->get('keyword') }}"
                autocomplete="off" autocorrect="off" autocapitalize="off" enterkeyhint="go" spellcheck="false"/>
                <svg id="search"  class="absolute right-3 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m19 19-3.5-3.5"/>
                    <circle cx="11" cy="11" r="6"/>
                </svg>
            </div>

            <div class="relative">
                <button id="user-btn" type="button"
                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 6v.01M12 12v.01M12 18v.01M12 7a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                    </svg>
                </button>
                <ul id="user-info"
                    class="hidden absolute z-50 top-full right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 py-2 text-sm text-gray-700 dark:text-gray-200 font-semibold">
                    <li class="{{$global_user['uid'] > 0 ? '' : 'hidden'}} flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <img class="w-6 h-6 rounded-full mr-2" src="{{ $global_user['avatar'] }}"
                             alt="{{ $global_user['nickname'] }}">
                        {{ $global_user['nickname'] }}
                    </li>
                    <li id="user-info-update"
                        class="{{$global_user['uid'] > 0 ? '' : 'hidden'}} px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        修改资料
                    </li>
                    <li id="user-login-out"
                        class="{{$global_user['uid'] > 0 ? '' : 'hidden'}} px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        退出登录
                    </li>
                </ul>
            </div>

            <button id="change-theme" type="button"
                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6 dark:hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    <path d="M12 4v1M17.66 6.344l-.828.828M20.005 12.004h-1M17.66 17.664l-.828-.828M12 20.01V19M6.34 17.664l.835-.836M3.995 12.004h1.01M6 6l.835.836"/>
                </svg>
                <svg class="w-6 h-6 hidden dark:inline" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path class="fill-transparent" fill-rule="evenodd" clip-rule="evenodd"
                          d="M17.715 15.15A6.5 6.5 0 0 1 9 6.035C6.106 6.922 4 9.645 4 12.867c0 3.94 3.153 7.136 7.042 7.136 3.101 0 5.734-2.032 6.673-4.853Z"/>
                    <path class="fill-current"
                          d="m17.715 15.15.95.316a1 1 0 0 0-1.445-1.185l.495.869ZM9 6.035l.846.534a1 1 0 0 0-1.14-1.49L9 6.035Zm8.221 8.246a5.47 5.47 0 0 1-2.72.718v2a7.47 7.47 0 0 0 3.71-.98l-.99-1.738Zm-2.72.718A5.5 5.5 0 0 1 9 9.5H7a7.5 7.5 0 0 0 7.5 7.5v-2ZM9 9.5c0-1.079.31-2.082.845-2.93L8.153 5.5A7.47 7.47 0 0 0 7 9.5h2Zm-4 3.368C5 10.089 6.815 7.75 9.292 6.99L8.706 5.08C5.397 6.094 3 9.201 3 12.867h2Zm6.042 6.136C7.718 19.003 5 16.268 5 12.867H3c0 4.48 3.588 8.136 8.042 8.136v-2Zm5.725-4.17c-.81 2.433-3.074 4.17-5.725 4.17v2c3.552 0 6.553-2.327 7.622-5.537l-1.897-.632Z"/>
                    <path class="fill-current" fill-rule="evenodd" clip-rule="evenodd"
                          d="M17 3a1 1 0 0 1 1 1 2 2 0 0 0 2 2 1 1 0 1 1 0 2 2 2 0 0 0-2 2 1 1 0 1 1-2 0 2 2 0 0 0-2-2 1 1 0 1 1 0-2 2 2 0 0 0 2-2 1 1 0 0 1 1-1Z"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

<div class="hidden fixed inset-0 z-50 lg:hidden" id="left-dialog">
    <div class="fixed inset-0 bg-black/20 backdrop-blur-sm dark:bg-gray-900/80" id="left-dialog-close1"></div>
    <div class="relative h-screen w-64 bg-white dark:bg-gray-800 p-6 transform transition-transform duration-300">
        <button type="button" id="left-dialog-close2"
                class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M0 0L10 10M10 0L0 10"/>
            </svg>
        </button>
        <nav>
            <ul class="space-y-4">
                <li>
                    <a href="/" class="block px-4 py-2 text-orange-600 hover:text-orange-700 font-bold text-xl">
                        {{ $global_config['name'] }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('PtBlog.index') }}"
                       class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-lg {{ $select_nav === 'home' ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                        Home
                    </a>
                </li>
                @foreach ($global_cate as $cate)
                    <li>
                        <a href="{{ route('PtBlog.categories', ['id' => $cate['id']]) }}"
                           class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-lg {{ $select_nav === 'categories_' . $cate['id'] ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                            {{ $cate['name'] }}
                        </a>
                    </li>
                @endforeach
                @foreach ($global_nav as $nav)
                    <li>
                        <a href="{{ $nav['url'] }}"
                           class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-lg {{ request()->path() === $nav['url'] ? 'text-indigo-600 dark:text-indigo-400' : '' }}"
                                {{ strpos($nav['url'], 'http') === 0 ? 'target="_blank"' : '' }}>
                            {{ $nav['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>