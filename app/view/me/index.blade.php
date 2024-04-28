@extends('index')
@section('content')
    <div class="mt-6">
        <div class="max-w-screen-lg md:flex mx-auto">
            <div class="md:w-1/3 p-2 md:flex md:justify-center">
                <div class="md:block flex justify-center items-center">
                    <img src="{!! $global_config['author-avatar'] !!}" alt="me" class="shadow-xl md:h-60 md:w-60 h-40 w-40 rounded-full">
                    <div class="mb-2 mx-7 mt-4 justify-center items-center">
                        <h1 class="md:text-3xl text-2xl text-gray-800 font-bold dark:text-blue-100">
                            {{$global_config['author-name']}}
                        </h1>
                        <div class="my-2 md:text-lg text-gray-600 dark:text-blue-100">
                            {{$global_config['author-sign']}}
                        </div>
                        <div class="my-2 text-gray-600 flex dark:text-blue-100">
                            <svg fill="none" width="24" height="24" stroke="currentColor" class="mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{$global_config['author-email']}}">{{$global_config['author-email']}}</a>
                        </div>
                        <div class="my-2 text-gray-600 flex dark:text-blue-100">
                            <svg fill="none" width="24" height="24" stroke="currentColor" class="mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <a href="https://map.baidu.com/search?querytype=con&from=alamap&tpl=mapcity&wd={{$global_config['author-address']}}&c=1&pn=0&device_ratio=1"
                               target="_blank">{{$global_config['author-address']}}
                            </a>
                        </div>
                        <div class="my-2 text-gray-600 flex dark:text-blue-100">
                            <svg width="24" height="24" viewBox="0 0 50 50" stroke="currentColor" class="mr-1"><path d="M17.791 46.836A1.999 1.999 0 0019 45v-5.4c0-.197.016-.402.041-.61A.611.611 0 0119 39h-3.6c-1.5 0-2.8-.6-3.4-1.8-.7-1.3-1-3.5-2.8-4.7-.3-.2-.1-.5.5-.5.6.1 1.9.9 2.7 2 .9 1.1 1.8 2 3.4 2 2.487 0 3.82-.125 4.622-.555C21.356 34.056 22.649 33 24 33v-.025c-5.668-.182-9.289-2.066-10.975-4.975-3.665.042-6.856.405-8.677.707a21.537 21.537 0 01-.151-.987c1.797-.296 4.843-.647 8.345-.714a8.162 8.162 0 01-.291-.849c-3.511-.178-6.541-.039-8.187.097-.02-.332-.047-.663-.051-.999 1.649-.135 4.597-.27 8.018-.111a9.832 9.832 0 01-.13-1.543c0-1.7.6-3.5 1.7-5-.5-1.7-1.2-5.3.2-6.6 2.7 0 4.6 1.3 5.5 2.1C21 13.4 22.9 13 25 13s4 .4 5.6 1.1c.9-.8 2.8-2.1 5.5-2.1 1.5 1.4.7 5 .2 6.6 1.1 1.5 1.7 3.2 1.6 5 0 .484-.045.951-.11 1.409 3.499-.172 6.527-.034 8.204.102-.002.337-.033.666-.051.999-1.671-.138-4.775-.28-8.359-.089a8.272 8.272 0 01-.325.98c3.546.046 6.665.389 8.548.689-.043.332-.093.661-.151.987-1.912-.306-5.171-.664-8.879-.682-1.665 2.878-5.22 4.755-10.777 4.974V33c2.6 0 5 3.9 5 6.6V45c0 .823.498 1.53 1.209 1.836C41.37 43.804 48 35.164 48 25 48 12.318 37.683 2 25 2S2 12.318 2 25c0 10.164 6.63 18.804 15.791 21.836z"></path>
                            </svg>
                            <a href="https://github.com/{{$global_config['author-github']}}" target="_blank">{{$global_config['author-github']}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:w-2/3 px-8">
                {!! $global_config['author-html'] !!}
            </div>
        </div>
    </div>
@endsection