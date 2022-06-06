<script>
    let uploadedFilePath = undefined;
    let dropzoneInitObject;
    function uploadImageByDropzone(selectedElementId, validationCase = '') {
        Dropzone.autoDiscover = false;
        let dropzoneElement = $(selectedElementId);
        dropzoneInitObject = new Dropzone(selectedElementId, {
            url: '{{ route('file.upload') }}',
            acceptedFiles: ".jpeg, .jpg, .png, .gif, .mp4,.mov",
            addRemoveLinks: true,
            uploadMultiple: false,
            parallelUploads: 1,
            previewsContainer: selectedElementId+" div.preview-container",
            clickable: selectedElementId+" .single-image-upload",
            dictCancelUpload: "",
            dictCancelUploadConfirmation : false,
            maxFiles: 1,
            thumbnailWidth: 230,
            thumbnailHeight: 230,
            thumbnailMethod: "contain",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });

                this.on("complete", function (file) {
                    dropzoneElement.find('.dz-preview').find('.dz-remove').html('<i class="fa fa-trash"></i>');
                    dropzoneElement.find('.dz-preview').find('.dz-remove').addClass('dz-removeSImageBtn');
                    dropzoneElement.find('.dz-image').append('<div class="imageOverlay"></div>');
                });

                this.on("processing", function (file) {
                    dropzoneElement.find('div.single-image-upload').addClass('d-none')
                });

                this.on("sending", function (file, xhr, formData) {
                    uploadedFilePath = file;
                    formData.append('validationCase', validationCase);
                });

            },
            removedfile: function(file)
            {
                var mediaUuid = $('input[name="uploaded_media_uuid"]').val();
                removeUploadedSImage(mediaUuid, "Are you sure?", dropzoneElement, file);
            },
            success: function (file, response) {
                dropzoneElement.find('.uploaded-media').val(response.uploaded_media_id);
                dropzoneElement.find('.deleted-media').val(0);
            },
            error: function (file, response) {
                var res = response.errors;
                toastr["error"](res['file']);
                file.previewElement.remove();
                dropzoneElement.find('div.single-image-upload').removeClass('d-none')
                return false;
            }
        });
    }

    function removeUploadedSImage(uuid, confirmMsg, dropzoneElement, file = ''){
        if (confirm(confirmMsg)) {
            let result;
            $.ajax({
                type: 'POST',
                url: '{{ route('file.remove') }}',
                data: {mediaUuid: uuid},
                success: function (data) {
                    dropzoneElement.find('div.single-image-upload').removeClass('d-none')
                    dropzoneElement.find('.uploaded-media').val('');
                    dropzoneElement.find('.deleted-media').val(1);
                    if(file != '') {
                        file.previewElement.remove();
                    }
                }
            });
        }
    }

    $('a.dz-removeSImageBtn').click(function(e) {
        e.preventDefault();
        removeExistingSImage($(this));
    });
    function removeExistingSImage(removeRef){
        let sImageOuterContainer = removeRef.parents('div.dz-sImageOuterContainer');
        sImageOuterContainer.find('div.dz-sImagePreview')
            .animateCss('bounceOut').on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).addClass("d-none");
        });
        sImageOuterContainer.find('div.single-image-upload')
            .animateCss('fadeIn')
            .removeClass("d-none")
            .on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
                $(this).removeClass("d-none");
            });
        sImageOuterContainer.find('img.dz-sImagePreviewImg').attr('src', '{{ route('images_default',['resolution' => '250x250']) }}');
    }
    function reUploadDzFile(){
        uploadedFilePath.status = Dropzone.ADDED
        dropzoneInitObject.enqueueFile(uploadedFilePath)
    }
</script>
