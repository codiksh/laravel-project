<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.head')
    <meta charset="UTF-8">
    <title>@yield('title',config('app.name'))</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="_token" content="{!! csrf_token() !!}"/>

    @if(isset($si))
    <link rel="shortcut icon" href="{{ $si['favicon']->favicon }}" type="image/x-icon">
    @endif

    <!-- Bootstrap 4.0.0 -->
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/32/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css">

    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/31/select2.min.css">

    <!-- Ionicons -->
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/7/animate.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/8/toastr.min.css">

    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/30/waitMe.min.css">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/9/sweetalert2.min.css">
    <!-- Jquery Bonsai -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/10/jquery.bonsai.css">
    <!-- Jquery Time picker -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/11/jquery.timepicker.css">
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/12/daterangepicker.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://assets.codiksh.in/storage/media/assets/39/adminlte.min.css">
    <!-- DROPZONE CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <!-- NTB CSS -->
    <link rel="stylesheet" href="{{ asset('css/ntb.css') }}">


    @yield('css')
    @stack('stackedCss')
    <style>
        .card-head-row .float-right .datatables_action .action-button .fas {
            color: white;
        }

        .card-head-row .float-right .datatables_action .action-button {
            padding: 10%;
            margin-left: 100%;
        }

        .dropleft .dropdown-menu {
            padding: 0;
            z-index: 1040;
        }
    </style>
</head>
<body class="sidebar-mini hold-transition accent-primary sidebar-collapse fixed layout-fixed" >
<div class="wrapper">
    {{--    <div class="preloader flex-column justify-content-center align-items-center">--}}
    {{--        <img class="animation__shake" src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}'s Logo" height="60" width="60">--}}
    {{--    </div>--}}
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <div class="content-wrapper">
        <section class="content">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="w-100 d-flex justify-content-between mt-3">
                        <div class="align-items-center">
                            <div class="mb-2">
                                @yield('page_headers')
                            </div>
                            <small>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa-duotone fa-house-chimney-window"></i></a></li>
                                    @yield('breadcrumbs')
                                </ol>
                            </small>
                        </div>
                        <div class="d-flex align-items-center rotate360">
                            @yield('page_buttons')
                        </div>
                    </div>
                </div>
            </section>
            @yield('content')
        </section>
    </div>
    @include('admin.layouts.footer')
</div>
@yield('modal')

<!-- jQuery 3.5.1 -->
<script src="https://assets.codiksh.in/storage/media/assets/16/jquery.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/17/moment.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/18/popper.min.js"></script>
<!-- Bootstrap 4.0.0 -->
<script src="https://assets.codiksh.in/storage/media/assets/15/bootstrap.min.js"></script>
<!-- Date Range Picker -->
<script src="https://assets.codiksh.in/storage/media/assets/14/daterangepicker.js"></script>

<script src="https://assets.codiksh.in/storage/media/assets/19/jquery.slimscroll.min.js"></script>

<script src="https://assets.codiksh.in/storage/media/assets/20/icheck.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/21/select2.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/22/toastr.min.js"></script>
<script src="{{ asset('/assets/bower_components/tinymce/tinymce.min.js') }}"></script>
<script src="https://assets.codiksh.in/storage/media/assets/24/waitMe.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/25/sweetalert2.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/26/jquery.qubit.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/27/jquery.bonsai.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/28/jquery.timepicker.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/29/url_slug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>

<!-- AdminLTE App -->
<script src="https://assets.codiksh.in/storage/media/assets/38/adminlte.min.js"></script>


<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

=======
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script defer>
    $.ajaxSetup({headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }});
</script>
@include('admin.layouts.inits.master')
@include('layouts.helpers')

@yield('scripts')

@stack('stackedScripts')
</body>
</html>
