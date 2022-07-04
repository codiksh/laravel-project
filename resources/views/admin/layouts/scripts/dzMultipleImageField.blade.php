<div class="row mt-2">
    <div class="col-sm-12">
        <div>
            @if(!empty($noLabel) && !$noLabel)
            <label class="form-label" for="mImagesDiv_for">
                {!! $label ?? 'Images' !!}
            </label>
            @endif
        </div>
        <div class="dz-mImagesContainer">
            <div class="dropzone dz-mImage-upload" id="{{$elementId}}">
                <div class="multipleImage dz-clickable">
                    <div class="dz-mImagesPlaceholderText text-center">
                        {!! $placeholderText ?? "Select Pictures<br/>(Single File max size: 1MB, Total files max size: 10MB)" !!}
                    </div>
                </div>
                <div class="preview-container"></div>
            </div>
            <div class="uploaded_image"></div>
            {!! Form::hidden($primaryImageInputName ?? 'primaryImage',null,['class' => 'primaryImage']) !!}
        </div>
    </div>
</div>
