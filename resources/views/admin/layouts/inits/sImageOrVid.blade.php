<script>
    //single image handling script
    let sImageInputRef = $('#sImage_id');
    let sImagePlaceholderDivRef = $('div.sImagePlaceholderDiv');
    let sImagePreviewDivRef = $('div.sImagePreview');
    let sImage_ImgRef = $('img#sImagePreview_id');
    let removeSImageRef = $('a#removeSImageBtn_id');

    sImagePlaceholderDivRef.click(function(){
        //Picture Container Click event :  Picture File Input should be triggered.
        sImageInputRef.prop("value","");
        sImageInputRef.click();
    });

    function previewImg(input) {
        if(!validateFileInput_maxSize(".box-body")){
            focusOn_firstFileInput_withMaxSizeCondition(".box-body");
        }
        if (input.files && input.files[0]) {
            sImage_ImgRef.attr('src', '{{ route('images_default',['resolution' => '250x250']) }}');
            previewImgOrVidThumbnail(input.files[0])
        }
        sImagePlaceholderDivRef.addClass("d-none");
        sImagePreviewDivRef.animateCss('{{ $loadImageAnimation ?? 'pulse' }}').removeClass("d-none").on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).removeClass("d-none");
        });
    }
    function previewImgOrVidThumbnail(file){
        var fileReader = new FileReader();
        if (file.type.match('image')) {
            fileReader.onload = function(e) {
                sImage_ImgRef.attr('src', e.target.result);
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
                        sImage_ImgRef.attr('src', image);
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
            // sImageInputRef.parent('div.sImageOuterContainer').after('<span class="sVidUploadInfo">Video file uploaded</span>');
        }
    }

    removeSImageRef.click(removeSImage);
    function removeSImage(){
        sImagePreviewDivRef.animateCss('bounceOut').on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).addClass("d-none");
            $('.sVidUploadInfo').remove();
        });
        sImagePlaceholderDivRef.animateCss('fadeIn').removeClass("d-none").on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).removeClass("d-none");
        });
        $('input[name=' + sImageInputRef.data('simagedeletedinputname') + ']').val(1);
        sImageInputRef.prop("value","");
        sImage_ImgRef.attr('src', '{{ route('images_default',['resolution' => '250x250']) }}');

    }
</script>
