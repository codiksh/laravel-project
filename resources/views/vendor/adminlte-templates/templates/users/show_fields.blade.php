<!-- Name Field -->
<div class="col-sm-12">
    {!! html()->label('Name:')->for('name') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! html()->label('Email:')->for('email') !!}
    <p>{!! $user->email !!}</p>
</div>
