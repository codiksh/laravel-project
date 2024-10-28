
<!-- Images -->
<div class="mImagesMainDiv {{ $colCass ?? 'col-sm-12' }}">
    <label class="form-label" for="mImagesDiv_for">
        {!! $label ?? 'Images' !!}
    </label>
    <div class="mImagesContainer">
        <div class='mImagesPlaceholderDiv'>
            <div class='mImagesPlaceholderText text-center'>
                {!! $placeholderText ?? "Select Pictures<br/>(Single File max size: 1MB, Total files max size: 10MB)" !!}
            </div>
        </div>
        <div class="carousel-fade m3 mImagesPreview d-none" data-ride="carousel">
            <div class="col-md-12">
                <div class="row clearfix">
                    <div class="col-md-6" style="padding: 20px;">
                        <button class="float-left btn btn-default" type="button" onclick="changeMImages($(this))">
                            <i class="ionicons ion-edit"></i> CHANGE
                        </button>
                    </div>
                    <div class="col-md-6" style="padding: 20px;">
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-default prev" title="go back"><i class="fas fa-lg fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-default next" title="more"><i class="fas fa-lg fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="carouselInner" class="carousel-inner" style="padding: 0px 20px;">
                {{-- Templated Cards will come here from script at common/images.blade.php --}}
            </div>
        </div>
        <input type="file" name="{{ $inputName ?? 'images[]' }}"
               class="mImagesUploadFile img" style="width: 0px;height: 0px;overflow: hidden;" onchange="previewMImages($(this));" multiple max-size={{ $maxInputSize ?? 10485760 }}
        >
        {!! html()->hidden($primaryImageInputName ?? 'primaryImage', null)->class('primaryImage') !!}
    </div>
</div>
