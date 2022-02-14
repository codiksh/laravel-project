<div class="col-sm-9">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-8">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name of the user']) !!}
        </div>
        <!-- Roles Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('role', 'Role:') !!}
            {!! Form::select('role[]', $roleItems, null, ['class' => 'form-control select2-multiple', 'data-placeholder' => 'Define user roles', 'multiple' => 'multiple', 'id' => 'role']) !!}
        </div>
        <!-- Email Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email of the user']) !!}
        </div>
        <!-- Mobile Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('mobile', 'Mobile:') !!}
                {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => 'Mobile of the user']) !!}
        </div>
        <!-- Password Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('password', 'Password:') !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password of the user']) !!}
        </div>
    </div>
</div>

@include('admin.layouts.scripts.dzSingleImageField', [
    'record' => isset($user) ? $user : '',
    'previewUrl' => isset($user) ? $user->avatarUrl['250'] : route('images_default',['resolution' => '250x250']),
    'mediaUuid' => isset($user) ? $user->getFirstMedia('avatar')->uuid ?? '' : '',
    'fieldName' => 'avatar',
    'elementId' => 'user_avatar',
    'placeHolderText' => "Drop/Select User Avatar<br/>(Max: 1 MB)"
])

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-success rspSuccessBtns']) !!}
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
</div>

@push('stackedScripts')
    @include('admin.layouts.scripts.regAnotherScript')
    @include('admin.layouts.scripts.swalAjax')

    <script>
        Dropzone.autoDiscover = false;
        uploadImageByDropzone('#user_avatar');
    </script>

    <script>
        $('.submitsByAjax').submit(function (e) {
            e.preventDefault();
            let type = '{{ $type ?? '' }}'
            let dataToPass = new FormData($(this)[0]);
            ajaxCallFormSubmit($(this), false, 'Loading! Please wait...', dataToPass,
                type === 'create' ? postCreate : undefined);
        });

        function postCreate(){
            switch_between_register_to_registerAnother_btn($('.submitsByAjax'), false)
        }
    </script>

@endpush
