@extends('admin.layouts.master')

@section('title')
    Users - {{ config('app.name') }}
@endsection

@section('page_headers')
    <h3><i class="fa-duotone fa-cog mr-2"></i>User Tokens</h3>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">User Tokens</li>
@endsection

@section('page_buttons')
    <a class="btn btn-primary" onclick="ajaxCallTokenGenerate('{{ route('admin.userTokens.generate',request()->route('user')) }} ', 'userToken-index')"><i class="fa-solid fa-plus"></i>Add Token</a>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            @include('flash::message')
                            <div class="token_alert">

                            </div>
                            @include('admin.tokens.table')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('stackedScripts')
    <script>
        function ajaxCallTokenGenerate(url, tableId) {
            $.ajax({
                url:url,
                method:"POST",
                beforeSend: function () {
                    $('#ajax_alert_div').html('');
                    showWaitMeLoading('Fetching details...', '', $('.content-wrapper'));
                },
                success: function (res) {
                    result = res;
                    hideWaitMeLoading('', $('.content-wrapper'));
                    $('.token_alert').html('<div class="alert alert-success alert-dismissible pt-4 pb-4" role="alert">'+
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>\n' +
                        '  </button>'+
                        '<h3>Success!</h3>'+
                        '<div class="pt-4">Token is generated successfully.</div>'+
                        '<div class="text-white">'+res.token+'</div>'+
                        '</div>');
                    LaravelDataTables[tableId].ajax.reload(null, false);
                },
                error: function (jqXHR) {
                    result = {status: jqXHR.status, message: JSON.parse(jqXHR.responseText).message};
                    hideWaitMeLoading('', $('.content-wrapper'));
                    toastr["error"](result.message);
                }
            });
        }
    </script>
@endpush


