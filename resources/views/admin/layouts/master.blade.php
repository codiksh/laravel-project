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
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <!-- Ionicons -->
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}

    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/animate.css/animate.min.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/toastr/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/bower_components/waitme/waitMe.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/sweetalert2/dist/sweetalert2.min.css') }}">
    <!-- Jquery Bonsai -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jquery-bonsai/jquery.bonsai.css') }}">
    <!-- Jquery Time picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jquery-timepicker-wvega/jquery.timepicker.css') }}">
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css">

    <!-- NTB CSS -->
    <link rel="stylesheet" href="{{ asset('css/ntb.css') }}">

    @yield('css')
    @stack('stackedCss')
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
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i>&nbsp;Home</a></li>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Bootstrap 4.0.0 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Date Range Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>

{{--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('/assets/bower_components/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/assets/bower_components/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/assets/bower_components/waitme/waitMe.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/assets/bower_components/jquery-qubit/jquery.qubit.js') }}"></script>
<script src="{{ asset('/assets/bower_components/jquery-bonsai/jquery.bonsai.js') }}"></script>
<script src="{{ asset('/assets/bower_components/jquery-timepicker-wvega/jquery.timepicker.js') }}"></script>
<script src="{{ asset('/js/url_slug.js') }}"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>
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
