@extends('admin.layouts.adminlte.master')

@section('title')
    Manage Permissions for {{ request()->route('role')->name }}  - {{ config('app.name') }}
@endsection

@section('page_headers')
    <h3><i class="fa-duotone fa-user-lock mr-2"></i>Roles</h3>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Manage Permissions</li>
@endsection

@section('page_buttons')
    <a class="btn btn-primary" href="{{ route('admin.users.create') }}"><i class="fa-solid fa-plus"></i> Add Roles</a>
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
                                    <h3>Manage Permissions for {{ request()->route('role')->name }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {!! Form::open(['route' => ['admin.roles.permissions.manage.update', $role->name],  'files' => true, 'id' => 'permission-form', 'class' => 'submitsByAjax']) !!}
                            @csrf
                            <div class="col-sm-12">
                                @php $roleName = str_replace(' ', '-', $role->name) @endphp
                                <a href="javascript:void(0);" id="{{ $roleName }}_ec_id"
                                   onclick=expandCollapseHierarchy('{{ $roleName }}')>Expand All</a>
                                <ol id="{{ $roleName }}_ol_id" class="bonsai bonsaiHierarchy pt-2">
                                    @foreach($allPermissions as $group => $groupedPermissions)
                                        <li data-value="{{ $group }}">
                                            <div class="custom-checkbox custom-control">
                                                <input id="{{ $group }}_id" type="checkbox"
                                                       class="custom-control-input"
                                                       name="'{{ $group }}" value="{{ $group }}">
                                                <label for="{{ $group }}_id" class="custom-control-label">
                                                    <b>{{ Str::title(str_replace('_', ' ', $group)) }}</b>
                                                </label>
                                            </div>
                                            <ol>
                                                @foreach($groupedPermissions as $permission)
                                                    <li class="expanded" data-value="{{ $permission->id }}">
                                                        <div
                                                                class="custom-checkbox custom-control custom-control-inline">
                                                            <input id="chkBx_permission_{{ $permission->id }}"
                                                                   type="checkbox" class="custom-control-input"
                                                                   name="{{ $roleName }}[]"
                                                                   value="{{ $permission->id }}" {{ in_array($permission->id,$selectedPermissions) ? 'checked' : '' }}>
                                                            <label for="chkBx_permission_{{ $permission->id }}"
                                                                   class="custom-control-label">
                                                                {{ $permission->label }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </li>
                                        {{--<li>{{ Str::title(implode(' ', preg_split('/(?=[A-Z])/', $group))) }}</li>--}}
                                    @endforeach
                                </ol>
                            </div>
                            <button class="btn btn-primary rspSuccessBtns mt-4">Update Permission</button>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('stackedScripts')
    @include('admin.layouts.adminlte.scripts.regAnotherScript')
    @include('admin.layouts.adminlte.scripts.swalAjax')
    <script>
        $('.submitsByAjax').submit(function (e) {
            e.preventDefault();
            let type = 'edit'
            let dataToPass = new FormData($(this)[0]);
            ajaxCallFormSubmit($(this), false, 'Loading! Please wait...', dataToPass);
        });
    </script>
@endpush
