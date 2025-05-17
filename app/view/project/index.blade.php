@extends('index')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="pt-6 pb-8 space-y-2 md:space-y-5">
            {!! $global_config['project_html'] !!}
        </div>
        <main class="relative mb-auto">
            <div class="container py-12">
                <div class="flex flex-wrap -m-4">
                    @foreach ($projects as $project)
                        <div class="p-4 w-full md:w-1/2">
                            <div class="h-full overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="p-6">
                                    <div class="flex flex-row justify-between items-center">
                                        <div class="my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-primary-color dark:text-primary-color-dark h-10 w-10 text-indigo-800">
                                                <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex flex-row justify-between">
                                            <div class="mx-1">
                                                <a target="_blank" rel="noopener noreferrer" href="{{$project['url']}}" class="text-sm text-gray-500 transition hover:text-gray-600">
                                                    <img src="/app/pt_blog/image/external.svg" class="w-6 h-6">
                                                </a>
                                            </div>
                                            @if($project['github'])
                                                <div class="mx-1">
                                                    <a target="_blank" rel="noopener noreferrer" href="https://github.com/{{$project['github']}}" class="text-sm text-gray-500 transition hover:text-gray-600">
                                                        <img src="/app/pt_blog/image/github.svg" class="w-6 h-6">
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <h2 class="text-2xl font-bold leading-8 tracking-tight mb-3 dark:text-blue-200">
                                        {{$project['title']}}
                                    </h2>
                                    <p class="prose text-gray-500 max-w-none dark:text-gray-400 mb-3">
                                        {{$project['description']}}
                                    </p>
                                    <div class="flex flex-row justify-between">
                                        <div class="text-gray-400 text-sm font-extralight">{{str_replace(',', ' • ', $project['tags'])}}</div>
                                        <div class="text-gray-400 text-sm font-extralight hidden" data-github="{{$project['github']}}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
    @foreach ($projects as $key=>$project)
        @if($project['github'])
            <script>
                function githubCallback{{$key}}(res) {
                    var obj = document.querySelectorAll('[data-github="' + res.data.full_name + '"]')[0];
                    obj.innerHTML = "Starred: " + res.data.stargazers_count + "&nbsp;&nbsp;Fork: " + res.data.forks_count
                    obj.classList.remove('hidden')
                }
            </script>
            <script src="https://api.github.com/repos/{{$project['github']}}?callback=githubCallback{{$key}}"></script>
        @endif
    @endforeach
@endsection
