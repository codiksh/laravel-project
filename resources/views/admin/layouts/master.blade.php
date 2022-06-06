<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.head')
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

<script defer>
    $.ajaxSetup({headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }});
</script>
@include('admin.layouts.inits.master')
@include('layouts.helpers')

@yield('scripts')

@stack('stackedScripts')
</body>
</html>
