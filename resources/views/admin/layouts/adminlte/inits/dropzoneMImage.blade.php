<script class="imageTemplate_forExisting" type="text/template">
    <div class="col-md-3 dz-mImageThumbnail" style="margin-bottom:16px;" align="center">
        <img src="{{ route('images_default',['resolution' => '250x250']) }}" class="" />
        <div class="mt-2">
            <a class="btn btn btn-danger remove_image">✖</a>
            <a class="btn btn btn-primary make_primary">Make Primary</a>
        </div>

    </div>
</script>
<script>
    let uploadedMultipleFilePath = {};
    let dropzoneMultipleInitObject = {};
    var multipleDropzoneElement = {};
    var multipleImageContainer = $('.dz-mImagesContainer');

    function uploadMultipleImageByDropzone(selectedElement, inputFieldName = 'images[]', validationCase = '', primaryImageEnabled = true,
                                           url = "{{ route('file.upload') }}", additionalDataToPass = undefined) {
        Dropzone.autoDiscover = false;
        multipleDropzoneElement[selectedElement] = $('#'+selectedElement);
        multipleDropzoneElement[selectedElement].find('div.dz-mImagesPlaceholderText').removeClass('d-none')

        dropzoneMultipleInitObject[selectedElement] = new Dropzone('#'+selectedElement, {
            url: url,
            acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg, .mp4,.mov",
            clickable: '#'+selectedElement+" div.multipleImage",
            previewsContainer: '#'+selectedElement+" div.preview-container",
            addRemoveLinks: true,
            parallelUploads: 20,
            dictRemoveFile: 'Remove',
            autoProcessQueue: true,
            dictDefaultMessage: "",
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            thumbnailMethod: "contain",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init:function() {
                myDropzone = this;
                myDropzone.processQueue();

                this.on("processing", function (file) {
                    multipleDropzoneElement[selectedElement].find('div.dz-mImagesPlaceholderText').addClass('d-none');
                    multipleDropzoneElement[selectedElement].find('.dz-remove').addClass('btn btn-danger text-white');
                    multipleDropzoneElement[selectedElement].parents('form').find('input[type="submit"]').attr('disabled','disabled')
                    multipleDropzoneElement[selectedElement].parents('form').find('button[type="submit"]').attr('disabled','disabled')
                });

                this.on("sending", function (file, xhr, formData) {
                    if(! Array.isArray(uploadedMultipleFilePath[selectedElement])){
                        uploadedMultipleFilePath[selectedElement] = [];
                    }
                    uploadedMultipleFilePath[selectedElement].push(file);
                    formData.append('validationCase', validationCase);
                    if(additionalDataToPass !== undefined){
                        let additional_data = additionalDataToPass.serializeArray();
                        $.each(additionalDataToPass, function(key, value){
                            formData.append(key, value)
                        });
                    }
                });
                this.on("complete", function (file) {
                    multipleDropzoneElement[selectedElement].find('.dz-preview .dz-remove').html('<i class="fa fa-trash"></i>');
                    multipleDropzoneElement[selectedElement].find('.dz-preview .dz-remove').attr('title', 'remove image')
                });

                this.on("success", function(file, response) {
                    file.serverId = response.media_id;
                    file.previewElement.id = "document-" + file.serverId;

                    let uploadedImagePreviewElement = $("#document-" + file.serverId);
                    var mediaUuid = response.uploaded_media_id;
                    uploadedImagePreviewElement.append('<input type="hidden" name="'+inputFieldName+'" value="'+mediaUuid+'" class="dz-mImagesUploadFile" >');
                    if(primaryImageEnabled) {
                        uploadedImagePreviewElement.find('.dz-remove').after('<a class="btn btn-primary makePrimary mt-2 ml-2" data-fileName="' + response.fileName + '" title="make primary"><i class="fas fa-image"></i></a>')
                    }
                    multipleDropzoneElement[selectedElement].parents('form').find('input[type="submit"]').removeAttr('disabled');
                    multipleDropzoneElement[selectedElement].parents('form').find('button[type="submit"]').removeAttr('disabled');
                });

            },
            removedfile: function(file)
            {
                var mediaUuid = $("#document-" + file.serverId).find('.dz-mImagesUploadFile').val();
                removeUploadedMImage(mediaUuid, "Are you sure?", file, '', multipleDropzoneElement[selectedElement]);
            },
            error: function (file, response) {
                var res = response.errors;
                toastr["error"](res['file']);
                return false;
            }
        });
    }

    $(document).on('click', '.remove_image', function(){
        let mediaUuid = $(this).data('uuid');
        removeUploadedMImage(mediaUuid, "Are you sure?", '', $(this));
    })

    function removeUploadedMImage(uuid, confirmMsg, file = '', selectedRemoveElement = '', selectedDropzoneElement = '') {
        if (confirm(confirmMsg)) {
            let result;
            $.ajax({
                type: 'POST',
                url: '{{ route('file.remove') }}',
                data: {mediaUuid: uuid},
                success: function (data) {
                    if (file !== '') {
                        file.previewElement.remove();
                    }
                    if(selectedRemoveElement !== ''){
                        selectedRemoveElement.parents('.dz-mImageThumbnail').remove();
                    }
                    if (selectedDropzoneElement !== '' && selectedDropzoneElement.find('div.dz-preview').length === 0) {
                        selectedDropzoneElement.find('div.dz-mImagesPlaceholderText').removeClass('d-none');
                    }
                }
            });
        }
    }

    function updatePrimaryBtnUi_forBtn(btnRef) {
        //Removing primary class from existing primary btn
        btnRef.parents('.dz-mImagesContainer').find('a.primary').removeClass('primary');

        //Updating button classes & text
        btnRef.addClass('btn-success primary').removeClass('btn-primary').attr('title', 'primary image');
        btnRef.parents('.dz-mImagesContainer').find('a.makePrimary:not(.primary)').each(function(key, ele){
            ele = $(ele);
            ele.addClass('btn-primary').removeClass('btn-success primary')
                .attr('title', 'make primary');
        });
    }

    function updateExistingPrimaryBtnUi_forBtn(btnRef) {
        //Removing primary class from existing primary btn
        btnRef.parents('.dz-mImagesContainer').find('a.primary').removeClass('primary');

        //Updating button classes & text
        btnRef.addClass('btn-success primary').removeClass('btn-primary').html('PRIMARY');
        btnRef.parents('.dz-mImagesContainer').find('a.makePrimary:not(.primary)').each(function(key, ele){
            ele = $(ele);
            ele.addClass('btn-primary').removeClass('btn-success primary')
                .html('Make Primary');
        });
    }

    function setExistingDropzoneImages(details, input = $('input[name=primaryImage].primaryImage')){
        let carouselInnerRef = input.parents('.dz-mImagesContainer').find('.uploaded_image');
        let mImagesPreviewDivRef = input.parents('.dz-mImagesContainer').find('div.dz-preview');
        let mImagesPlaceholderDivRef = input.parents('.dz-mImagesContainer').find('div.mImagesPlaceholderDiv');
        let existingImagesCardTemplate = $('.imageTemplate_forExisting');

        let carouselCards = [];
        $.each(details['images'], function(){
            carouselCards.push(existingImagesCardTemplate.html());     //Pushing cards for the number of times the files.
        });
        if(details.hasOwnProperty('primaryImage')) {
            carouselCards.push(existingImagesCardTemplate.html());      // + 1 pushing for primary image.
        }
        if(carouselCards.length === 0)      return;
        let carouselSets = getSetOfImages_Item(carouselCards,4);

        carouselInnerRef.html(carouselSets.join(''));

        //Setting primary image
        if(details.hasOwnProperty('primaryImage')) {
            let firstCardImageRef = input.parents('.dz-mImagesContainer').find('.dz-mImageThumbnail:first');
            firstCardImageRef.find("img").attr('src', details['primaryImage']['url']);
            firstCardImageRef.addClass('primary')
            firstCardImageRef.find('a.make_primary').addClass('btn-success primary').removeClass('btn-primary')
                .html('PRIMARY')
                .data('media_id', details['primaryImage']['media_id'])
                .data('media_name', details['primaryImage']['media_name']);
            firstCardImageRef.find('a.remove_image')
                .data('media_id', details['primaryImage']['media_id'])
                .data('media_name', details['primaryImage']['media_name']);
        }

        //Setting the images
        input.parents('.dz-mImagesContainer').find('.dz-mImageThumbnail:not(.primary)').each(function(key, ele){
            ele = $(ele);
            ele.find('img').attr('src', '{{ route('images_default','500x500') }}');
            ele.find('img').attr('src', details['images'][key]['url']);
            ele.find('.remove_image').attr('data-uuid', details['images'][key]['media_uuid']);
            ele.find('a.make_primary').attr('data-media_id', details['images'][key]['media_id'])
                .attr('data-media_name', details['images'][key]['media_name'])
                .attr('data-imageType', details['images'][key]['media_type']);


            //Obtaining card ref
            // let cardRef = ele.closest('.box');

            //Setting media id to delete btn
            ele.find('.remove_image')
                .data('media_id',details['images'][key]['media_id'])
                .data('media_name',details['images'][key]['media_name']);

            //Setting media id to makePrimary btn
            ele.find('.makePrimary')
                .data('media_id',details['images'][key]['media_id'])
                .data('media_name',details['images'][key]['media_name']);
        });

        //Hiding placeholder and displaying imagePreviewer
        mImagesPlaceholderDivRef.addClass("d-none");
        mImagesPreviewDivRef.animateCss('pulse').removeClass("d-none").on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).removeClass("d-none");
        });
    }

    function getSetOfImages_Item(carouselCards, noOfCards_perCarousel){
        let carouselSets = [];
        carouselSets.push('<div class="upload-images-title mt-3 mb-2">Uploaded Images</div>' +
            '<div class="row">');
        $.each(_.chunk(carouselCards,noOfCards_perCarousel),function(key, setOfCards){
            carouselSets.push(
                '' +
                setOfCards.join('')
            );
        });
        carouselSets.push('</div>');
        return carouselSets;
    }

    $(document).on('click','a.makePrimary',function(){
        makePrimaryImage($(this));
    });

    $(document).on('click','a.make_primary',function(){
        makePrimaryImage($(this));
    });

    function makePrimaryImage(element){
        let dataFileName = element.data('filename');
        if(dataFileName !== undefined) {
            makePrimaryImageToastr(element);
            updatePrimaryBtnUi_forBtn(element)
        }else{
            makePrimary(element);       //shall be used only during update index
        }
    }

    function makePrimaryImageToastr(element){
        let dataFileName = element.data('filename');
        multipleImageContainer.find('input.primaryImage').val(dataFileName);
        toastr.success("Primary Image set to \'" + dataFileName + "\'!",'Success!');
    }

    function reUploadDzMultipleFile(){
        $.each(dropzoneMultipleInitObject, function (key, dzObject) {
            $.each(uploadedMultipleFilePath[key], function(fileIndex, file){
                file.status = Dropzone.ADDED;
                dzObject.enqueueFile(file);
            })
        });
    }
</script>
