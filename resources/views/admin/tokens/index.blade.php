@extends('admin.layouts.master')

@section('title')
    Users - {{ config('app.name') }}
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">User Tokens</li>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="float-left mt-1">Users Token</h3>
                            <h3 class="float-sm-right">
                                <a class="btn btn-primary btn-sm mb-1" onclick="ajaxCallTokenGenerate('{{ route('admin.userTokens.generate',request()->route('user')) }} ', 'userToken-index')">Add New</a>
                            </h3>
                        </div>

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


