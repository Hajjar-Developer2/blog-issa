<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('Title')

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    {{-- <link rel="stylesheet" href="http://127.0.0.1/cdn/bootstrap/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ url('Style.css') }}">
    <link rel="stylesheet" href="{{ url('/toast/toastr.min.css') }}">

    @yield('Style')

</head>
<body>

  @yield('Content')
  
</div>
 {{-- <script src="http://127.0.0.1/cdn/jquery/jquery.min.js" ></script> --}}
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
 <!-- Latest compiled and minified JavaScript -->
{{-- <script src="http://127.0.0.1/cdn/bootstrap/js/bootstrap.min.js"></script> --}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="{{ url('/toast/toastr.min.js') }}"></script>
 @yield('Script')
 @include('includes.Scripts')


</body>
</html>