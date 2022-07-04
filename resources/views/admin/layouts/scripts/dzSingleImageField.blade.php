<div class="{{ !empty($className) ? $className : 'col-sm-3' }} dz-sImageOuterContainer">
    <div class="dz-sImageContainer mayContainError fastAnimation dropzone dz-clickable avatar-upload" id="{{$elementId}}" tabindex="1">
        <div class="single-image-upload dz-clickable {{ !empty($hasMedia) && $hasMedia ? 'd-none' : '' }}">
            <div class='dz-sImagePlaceholderText text-center'>
                {!! empty($placeHolderText) ? 'Drop/Select Avatar here <br/>(Max: 1 MB)' : $placeHolderText !!}
            </div>
        </div>
        <div class="preview-container"></div>
        @if(!empty($hasMedia) && $hasMedia)
            <div class='dz-sImagePreview'>
                <img class='dz-sImagePreviewImg' alt='Avatar'
                     src='{{ $previewUrl }}'
                />
                <div class='dz_sImage_Overlay'>
                    <a href='javascript:void(0);' class='icon dz-removeSImageBtn' title='Avatar'
                       onclick='removeUploadedSImage("{{$mediaUuid}}", "Are you sure?", $("#{{$elementId}}"))'>
                        <i class='fa fa-trash'></i>
                    </a>
                </div>
            </div>
        @endif
        <input type="hidden" name="{{ $fieldName }}" class="uploaded-media">
        <input type="hidden" name="{{ $fieldName }}Deleted" value="0" class="deleted-media">
    </div>
</div>
