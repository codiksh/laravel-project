@extends('admin.layouts.master')

@section('title')
    Change Password
@endsection

@section('page_headers')
    <h3><i class="fa-duotone fa-key mr-2"></i>Change Password</h3>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Change Password</li>
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
                                    <h4>{{ request()->route('user')->name }}</h4>
                                </div>
                                <div class="d-flex align-items-center action_button">
                                    @include('admin.users.datatables_actions', ['uuid' => request()->route('user')->uuid])
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @include('adminlte-templates::common.errors')
                            {!! html()->form()
                               ->action(route('admin.users.changePassword.process', request()->route('user')))
                               ->method('POST')
                               ->attributes(['enctype' => 'multipart/form-data', 'class' => 'submitsByAjax'])
                               ->open()
                           !!}
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    {!! html()->label('New Password:', 'new_password') !!}
                                    {!! html()->password('new_password')->class('form-control')->placeholder('Password of the user')->attribute('autocomplete', 'off') !!}
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! html()->label('Confirm Password:', 'confirm_password') !!}
                                    {!! html()->password('confirm_password')->class('form-control')->placeholder('Confirm password of the user')->attribute('autocomplete', 'off') !!}
                                </div>
                            </div>

                            <!-- Submit Field -->
                            <div class="form-group col-md-12 fields_footer_action_buttons">
                                <button class="btn btn-lg btn-success" type="submit" ><i class="fa-duotone fa-floppy-disk"></i> Save</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-lg btn-outline-danger"><i class="fa-duotone fa-arrow-left-to-line"></i> Back</a>
                            </div>

                        </div>

                        {!! html()->form()->close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stackedScripts')
    <script>
        $('.submitsByAjax').submit(function (e) {
            e.preventDefault();
            let type = '{{ $type ?? '' }}'
            let dataToPass = new FormData($(this)[0]);
            ajaxCallFormSubmit($(this), false, 'Loading! Please wait...', dataToPass,
                type === 'edit' ? postCreate : undefined);
        });
    </script>
@endpush
