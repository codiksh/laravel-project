<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Name')->for('name') !!}
    {!! html()->text('name')->class('form-control') !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Email')->for('email') !!}
    {!! html()->email('email')->class('form-control') !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Password')->for('password') !!}
    {!! html()->password('password')->class('form-control') !!}
</div>

<!-- Confirmation Password Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Password Confirmation')->for('password_confirmation') !!}
    {!! html()->password('password_confirmation')->class('form-control') !!}
</div>
