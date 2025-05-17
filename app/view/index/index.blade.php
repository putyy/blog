@extends('index')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <div class="flex-1">
                @foreach ($data['data'] as $article)
                    <article
                            class="mb-6 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200 mx-0 lg:mx-auto">
                        <h3 class="mb-3 text-2xl font-bold dark:text-blue-200 tracking-tight ">
                            <a href="{{ route('PtBlog.articles', ['id' => $article['id']]) }}"
                               class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200" rel="bookmark">
                                {{ $article['title'] }}
                            </a>
                        </h3>
                        <div class="mb-4 prose prose-lg prose-slate dark:prose-invert text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-3">
                            <a href="{{ route('PtBlog.articles', ['id' => $article['id']]) }}">
                                {{ $article['description'] }}
                            </a>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">
                                    {{ $article['created_at'] }}
                                </p>
                            </div>
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
                                @foreach ($article['tag_name'] as $index => $tag)
                                    @php
                                        $lightColor = $lightColors[rand(0, 8)];
                                        $darkColor = $darkColors[rand(0, 8)];
                                    @endphp
                                    <a href="{{ route('PtBlog.index', ['tag_id' => $tag[0]]) }}"
                                       class="px-2 py-1 text-xs font-semibold rounded-full {{ $lightColor }} {{ $darkColor }} hover:bg-indigo-200 dark:hover:bg-indigo-900 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors transform hover:scale-105 transition-transform duration-200 ">
                                        {{ $tag[1] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach

                @if (empty($data['data']))
                    <div class="flex flex-col items-center justify-center p-6 text-center text-gray-500">
                        <svg class="w-12 h-12 mb-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.75 3.75a7.5 7.5 0 0012.9 12.9z" />
                        </svg>
                        <p class="text-lg font-medium">未找到相关内容</p>
                    </div>
                @endif

                @if (count($data['links']) > 3)
                    <nav class="flex justify-center mt-8" aria-label="Pagination">
                        <div class="flex items-center space-x-2">
                            @foreach ($data['links'] as $link)
                                @if ($link['label'] === 'Previous')
                                    <a href="{{ $link['url'] }}"
                                       class="p-2 text-gray-500 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @elseif ($link['label'] === 'Next')
                                    <a href="{{ $link['url'] }}"
                                       class="p-2 text-gray-500 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                  clip-rule="evenodd"/>
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
            </div>

            @include('right')
        </div>
    </div>
@endsection