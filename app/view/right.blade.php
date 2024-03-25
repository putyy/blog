<div class="hidden lg:block z-20 inset-0 top-14 w-72 pb-10 px-8">
    <nav id="nav" class="text-sm leading-6 relative">
        <ul>
            @if (count($global_tag) > 0)
                <li class="mb-8">
                    <h5 class="mb-3 font-semibold text-slate-900 dark:text-slate-200">标签</h5>
                    <div class="flex flex-wrap">
                        @foreach ($global_tag as $tag)
                            <a href="{{route('PtBlog.index', ['tag_id' => $tag['id']])}}"
                               class="block rounded m-1 px-2 border border-solid text-slate-700 dark:text-slate-400 dark:hover:text-cyan-500 hover:text-cyan-500 border-slate-200 dark:border-slate-800 dark:hover:border-cyan-500 hover:border-cyan-500"
                               >{{$tag['name']}}{{$tag['articles_count'] > 0 ? '('.$tag['articles_count'].')' : ''}}</a>
                        @endforeach
                    </div>
                </li>
            @endif
            @if (count($global_article) > 0)
                <li class="mb-8">
                    <h5 class="mb-3 font-semibold text-slate-900 dark:text-slate-200">置顶推荐</h5>
                    <ul class="space-y-2 border-l border-slate-100 dark:border-slate-800">
                        @foreach ($global_article as $article)
                            <li>
                                <a class="block border-l pl-4 -ml-px border-transparent text-slate-700 dark:text-slate-400 hover:text-cyan-500 dark:hover:text-cyan-500 hover:border-cyan-500  dark:hover:border-cyan-500"
                                   href="{{route('PtBlog.articles', ['id' => $article['id']])}}"
                                   target="_blank">{{$article['title']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if (count($global_comment) > 0)
                <li class="mb-8">
                    <h5 class="mb-3 font-semibold text-slate-900 dark:text-slate-200">最新评论</h5>
                    <ul class="space-y-2 border-l border-slate-100 dark:border-slate-800">
                        @foreach ($global_comment as $comment)
                            <li>
                                <a class="block border-l pl-4 -ml-px border-transparent text-slate-700 dark:text-slate-400 hover:text-cyan-500 dark:hover:text-cyan-500 hover:border-cyan-500  dark:hover:border-cyan-500"
                                   href="{{route('PtBlog.articles', ['id' => $comment['article_id']])}}"
                                   target="_blank">{{$comment['content']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if (count($global_site)>0)
                <li class="mb-8">
                    <h5 class="mb-3 font-semibold text-slate-900 dark:text-slate-200">友情链接</h5>
                    <ul class="space-y-2 border-l border-slate-100 dark:border-slate-800">
                        @foreach ($global_site as $site)
                            <li>
                                <a class="block border-l pl-4 -ml-px border-transparent text-slate-700 dark:text-slate-400 hover:text-cyan-500 dark:hover:text-cyan-500 hover:border-cyan-500  dark:hover:border-cyan-500"
                                   href="{{$site['url']}}" target="_blank">{{$site['name']}}</a>
                            </li>
                        @endforeach
                        <li>
                            <a class="block border-l pl-4 -ml-px border-transparent text-slate-700 dark:text-slate-400 hover:text-cyan-500 dark:hover:text-cyan-500 hover:border-cyan-500  dark:hover:border-cyan-500"
                               href="{{route('PtBlog.sites')}}" target="_blank">查看全部</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</div>