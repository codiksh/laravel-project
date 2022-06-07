<meta charset="UTF-8">
<title>@yield('title', config('app.name'))</title>

<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<meta name="_token" content="{!! csrf_token() !!}"/>
<link rel="stylesheet" href="{{ asset('css/fa/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/fa/css/solid.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/fa/css/duotone.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/select2_4.0.13/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/laravel_project.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<link rel="stylesheet" href="{{ asset('css/ntb.css') }}">


@yield('css')
@stack('stackedCss')
