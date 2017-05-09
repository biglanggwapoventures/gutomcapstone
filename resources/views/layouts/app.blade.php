<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/rating/themes/fontawesome-stars-o.css') }}">
    
    @stack('styles')
    <title>@yield('title')</title>
    
</head>
<body>

    @yield('content')


    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/rating/jquery.barrating.min.js') }}"></script>
    
    @stack('scripts')
    @if(session('notification'))
    
        <script type="text/javascript">
            $(document).ready(function(){
                new Noty({ 
                    layout: 'bottomRight',
                    text: '{{ session("notification") }}', 
                    type: 'error', 
                    timeout: 2000,
                }).show();
            })
        </script>

    @endif
    
</body>
</html>