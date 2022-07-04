<script>
    let uploadedFileAttachmentPath = {};
    let dropzoneFileInitObject = {};
    var fileDropzoneElement = {};
    var dropzoneContainer = $('.uploadFileContainer');

    function uploadAttachmentByDropzone(selectedElement, inputFieldName = 'attachments[]', maxFiles = 500, validationCase = '') {
        var previewNode = document.querySelector("#"+selectedElement+" .file-preview");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        Dropzone.autoDiscover = false;
        fileDropzoneElement[selectedElement] = $('#'+selectedElement);
        dropzoneFileInitObject[selectedElement] = new Dropzone('#'+selectedElement, {
            url: '{{ route('file.upload') }}',
            maxFiles: maxFiles,
            addRemoveLinks: true,
            previewTemplate: previewTemplate,
            previewsContainer: '#'+selectedElement+" #previews",
            clickable: '#'+selectedElement+" .dz-fileAttachmentPlaceHolder",
            dictDefaultMessage: "",
            autoProcessQueue: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function () {

                this.on("addedfile", function(file) {
                    if(maxFiles === 1){
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    }
                    $('.preview-container').css('visibility', 'visible');
                });

                this.on("totaluploadprogress", function (progress) {
                    var progr = document.querySelector(".progress .determinate");
                    if (progr === undefined || progr === null)
                        return;

                    progr.style.width = progress + "%";
                });

                this.on("processing", function (file) {
                    fileDropzoneElement[selectedElement].find('.dz-fileAttachmentPlaceHolder').addClass('pt-5 pb-5');
                    fileDropzoneElement[selectedElement].parents('form').find('input[type="submit"]').attr('disabled','disabled')
                    fileDropzoneElement[selectedElement].parents('form').find('button[type="submit"]').attr('disabled','disabled')
                });

                this.on("sending", function (file, xhr, formData) {
                    if(! Array.isArray(uploadedFileAttachmentPath[selectedElement])){
                        uploadedFileAttachmentPath[selectedElement] = [];
                    }
                    uploadedFileAttachmentPath[selectedElement].push(file);
                    formData.append('validationCase', validationCase);
                });

                this.on('success', function(file, response){
                    file.serverId = response.uploaded_media_id;
                    file.previewElement.id = "document-" + file.serverId;

                    let uploadedFilePreviewElement = $("#document-" + file.serverId);
                    var mediaUuid = response.uploaded_media_id;
                    uploadedFilePreviewElement.append('<input type="hidden" name="'+inputFieldName+'" value="' + mediaUuid + '" class="dz-uploadFile" >');
                    fileDropzoneElement[selectedElement].parents('form').find('input[type="submit"]').removeAttr('disabled');
                    fileDropzoneElement[selectedElement].parents('form').find('button[type="submit"]').removeAttr('disabled');
                });

                this.on("error", function(file, response, xhr){
                    var res = response.errors;
                    toastr["error"](res['file']);
                    file.previewElement.remove();
                    changeDropzoneBoxDesign(fileDropzoneElement[selectedElement]);
                    return false;

                });
            },
            removedfile: function (file) {
                var mediaUuid = $("#document-" + file.serverId).find('.dz-uploadFile').val();
                removeUploadedFile(mediaUuid, "Are you sure?", file, '',fileDropzoneElement[selectedElement]);
            },
        });
    }

    $(document).on('click', '.remove_file', function(){
        let mediaUuid = $(this).data('uuid');
        removeUploadedFile(mediaUuid, "Are you sure?", '', $(this));
    })

    function removeUploadedFile(uuid, confirmMsg, file = '', selectedRemoveElement = '', selectedDropzoneElement = '') {
        if (confirm(confirmMsg)) {
            $.ajax({
                type: 'POST',
                url: '{{ route('file.remove') }}',
                data: {mediaUuid: uuid},
                success: function (data) {
                    if (file !== '') {
                        file.previewElement.remove();
                    }
                    changeDropzoneBoxDesign(selectedDropzoneElement);
                }
            });
        }
    }

    function changeDropzoneBoxDesign(element){
        if (element !== '' && element.find('div.file-preview').length === 0) {
            element.find('div.dz-fileAttachmentPlaceHolder').removeClass('pt-5 pb-5');
        }
    }

    function reUploadDzAttachmentFile(){
        $.each(dropzoneFileInitObject, function (key, dzObject) {
            $.each(uploadedFileAttachmentPath[key], function(fileIndex, file){
                file.status = Dropzone.ADDED;
                dzObject.enqueueFile(file);
            })
        });
    }
</script>
