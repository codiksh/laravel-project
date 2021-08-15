@extends('admin.layouts.master')

@section('title')
    Users - {{ env('APP_NAME') }}
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
                                <a class="btn btn-primary btn-sm mb-1" onclick="ajaxCallTokenGenerate('{{ route('admin.userTokens.generate',request()->route('user')) }} ')">Add New</a>
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

