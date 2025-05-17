@extends('index')
@section('head')
    <link href="/app/pt_blog/css/article.css" rel="stylesheet">
@endsection
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <div class="flex-1">
                <article class="mb-6 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <h1 class="text-3xl font-bold dark:text-blue-200 mb-4 text-center tracking-tight">
                        <a
                           class="transition-colors duration-200"
                           rel="bookmark">
                            {{ $data['title'] }}
                        </a>
                    </h1>
                    <p class="text-center text-sm font-medium text-gray-500 dark:text-gray-400 mb-6">
                        {{ $data['created_at'] }}
                    </p>
                    @if ($data['cover'])
                        <div class="mb-6">
                            <img src="{{ $data['cover'] }}"
                                 alt="{{ $data['title'] }}"
                                 class="w-full h-64 object-cover rounded-lg"
                                 loading="lazy">
                        </div>
                    @endif
                    <div class="prose prose-lg prose-slate dark:prose-invert leading-relaxed">
                        {!! htmlspecialchars_decode($data['content']['content']) !!}
                    </div>
                </article>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="mt-3 prose prose-slate dark:prose-invert text-gray-700 dark:text-gray-200">
                        {!! $global_config['article_html'] !!}
                    </div>
                    <div class="{{ $comments['total'] ? '' : 'hidden' }} text-sm text-gray-500 dark:text-gray-400 pb-3 mt-3 mb-6 border-b border-gray-200 dark:border-gray-700"
                         id="pt-comment-desc"
                         data-total="{{ $comments['total'] }}">
                        {{ $comments['total'] }}条回复 · {{ $comments['last_time'] }}
                    </div>
                    <div id="comments" class="space-y-6">
                        @php
                            $lightColors = [
                                'bg-blue-200 text-blue-800',
                                'bg-green-200 text-green-800',
                                'bg-orange-200 text-orange-800',
                                'bg-purple-200 text-purple-800',
                                'bg-red-200 text-red-800',
                            ];
                            $darkColors = [
                                'dark:bg-blue-700 dark:text-blue-100',
                                'dark:bg-green-700 dark:text-green-100',
                                'dark:bg-orange-700 dark:text-orange-100',
                                'dark:bg-purple-700 dark:text-purple-100',
                                'dark:bg-red-700 dark:text-red-100',
                            ];
                        @endphp
                        @foreach ($comments['data'] as $k => $comment)
                            @php
                                $colorIndex = $k % count($lightColors);
                                $lightColor = $lightColors[$colorIndex];
                                $darkColor = $darkColors[$colorIndex];
                            @endphp
                            <div class="comment flex flex-col">
                                <div class="flex items-start">
                                    <img src="{{ $comment['user']['avatar'] ?: '/app/pt_blog/image/default.png' }}"
                                         alt="{{ $comment['user']['nickname'] }}"
                                         class="w-10 h-10 mr-3 rounded-full"/>
                                    <div>
                                        <p class="text-base font-semibold text-indigo-600 dark:text-indigo-400">
                                            {{ $comment['user']['nickname'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ ptTimeShowFormat($comment['created_at']) }}
                                        </p>
                                    </div>
                                    <span class="ml-auto flex items-center comment-reply"
                                          data-id="{{ $comment['id'] }}"
                                          data-nickname="{{ $comment['user']['nickname'] }}"
                                          aria-label="回复 {{ $comment['user']['nickname'] }} 的评论">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400 mr-2" viewBox="0 0 1025 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M415.937331 320 415.937331 96 20.001331 438.176C-6.718669 461.28-6.622669 498.784 20.033331 521.824L415.937331 864 415.937331 640C639.937331 640 847.937331 688 1023.937331 928 943.937331 480 607.937331 320 415.937331 320" fill="currentColor"></path>
                                        </svg>
                                        <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $lightColor }} {{ $darkColor }}">
                                            {{ $comments['current_page'] * 10 - 10 + $k + 1 }}
                                        </span>
                                    </span>
                                </div>
                                <p class="text-base text-gray-700 dark:text-gray-200 mt-2 pl-12 leading-relaxed">
                                    @if (isset($comment['parent_user']))
                                        <span class="text-indigo-600 dark:text-indigo-400 text-sm">{{ '@'.$comment['parent_user']['nickname'] }}</span>
                                    @endif
                                    <span class="whitespace-pre-wrap">{!! htmlspecialchars_decode($comment['content']) !!}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    @if (count($comments['links']) > 3)
                        <nav class="flex justify-center mt-8" aria-label="Pagination">
                            <div class="flex items-center space-x-2">
                                @foreach ($comments['links'] as $link)
                                    @if ($link['label'] === 'Previous')
                                        <a href="{{ $link['url'] }}"
                                           class="p-2 text-gray-500 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    @elseif ($link['label'] === 'Next')
                                        <a href="{{ $link['url'] }}"
                                           class="p-2 text-gray-500 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ $link['url'] }}"
                                           class="px-3 py-1.5 font-medium rounded-md {{ $link['active'] ? 'bg-indigo-600 text-white dark:bg-indigo-500' : 'text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} transition-colors duration-200">
                                            {{ $link['label'] }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </nav>
                    @endif
                    <form class="w-full mt-8">
                        <label for="comment-textarea" class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 block">
                            发表评论
                        </label>
                        <textarea name="comment"
                                  id="comment-textarea"
                                  data-id="{{ $data['id'] }}"
                                  data-pid="0"
                                  data-nickname=""
                                  placeholder="请输入你的评论..."
                                  class="w-full p-4 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none resize-y min-h-[120px] transition-colors duration-200"></textarea>
                        <div class="flex items-center space-x-3 mt-4">
                            <button type="button"
                                    id="comment-send"
                                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-500 transition-colors duration-200 font-medium">
                                提交评论
                            </button>
                            <button type="button"
                                    id="comment-cancel"
                                    class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200 font-medium">
                                取消
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="lg:w-80 lg:sticky lg:top-20 mt-8 lg:mt-0">
                @include('right')
            </aside>
        </div>
    </div>
@endsection
@section('script')
    <script src="/app/pt_blog/js/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
@endsection