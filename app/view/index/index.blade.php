@extends('index')
@section('content')
    <div class="flex justify-center grow mx-auto px-0 w-full mt-6 lg:max-w-6xl lg:px-10">
        <div class="flex flex-col justify-between grow items-center">
            <div class="lg:max-w-6xl w-full">
                @foreach ($data['data'] as $article)
                    <article class="mb-5 flex flex-col p-4 rounded-md border-solid border-2 border-zinc-100 dark:border-slate-800 mx-5 lg:mx-auto lg:w-[50rem]">
                        <h3 class="mb-3 text-xl text-slate-900 tracking-tight font-normal dark:text-blue-100">
                            <a href="{{route('PtBlog.articles', ['id' => $article['id']])}}">{{$article['title']}}</a>
                        </h3>
                        <div class="mb-3 prose prose-slate dark:prose-dark dark:text-slate-400">
                            <a href="{{route('PtBlog.articles', ['id' => $article['id']])}}">
                                {{$article['description']}}
                            </a>
                        </div>
                        <div class="mt-auto flex items-center justify-between text-sm">
                            <div>
                                <p class="dark:text-slate-400">{{$article['created_at']}}</p>
                            </div>
                            <div>
                                @foreach ($article['tag_name'] as $tag)
                                <a href="{{route('PtBlog.index', ['tag_id' => $tag[0]])}}" class="rounded m-1 px-2 border border-solid text-slate-700 dark:text-slate-400 dark:hover:text-cyan-500 hover:text-cyan-500 border-slate-200 dark:border-slate-800 dark:hover:border-cyan-500 hover:border-cyan-500">{{$tag[1]}}</a>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if(count($data['links']) > 3)
                <div class="flex justify-center mt-4 text-gray-500 dark:text-blue-300 font-medium">
                    <nav class="flex items-center" aria-label="Pagination">
                        @foreach ($data['links'] as $link)
                            @if($link['label'] === 'Previous')
                                <a href="{{$link['url']}}" class="px-2 py-2 text-base">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @elseif($link['label'] === 'Next')
                                <a href="{{$link['url']}}"
                                   class="px-2 py-2 text-base">
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
        </div>

        @include('right')
    </div>
@endsection