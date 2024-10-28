@extends('admin.layouts.master')

@section('title')
    Create Role - {{ config('app.name') }}
@endsection

@section('page_headers')
    <h3><i class="fa-duotone fa-user-lock mr-2"></i>Roles</h3>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            @include('adminlte-templates::common.errors')
                            {!! html()->form('POST', route('admin.roles.store'))
                                ->attribute('enctype', 'multipart/form-data')
                                ->class('submitsByAjax')
                                ->open() !!}

                                <div class="row">
                                    @include('admin.roles.fields', ['type' => 'create'])
                                </div>

                                {!! html()->form()->close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
