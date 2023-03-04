@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\RolePermission;
@endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png">
    <title>@yield('title') | PICO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
</head>
<body>
<div class="wrapper">
    @include('layout/sidebar')
    <div class="main">
        @include('layout/header')
        @yield('content')
        @include('layout/footer')
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/datatables.js')}}"></script>

<script>
    @if(\Session::has('message'))
    // Notyf
    document.addEventListener("DOMContentLoaded", function () {

        var message = "{{\Session::get('message')}}";
        var type = '{{\Session::get('type')}}';
        var duration = {{\Session::get('duration')}};
        var ripple = true;
        var dismissible = {{\Session::get('dismissible')}};
        var positionX = 'right';
        var positionY = 'top';
        window.notyf.open({
            type,
            message,
            duration,
            ripple,
            dismissible,
            position: {
                x: positionX,
                y: positionY
            }
        });

    });
    @endif
</script>

@php
    $role_records = RolePermission::all()->where('role_id', Auth::user()->role_id);
             foreach ($role_records as $role_record){
                 $res[] = $role_record->permissions_id;
             }
@endphp

@if(in_array(9, $res))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Datatables with Buttons
            var datatablesButtons = $("#datatables-buttons").DataTable({
                responsive: true,
                lengthChange: !1,
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'print'
                ]
            });
            datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)");
        });
    </script>
@endif
</body>
</html>
