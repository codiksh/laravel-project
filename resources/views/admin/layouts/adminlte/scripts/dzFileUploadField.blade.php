<label class="form-label" for="attachment_for">
    {!! $label ?? 'Attachment:' !!}
</label>
<div class="uploadFileContainer">
    <div class="dropzone dz-file-attachment text-center" id="{{ $elementId }}" tabindex="1">
        <div class="dz-clickable dz-fileAttachmentPlaceHolder">
            <i>{{ $placeHolderText ?? 'Upload Attachment here' }}</i>
        </div>
        <div class="preview-container">
            <div class="" id="previews">
                <div class="file-preview clearhack valign-wrapper item-template row mb-2">
                    <div class="col-md-11 pv zdrop-info pl-5" data-dz-thumbnail>
                        <div class="text-left">
                            <span data-dz-name></span> (<span data-dz-size></span>)
                        </div>
                        <div class="progress">
                            <div class="determinate" style="width:0" data-dz-uploadprogress></div>
                        </div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                    </div>
                    <div class="col-md-1 text-left deleteFileBtn" style="cursor: pointer;" data-dz-remove>
                        <img class="deleteFileIconImg" src="{{ asset('/images/close.png') }}" width="20" ondragstart="return false;" style="margin-top:9px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($record) && $record->hasMedia($collectionName))
    <div class="form-group col-sm-12">
        <i>Existing Attachments: </i>
        <table id="{{ $tableId }}" class="table existingFilesList">
            <tbody>
            </tbody>
        </table>
    </div>
    @endif
</div>
