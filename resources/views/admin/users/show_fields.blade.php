<!-- Id Field -->
<div class="form-group">
    {!! html()->label('Id:')->for('id') !!}
    <p>{{ $user->id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! html()->label('Name:')->for('name') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! html()->label('Email:')->for('email') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Mobile Field -->
<div class="form-group">
    {!! html()->label('Mobile:')->for('mobile') !!}
    <p>{{ $user->mobile }}</p>
</div>

<!-- Short Bio Field -->
<div class="form-group">
    {!! html()->label('Short Bio:')->for('short_bio') !!}
    <p>{{ $user->short_bio }}</p>
</div>

<!-- Facebook Url Field -->
<div class="form-group">
    {!! html()->label('Facebook Url:')->for('facebook_url') !!}
    <p>{{ $user->facebook_url }}</p>
</div>

<!-- Twitter Url Field -->
<div class="form-group">
    {!! html()->label('Twitter Url:')->for('twitter_url') !!}
    <p>{{ $user->twitter_url }}</p>
</div>

<!-- Linkedin Url Field -->
<div class="form-group">
    {!! html()->label('Linkedin Url:')->for('linkedin_url') !!}
    <p>{{ $user->linkedin_url }}</p>
</div>

<!-- Youtube Url Field -->
<div class="form-group">
    {!! html()->label('Youtube Url:')->for('youtube_url') !!}
    <p>{{ $user->youtube_url }}</p>
</div>

<!-- Instagram Url Field -->
<div class="form-group">
    {!! html()->label('Instagram Url:')->for('instagram_url') !!}
    <p>{{ $user->instagram_url }}</p>
</div>

<!-- Pinterest Url Field -->
<div class="form-group">
    {!! html()->label('Pinterest Url:')->for('pinterest_url') !!}
    <p>{{ $user->pinterest_url }}</p>
</div>

<!-- Uuid Field -->
<div class="form-group">
    {!! html()->label('Uuid:')->for('uuid') !!}
    <p>{{ $user->uuid }}</p>
</div>
