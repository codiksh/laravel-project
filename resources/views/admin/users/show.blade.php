@extends('admin.layouts.master')

@section('title')
    Show User - {{ config('app.name') }}
@endsection

@section('page_headers')
    <h3><i class="fa-duotone fa-users mr-2"></i>Users</h3>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('page_buttons')
    <a class="btn btn-primary" href="{{ route('admin.users.create') }}"><i class="fa-solid fa-plus"></i> Add Users</a>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between ">
                                <div class="d-flex align-items-center">
                                    <h4>{{ $user->name }}</h4>
                                </div>
                                <div class="d-flex align-items-center action_button">
                                    @include('admin.users.datatables_actions', ['uuid' => $user->uuid])
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="showuser">
                                {!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'patch',  'files' => true]) !!}
                                <div class="row">
                                    @include('admin.users.fields')
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('stackedScripts')
<script>
    disableInputsForView($('#showuser'));
</script>
@endpush
