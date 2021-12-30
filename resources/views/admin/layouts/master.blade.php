<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title',env('APP_NAME'))</title>
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
    <link  href="{{ asset('vendor/dropzone/dropzone.css') }}"  rel="stylesheet">
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
<body class="sidebar-mini hold-transition accent-primary" >
<div class="wrapper">
    <!-- Main Header -->
    @include('admin.layouts.header')
    <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
{{--        <section class="content-header">--}}
{{--            <h1>--}}
{{--                {{ $params['page_header'] ?? '' }}--}}
{{--                <small>{{ $params['page_des'] ?? '' }}</small>--}}
{{--            </h1>--}}
{{--            <ol class="breadcrumb">--}}
{{--                @if(isset($breadcrumbs) && sizeof($breadcrumbs) > 0)--}}
{{--                    @foreach($breadcrumbs as $bc)--}}
{{--                        <li class="{{ $bc['class'] }}"><a href="{{ $bc['href'] }}"><i class="fa fa-dashboard"></i> Level</a></li>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            </ol>--}}
{{--        </section>--}}

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-sm-left">
                                @yield('headerText')
                            </div>
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i>&nbsp;Home</a></li>
                                @yield('breadcrumbs')
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('admin.layouts.footer')

</div><!-- ./wrapper -->

<!-- jQuery 3.5.1 -->
<script src="https://assets.codiksh.in/storage/media/assets/16/jquery.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/17/moment.min.js"></script>
<script src="https://assets.codiksh.in/storage/media/assets/18/popper.min.js"></script>
<!-- Bootstrap 4.0.0 -->
<script src="https://assets.codiksh.in/storage/media/assets/15/bootstrap.min.js"></script>
<!-- Date Range Picker -->
<script src="https://assets.codiksh.in/storage/media/assets/14/daterangepicker.js"></script>

{{--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>--}}
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
<script  src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
<script defer>
    $.ajaxSetup({headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }});
    if($(window).width() >= 992 && $(window).width() < 1450) {
        $('html').css('zoom', '85%');
        $(window).on('load',function(){
            $('.content-wrapper').css('min-height', $(window).height() + $('.main-header').height() - 15);
            $('div.wrapper').css('position', 'inherit');
        })
    }else{
        $('body').addClass('fixed layout-fixed');
        $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css" type="text/css" />');
        $('<script />', { type : 'text/javascript', src : 'https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/jquery.overlayScrollbars.min.js'}).appendTo('head');
    }
</script>
@include('admin.layouts.inits.master')
@include('layouts.helpers')

@yield('scripts')

@stack('stackedScripts')
</body>
</html>
