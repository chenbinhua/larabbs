<!doctype html>
<html lang=" {{ app()->getLocale() }} ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content=" {{ csrf_token() }} ">
    <title>@yield('title','LaraBBS') -- Laravel BBS</title>
    <meta name="description" content="@yield('description', 'Laravel BBS社区')">

    <link rel="stylesheet" href=" {{ asset('css/app.css') }} ">
    @yield('styles')
</head>
<body>
<div id="app" class="{{ route_class() }}-page ">

    @include('layouts._header')

    <div class="container">
        @include('layouts._message')
        @yield('content')
    </div>

    @include('layouts._footer')
</div>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>