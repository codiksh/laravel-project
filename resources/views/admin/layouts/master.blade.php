<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.head')
</head>
<body class="sidebar-mini hold-transition accent-primary sidebar-collapse fixed layout-fixed" >
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('icon.jpg') }}" alt="{{ config('app.name') }}'s Logo" height="60" width="60">
    </div>
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

<script src="{{ asset('assets/jquery_3.5.1/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('assets/moment_2.15.1/moment.min.js') }}"></script>
<script src="{{ asset('assets/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap_4.0.0/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/daterangepicker_3.0.5/js/daterangepicker.js') }}"></script>
{{--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>--}}
<script src="{{ asset('assets/slimscroll_1.3.8/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/icheck_1.0.2/icheck.min.js') }}"></script>
<script src="{{ asset('assets/select2_4.0.13/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/waitMe_1.15/js/waitMe.min.js') }}"></script>
<script src="{{ asset('assets/sweetalert2/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/qubit/jquery.qubit.js') }}"></script>
<script src="{{ asset('assets/jquery_bonsai/js/jquery.bonsai.js') }}"></script>
<script src="{{ asset('assets/timepicker/js/jquery.timepicker.js') }}"></script>
<script src="{{ asset('assets/url_slug/url_slug.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script defer>
    $.ajaxSetup({headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }});
</script>
@include('admin.layouts.inits.master')
@include('layouts.helpers')

@yield('scripts')

@stack('stackedScripts')
</body>
</html>
