<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$head_title ? $head_title.' - ' : ''}}{{$global_config['name']}} </title>
    <meta name="keywords" content="{{$head_keywords ?: $global_config['keyword']}}">
    <meta name="description" content="{{$head_description ?: $global_config['description']}}">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="/app/pt_blog/css/blog.css" rel="stylesheet">
    @yield('head')
    <script src="/app/pt_blog/js/tailwindcss.js"></script>
    <script>
        tailwind.config = {
            darkMode: (localStorage.theme === "class" || localStorage.theme === undefined) ? "class" : "",
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
        window.global_user = @json($global_user);
    </script>
</head>
<body class="antialiased text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 h-screen flex flex-col justify-between pt-scrollbar">
    <section class="w-full flex flex-col grow z-40 ">
        @include('nav')
        @yield('content')
    </section>
    <div class="bg-canvas">
        <canvas id="canvas" style="position: fixed;top: 0;z-index: -1" width="1920" height="1080">
            您的浏览器不支持canvas标签，请您更换浏览器
        </canvas>
    </div>
    @include('footer')
    {!! $global_config['common_html'] !!}
    <div id="notice" class="hidden bg-white fixed top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 py-5 px-5 text-slate-500 text-sm rounded-lg border border-gray-200 shadow-sm duration-300 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
        Hello World!
    </div>
    @include('login')
    <script src="/app/pt_blog/js/blog.js?v={{$global_version}}}"></script>
    @yield('script')
</body>
</html>