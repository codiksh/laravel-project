<script>
    function uploadImageByDropzone(selectedElementId) {
        let dropzoneElement = $(selectedElementId);
        $(selectedElementId).dropzone({
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
            },
            removedfile: function(file)
            {
                var mediaUuid = $('input[name="uploaded_media_uuid"]').val();
                removeUploadedImage(mediaUuid, "Are you sure?", dropzoneElement, file);
            },
            success: function (file, response) {
                // changing src of preview element
                var fileReader = new FileReader();
                if (file.type.match('image')) {
                    fileReader.onload = function(e) {
                        file.previewElement.querySelector("img").src = e.target.result;
                    };
                    fileReader.readAsDataURL(file);
                } else {
                    fileReader.onload = function() {
                        var blob = new Blob([fileReader.result], {type: file.type});
                        var url = URL.createObjectURL(blob);
                        var video = document.createElement('video');
                        var timeupdate = function() {
                            if (snapImage()) {
                                video.removeEventListener('timeupdate', timeupdate);
                                video.pause();
                            }
                        };
                        video.addEventListener('loadeddata', function() {
                            if (snapImage()) {
                                video.removeEventListener('timeupdate', timeupdate);
                            }
                        });
                        var snapImage = function() {
                            var canvas = document.createElement('canvas');
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;
                            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                            var image = canvas.toDataURL();
                            var success = image.length > 100000;
                            if (success) {
                                file.previewElement.querySelector("img").src = image;
                                URL.revokeObjectURL(url);
                            }
                            return success;
                        };
                        video.addEventListener('timeupdate', timeupdate);
                        video.preload = 'metadata';
                        video.src = url;
                        // Load video in Safari / IE11
                        video.muted = true;
                        video.playsInline = true;
                        video.play();
                    };
                    fileReader.readAsArrayBuffer(file);
                }
                dropzoneElement.find('.uploaded-media').val(response.uploaded_media_id);
                dropzoneElement.find('.deleted-media').val(0);
            },
        });
    }

    function removeUploadedImage(uuid, confirmMsg, dropzoneElement, file = ''){
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
        removeSImage($(this));
    });
    function removeSImage(removeRef){
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
</script>
