<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ URL::asset('img/favicon.png'); }}"> 
        <title>Calidad</title>    
        
        {{-- Bootstrap 5 --}}
        <link href="{{ URL::asset('libraries/bootstrap5/css/bootstrap.css'); }}" rel="stylesheet"/>

        {{-- Select2 --}}
        <link href="{{ URL::asset('libraries/select2/select2.min.css'); }}" rel="stylesheet"/>
        <link href="{{ URL::asset('libraries/select2/select2-bootstrap-5-theme.min.css'); }}" rel="stylesheet"/>

        {{-- Datatable --}}
        <link href="{{ URL::asset('libraries/datatables-bs5/datatables.min.css'); }}" rel="stylesheet"> 

        {{-- Nice Admin --}}
        <link href="{{ URL::asset('libraries/niceadmin/css/style.css'); }}" rel="stylesheet"/>

        {{-- Bootstrap-icons --}}
        <link href="{{ URL::asset('libraries/bootstrap-icons/bootstrap-icons.css'); }}" rel="stylesheet"/>

        {{-- Toastify --}}
        <link href="{{ URL::asset('libraries/toastify/toastify.min.css'); }}" rel="stylesheet"/>

        {{-- Daterangepicker --}}
        <link href="{{ URL::asset('libraries/daterangepicker/daterangepicker.css'); }}" rel="stylesheet"/>

        {{-- Apexcharts --}}
        <link href="{{ URL::asset('libraries/apexcharts/apexcharts.css'); }}" rel="stylesheet"/>

        {{-- Custom --}}
        <link href="{{ URL::asset('libraries/custom/css/style.css'); }}" rel="stylesheet"/>



        
        {{-- JQuery --}}
        <script src="{{ URL::asset('libraries/jquery3/jquery.min.js'); }}"></script>

        {{-- Bootstrap 5 --}}
        <script src="{{ URL::asset('libraries/bootstrap5/js/bootstrap.bundle.min.js'); }}" defer></script>

        {{-- Select2 --}}
        <script src="{{ URL::asset('libraries/select2/select2.min.js') }}" defer></script>

        {{-- Datatable --}}
        <script src="{{ URL::asset('libraries/datatables-bs5/datatables.min.js') }}" defer></script>

        {{-- Nice Admin --}}
        <script src="{{ URL::asset('libraries/niceadmin/js/main.js'); }}" defer></script>

        {{-- Toastify --}}
        <script src="{{ URL::asset('libraries/toastify/toastify.min.js'); }}" defer></script>

        {{-- Sweet Alert --}}
        <script src="{{ URL::asset('libraries/sweetalert/sweetalert.min.js'); }}" defer></script>

        {{-- Moment JS --}}
        <script src="{{ URL::asset('libraries/moment/moment-with-locales.js'); }}" defer></script>

        {{-- daterangepicker --}}
        <script src="{{ URL::asset('libraries/daterangepicker/daterangepicker.js'); }}" defer></script>

        {{-- Apexcharts --}}
        <script src="{{ URL::asset('libraries/apexcharts/apexcharts.min.js'); }}" defer></script>

        <script src="{{ URL::asset('libraries/custom/js/custom.js'); }}" defer></script>
        <script src="{{ URL::asset('libraries/custom/js/datatables.js'); }}" defer></script>
        <script src="{{ URL::asset('libraries/custom/js/sweetalert.js'); }}" defer></script>
        <script src="{{ URL::asset('libraries/custom/js/daterangepicker.js'); }}" defer></script>







        {{--@vite(['resources/css/app.scss', 'resources/js/app.js'])--}}

    </head>
    <body>


        @yield('app')
 





    </body>
</html>