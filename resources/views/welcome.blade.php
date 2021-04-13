<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Full stack blog</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/vendor/css/sb-admin-2.min.css') }}">
    </head>
    <body>
        <div id="app">
            <main-app></main-app>
        </div>
    </body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>
</html>
