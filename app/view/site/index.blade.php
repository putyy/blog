@extends('index')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="pt-6 pb-8 space-y-2 md:space-y-5">
            {!! $global_config['site_html'] !!}
        </div>
        <main class="relative mb-auto">
            <div class="container py-12">
                <div class="flex flex-wrap -m-4">

                    @foreach ($sites as $site)
                        <div class="p-4 w-full md:w-1/2">
                            <div class="h-full overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="p-4">
                                    <div class="flex flex-row justify-between items-center">
                                        <div class="my-2">
                                        </div>
                                        <div class="flex flex-row justify-between">
                                            <div class="mx-1">
                                                <a target="_blank" rel="noopener noreferrer" href="{{$site['url']}}"
                                                   class="text-sm text-gray-500 transition hover:text-gray-600">
                                                    <span class="sr-only"></span>
                                                    <img src="/app/pt_blog/image/external.svg" class="w-6 h-6"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight mb-3 dark:text-blue-200">
                                        {{$site['name']}}
                                    </h2>
                                    <p class="prose text-gray-500 max-w-none dark:text-gray-400 mb-3">
                                        {{$site['remark']}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </main>
    </div>
@endsection