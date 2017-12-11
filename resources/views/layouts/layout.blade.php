<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    
</head>
<body>
    <div class="container">

        <div class="panel panel-success">
            <div class="panel-heading text-center">
                        
                <h5 class="pull-left">
                    Twoja aktualna pozycja: 
                    <span id="countryOutput"></span>,
                    <span id="cityOutput"></span>               
                </h5>
                <div class="pull-right">
                    @include('search')
                </div>
            </div>
            <div class="panel-body text-center">
                @yield('details')
            </div>
        </div>

        @yield('form')


    </div>

        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>    
        @yield('script')
    <!-- Scripts -->
</body>
</html>