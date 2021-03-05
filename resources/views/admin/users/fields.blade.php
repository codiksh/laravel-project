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
<div class="sImageOuterContainer col-sm-3">
    <div id="sImageContainer_id" class='sImageContainer mayContainError fastAnimation' tabindex='1'>
        <div class='sImagePlaceholderDiv {{ isset($user) ? 'd-none' : '' }}'>
            <div class='sImagePlaceholderText text-center'>
                Select User Avatar<br/>(Max: 1 MB)
            </div>
        </div>
        <div class='sImagePreview {{ isset($user) ? '' : 'd-none' }}'>
            <img id='sImagePreview_id' class='sImagePreviewImg' alt='Avatar'
                 src='{{ isset($user) ? $user->avatarUrl['250'] : route('images_default',['resolution' => '250x250']) }}'
            />
            <div class='sImage_Overlay'>
                <a href='#' class='icon removeSImageBtn' title='Avatar'>
                    <i class='fa fa-trash'></i>
                </a>
            </div>
        </div>
    </div>
    <input type="file" name="avatar" id="sImage_id"
           class="uploadFile img" value="Upload Photo"
           style="width: 0px;height: 0px;overflow: hidden;" max-size=1048576 data-sImageDeletedInputName="avatarDeleted"
           onchange=previewImg(this);
    >
    <input type="hidden" name="avatarDeleted" value="0">
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
</div>


