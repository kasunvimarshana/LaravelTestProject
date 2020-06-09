<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Laravel</title>
        
        @section('styles')
            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" />
            <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}"/>
        @show
        <style>
            .error{
                color: rgba(255, 0, 0, 1);
                margin: 3px;
            }
        </style>
        @section('scripts')
            <script src="{!! asset('js/app.js') !!}"></script>
        @show
    </head>
    <body>

        @section('nav')
            @includeIf('partials.nav', array())
        @show

        <div class="container">
            <!-- -->
            @yield('container')
            <!-- -->
        </div>
        
        @stack('page_scripts')
    </body>
</html>