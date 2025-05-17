<aside class="lg:w-80 mt-6 lg:mt-0">
    @if (count($global_tag) > 0)
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">标签</h3>
            <div class="flex flex-wrap gap-2">
                @php
                    $lightColors = [
                        'bg-blue-200 text-blue-800',
                        'bg-green-200 text-green-800',
                        'bg-orange-200 text-orange-800',
                        'bg-purple-200 text-purple-800',
                        'bg-yellow-200 text-yellow-800',
                        'bg-teal-200 text-teal-800',
                        'bg-pink-200 text-pink-800',
                        'bg-indigo-200 text-indigo-800',
                        'bg-gray-200 text-gray-800',
                    ];

                    $darkColors = [
                        'dark:bg-blue-700 dark:text-blue-100',
                        'dark:bg-green-700 dark:text-green-100',
                        'dark:bg-orange-700 dark:text-orange-100',
                        'dark:bg-purple-700 dark:text-purple-100',
                        'dark:bg-yellow-700 dark:text-yellow-100',
                        'dark:bg-teal-700 dark:text-teal-100',
                        'dark:bg-pink-700 dark:text-pink-100',
                        'dark:bg-indigo-700 dark:text-indigo-100',
                        'dark:bg-gray-700 dark:text-gray-100',
                    ];
                @endphp
                @foreach ($global_tag as $index => $tag)
                    @php
                        $lightColor = $lightColors[rand(0,8)];
                        $darkColor = $darkColors[rand(0,8)];
                    @endphp
                    <a href="{{ route('PtBlog.index', ['tag_id' => $tag['id']]) }}"
                       class="px-3 py-1 text-sm font-medium rounded-full {{ $lightColor }} {{$darkColor}} hover:bg-indigo-300 dark:hover:bg-indigo-800 hover:text-indigo-900 dark:hover:text-indigo-200 transition-all duration-200 transform hover:scale-105">
                        {{ $tag['name'] }}{{ $tag['articles_count'] > 0 ? ' (' . $tag['articles_count'] . ')' : '' }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if (count($global_article) > 0)
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">置顶推荐</h3>
            <ul class="space-y-4">
                @foreach ($global_article as $article)
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <a href="{{ route('PtBlog.articles', ['id' => $article['id']]) }}"
                           class="text-base text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 line-clamp-2">
                            {{ $article['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (count($global_site) > 0)
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">友情链接</h3>
            <ul class="space-y-4">
                @foreach ($global_site as $site)
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <a href="{{ $site['url'] }}"
                           class="text-base text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200"
                           target="_blank" rel="noopener noreferrer">
                            {{ $site['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('PtBlog.sites') }}"
               class="block mt-4 text-base text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                查看全部
            </a>
        </div>
    @endif

    @if (count($global_comment) > 0)
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">最新评论</h3>
            <ul class="space-y-4 border-l border-slate-100 dark:border-slate-800">
                @foreach ($global_comment as $comment)
                    <li>
                        <a class="block border-l pl-4 -ml-px border-transparent text-slate-700 dark:text-slate-400 hover:text-cyan-500 dark:hover:text-cyan-500 hover:border-cyan-500  dark:hover:border-cyan-500" href="{{route('PtBlog.articles', ['id' => $comment['article_id']])}}" target="_blank">
                            <span class="line-clamp-2">
                                {{$comment['content']}}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</aside>