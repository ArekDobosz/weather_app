<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    
</head>
<body>
    <div class="container">

        <div class="panel panel-success">
            <div class="panel-body">                        
                <div class="col-md-6 pull-left">
                    <button class="btn btn-default" id="set_position">
                        <img src="{{ asset('img/location.png') }}" height="25px" title="Ustal pozycję">
                    </button>
                    <!-- Twoja aktualna pozycja:  -->
                    <span id="countryOutput"></span>
                    <span id="cityOutput"></span>               
                </div>
                <div class="col-md-6 pull-right text-right">
                    @include('utils.search')
                </div>
            </div>
        </div>
        <div class="panel panel-info" id="info_panel">            
            @yield('details')            
        </div>
        @yield('form')
    </div>

    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

        @yield('script')

</body>
</html>