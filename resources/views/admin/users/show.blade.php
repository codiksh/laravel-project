@extends('admin.layouts.master')

@section('title')
    Show User - {{ env('APP_NAME') }}
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header bg-info">
                            <h3>View User {{ $user->name ? (' - '.$user->name) : '' }}</h3>
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
