<script>
    (function($) {
        "use strict";
        // manual carousel controls
        $('.next').click(function(){ $('.carousel').carousel('next');return false; });
        $('.prev').click(function(){ $('.carousel').carousel('prev');return false; });
    })(jQuery);
</script>

<script id="carouselCardTemplate" type="text/template">
    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-body p-0">
                <div class="card-img-top card-img-top-250">
                    <img class="img-fluid mImagesPreviewHolder" src="{{ route('images_default',['resolution' => '250x250']) }}" alt="images">
                </div>
                <div class="text-center" style="padding: 10px;">
                    <div style="padding-bottom: 10px;"><strong class="mImageFileName"></strong></div>
                    <button class="btn btn-primary makePrimary" type="button">
                        <i class="ionicons ion-android-star-outline"></i> MAKE PRIMARY
                    </button>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</script>
<script id="carouselCardTemplate_forExisting" type="text/template">
    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-body p-0">
                <div class="card-img-top card-img-top-250">
                    <img class="img-fluid mImagesPreviewHolder" src="{{ route('images_default',['resolution' => '250x250']) }}" alt="images">
                </div>
                <div class="text-center" style="padding: 10px; ">
                    <div style="padding-bottom: 10px;"><strong class="mImageFileName"></strong></div>
                    <button class="btn btn-primary makePrimary" type="button" style="margin-bottom: 5px">
                        <i class="ionicons ion-android-star-outline"></i> MAKE PRIMARY
                    </button>
                    <button class="btn btn-danger deleteImage" type="button" onclick="deleteImage($(this))" style="margin-bottom: 5px">
                        <i class="ionicons ion-ios-trash-outline"></i> DELETE
                    </button>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</script>

<script>
    //Variables
    let mImagesPlaceholderDivRef = $('.mImagesPlaceholderDiv');
    let mImagesInputRef = $('#mImages_id');
    let templateRef = $('#carouselCardTemplate');
    let carouselInnerRef = $('#carouselInner');
    let mImagesPreviewDivRef = $('.mImagesPreview');

    mImagesPlaceholderDivRef.click(changeMImages);

    function previewMImages(input){
        if(!validateFileInput_maxSize('.box-body')){
            focusOn_firstFileInput_withMaxSizeCondition('.box-body');
        }

        let carouselCards = [];
        $.each(input.files, function(){
            carouselCards.push(templateRef.html());     //Pushing cards for the number of times the files.
        });

        let carouselSets = getSetOfCards_forSingleCarouselItem(carouselCards,3);

        carouselInnerRef.html(carouselSets.join(''));

        //Setting the images
        $('.mImagesPreviewHolder').each(function(key, ele){
            ele = $(ele);
            ele.attr('src', '{{ route('images_default',['resolution' => '250x250']) }}');
            let reader = new FileReader();
            reader.onload = function (e) {
                ele.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[key]);

            //Obtaining box ref
            let cardRef = ele.closest('.box');

            //Setting file name to display
            cardRef.find('strong.mImageFileName').html(input.files[key].name);

            //Setting file name to makePrimary btn
            cardRef.find('button.makePrimary').data('filename',input.files[key].name);
        });

        mImagesPlaceholderDivRef.addClass("d-none");
        mImagesPreviewDivRef.addClass('carousel slide');
        mImagesPreviewDivRef.animateCss('pulse').removeClass("d-none").on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).removeClass("d-none");
        });
    }

    function getSetOfCards_forSingleCarouselItem(carouselCards, noOfCards_perCarousel){
        let carouselSets = [];
        $.each(_.chunk(carouselCards,noOfCards_perCarousel),function(key, setOfCards){
            carouselSets.push(
                '' +
                '<div class="item ' + (key === 0 ? 'active' : '') + '">' +
                '<div class="row">' +
                setOfCards.join('') +
                '</div>'+
                '</div>'
            );
        });
        return carouselSets;
    }

    function changeMImages(){
        mImagesInputRef.prop("value","");
        mImagesInputRef.click();
        mImagesPreviewDivRef.addClass("d-none");
        mImagesPlaceholderDivRef.animateCss('pulse').removeClass("d-none").on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).removeClass("d-none");
        });
    }


    //Set Primary Image
    let primaryImgInputRef = $('#primaryImage_id');
    let bodyRef = $('body');
    bodyRef.on('click','button.makePrimary',function(){
        let dataFileName = $(this).data('filename');
        if(dataFileName !== undefined) {
            primaryImgInputRef.val(dataFileName);
            toastr.success("Primary Image set to \'" + dataFileName + "\'!",'Success!');

            updatePrimaryBtnUi_forBtn($(this))
        }else{
            makePrimary($(this));       //shall be used only during update index
        }
    });

    function updatePrimaryBtnUi_forBtn(btnRef) {
        //Removing primary class from existing primary btn
        $('button.primary').removeClass('primary');

        //Updating button classes & text
        btnRef.addClass('btn-success primary').removeClass('btn-primary')
            .html('<i class="ionicons ion-android-star"></i> PRIMARY');
        $('button.makePrimary:not(.primary)').each(function(key, ele){
            ele = $(ele);
            ele.addClass('btn-primary').removeClass('btn-success primary')
                .html('<i class="ionicons ion-android-star-outline"></i> MAKE PRIMARY');
        });
    }


    function setExistingImages(details){
        let existingImagesCardTemplate = $('#carouselCardTemplate_forExisting');

        let carouselCards = [];
        $.each(details['images'], function(){
            carouselCards.push(existingImagesCardTemplate.html());     //Pushing cards for the number of times the files.
        });
        if(details.hasOwnProperty('primaryImage')) {
            carouselCards.push(existingImagesCardTemplate.html());      // + 1 pushing for primary image.
        }
        let carouselSets = getSetOfCards_forSingleCarouselItem(carouselCards,3);

        carouselInnerRef.html(carouselSets.join(''));

        //Setting primary image
        if(details.hasOwnProperty('primaryImage')) {
            let firstCardImageRef = $('.mImagesPreviewHolder:first');
            firstCardImageRef.attr('src', details['primaryImage']['url']);
            firstCardImageRef.addClass('primary')
            firstCardImageRef.closest('.box').find('button.makePrimary').addClass('btn-success primary').removeClass('btn-primary')
                .html('<i class="ionicons ion-android-star"></i> PRIMARY')
                .data('media_id', details['primaryImage']['media_id'])
                .data('media_name', details['primaryImage']['media_name']);
            firstCardImageRef.closest('.box').find('button.deleteImage')
                .data('media_id', details['primaryImage']['media_id'])
                .data('media_name', details['primaryImage']['media_name']);
        }

        //Setting the images
        $('.mImagesPreviewHolder:not(.primary)').each(function(key, ele){
            ele = $(ele);
            ele.attr('src', '{{ route('images_default','500x500') }}');
            ele.attr('src', details['images'][key]['url']);

            //Obtaining card ref
            let cardRef = ele.closest('.box');

            //Setting media id to delete btn
            cardRef.find('button.deleteImage')
                .data('media_id',details['images'][key]['media_id'])
                .data('media_name',details['images'][key]['media_name']);

            //Setting media id to makePrimary btn
            cardRef.find('button.makePrimary')
                .data('media_id',details['images'][key]['media_id'])
                .data('media_name',details['images'][key]['media_name']);
        });

        //Hiding placeholder and displaying imagePreviewer
        mImagesPlaceholderDivRef.addClass("d-none");
        mImagesPreviewDivRef.addClass('carousel slide');
        mImagesPreviewDivRef.animateCss('pulse').removeClass("d-none").on("webkitAnimationEnd oAnimationEnd msAnimationEnd animationend", function (e) {
            $(this).removeClass("d-none");
        });
    }


</script>
