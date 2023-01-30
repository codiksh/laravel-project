@extends('admin.layouts.master')

@section('title')
    Roles - {{ config('app.name') }}
@endsection

@section('page_headers')
    <h3><i class="fa-duotone fa-user-lock mr-2"></i>Roles</h3>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('page_buttons')
    <a class="btn btn-primary" href="{{ route('admin.roles.create') }}"><i class="fa-solid fa-plus"></i> Add Roles</a>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @include('flash::message')
                            @include('admin.roles.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

