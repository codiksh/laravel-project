@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create User</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! html()->form('POST', route('users.store'))->open() !!}

                <div class="card-body">
                    <div class="row">
                        @include('users.fields')
                    </div>
                </div>

                <div class="card-footer">
                    {!! html()->submit('Save')->class('btn btn-primary') !!}
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                </div>

            {!! html()->form()->close() !!}

        </div>
    </div>
@endsection
