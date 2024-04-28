@extends('index')
@section('head')
    <link href="/app/pt_blog/css/github-dark.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="flex justify-center grow mx-auto lg:max-w-6xl px-0 w-full mt-6 lg:px-10">
        <div class="mb-5 flex flex-col justify-between p-4 mx-5 w-full lg:mx-auto lg:w-[50rem]">
            <div>
                <h1 class="text-2xl text-slate-900 font-normal mb-2 text-center dark:text-blue-100">
                    {{$data['title']}}
                </h1>
                <p class="text-center font-bold my-2 text-indigo-500">
                    {{$data['created_at']}}
                </p>
                @if($data['cover'])
                    <img src="{{$data['cover']}}" class="mx-auto my-6 rounded-md" alt="{{$data['title']}}">
                @endif
                <div class="prose max-w-full mx-auto nuxt-content break-words overflow-hidden pt-article-content">
                    {!! htmlspecialchars_decode($data['content']['content']) !!}
                </div>
            </div>
            <div class="w-full mx-auto bg-white rounded-lg bg-white dark:bg-slate-900 p-1 mt-5">
                <div class="mt-3">
                    {!! $global_config['article_html'] !!}
                </div>
                <div class="{{$comments['total'] ? '' : 'hidden'}} text-md text-slate-400 pb-3 mb-3 border-b border-gray-100 dark:border-slate-700">{{$comments['total']}}条回复 · {{$comments['last_time']}}</div>
                <div id="comments">
                    @foreach($comments['data'] as $k=>$comment)
                    <div class="comment">
                        <div class="flex">
                            <img src="{{$comment['user']['avatar'] ?: '/app/pt_blog/image/default.png'}}" alt="{{$comment['user']['nickname']}}" class="w-10 h-10 mr-2 rounded-md"/>
                            <div>
                                <label class="text-cyan-500">{{$comment['user']['nickname']}}</label>
                                <p class="text-gray-600 text-sm">{{ptTimeShowFormat($comment['created_at'])}}</p>
                            </div>
                            <span class="ml-auto flex align-center justify-center comment-reply" data-id="{{$comment['id']}}" data-nickname="{{$comment['user']['nickname']}}">
                                <svg class="h-4 w-4 text-gray-500 mr-2" viewBox="0 0 1025 1024" xmlns="http://www.w3.org/2000/svg" width="200" height="200">
                                    <path d="M415.937331 320 415.937331 96 20.001331 438.176C-6.718669 461.28-6.622669 498.784 20.033331 521.824L415.937331 864 415.937331 640C639.937331 640 847.937331 688 1023.937331 928 943.937331 480 607.937331 320 415.937331 320" fill="#8a8a8a"></path>
                                </svg>
                                <label class="rounded-full p-1 bg-gray-400 w-auto min-w-5 h-5 text-xs text-slate-300 flex items-center justify-center">{{$comments['current_page'] * 10-10 + $k + 1}}</label>
                           </span>
                        </div>
                        <p class="text-slate-700 dark:text-slate-400 pb-4 pt-2 pl-12 text-md">
                            @if(isset($comment['parent_user']))
                            <label class="text-teal-700 text-xs">{{'@'.$comment['parent_user']['nickname']}}</label>
                            @endif
                            {!! htmlspecialchars_decode($comment['content']) !!}
                        </p>
                    </div>
                    @endforeach
                </div>
                @if(count($comments['links']) > 3)
                    <div class="flex justify-center mt-4 text-gray-500 dark:text-blue-300 font-medium">
                        <nav class="flex items-center" aria-label="Pagination">
                            @foreach ($comments['links'] as $link)
                                @if($link['label'] === 'Previous')
                                    <a href="{{$link['url']}}" class="px-2 py-2 text-base">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @elseif($link['label'] === 'Next')
                                    <a href="{{$link['url']}}" class="px-2 py-2 text-base">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{$link['url']}}" class="px-3 py-2 font-bold {{$link['active'] ? 'text-2xl text-indigo-600 dark:text-blue-300' : 'text-base'}}">
                                        {{$link['label']}}
                                    </a>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                @endif
                <form class="w-full grid">
                    <label for="comment-textarea" class="text-3xl my-6">评论</label>
                    <textarea name="comment" id="comment-textarea" data-id="{{$data['id']}}" data-pid="0" data-nickname="" placeholder="请输入你的评论" class="outline-none bg-gray-50 p-2 rounded flex-grow border-0 dark:bg-slate-800 dark:highlight-white dark:hover:bg-slate-700"></textarea>
                    <div class="py-4">
                        <input type="button" id="comment-send" value="评论" class="px-4 py-1 bg-blue-600 rounded text-white"/>
                        <input type="button" id="comment-cancel" value="取消" class="px-4 py-1 bg-white rounded border ml-3"/>
                    </div>
                </form>
            </div>
        </div>
        @include('right')
    </div>
@endsection
@section('script')
<script src="/app/pt_blog/js/highlight.min.js"></script>
<script>
    hljs.highlightAll();
</script>
@endsection