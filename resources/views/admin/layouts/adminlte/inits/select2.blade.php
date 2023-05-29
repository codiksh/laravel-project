{{----------------------------------------------------------------------------------------------------------------------
                                                INITIALIZING SELECT2
    This script creates a function called initiateSelect2() which contains various different types of select2 inits,
    which can be used at differen places... By Default, it is initialized from generalContent/single/index for Single
    Card based pages and in generalContent/multiple/dance-master for Multiple card based ones...
    The reason for creating the function, is that, we call it at even those places where it couldn't initialize by default,
    like in datatables.
----------------------------------------------------------------------------------------------------------------------}}


<script type="text/javascript">

    //===============================Select 2 Scripts BELOW=================================================================
    initiateSelect2();

    function initiateSelect2(selector = ''){
        //Normal Select 2
        $('.select2_default' + selector).select2({
            selectOnClose: false,
            allowClear: true
        });
        //Select 2 With PlaceHolder
        $(".select2_with_placeholder" + selector).prepend('<option></option>').val('').select2({
            selectOnClose: false,
            placeholder: $(this).data("data-placeholder"),
            allowClear: true
        });
        //Multiple Select2 Default
        $('.select2-multiple_default' + selector).select2({
            selectOnClose: false,
            allowClear: true
        });
        //Multiple select2 With Placeholder
        $('.select2-multiple' + selector).select2({
            selectOnClose: false,
            placeholder: $(this).data("data-placeholder"),
            allowClear: true
        });
        //Multiple select2 With Placeholder - Tags Supportive
        $('.select2-multiple-tags' + selector).select2({
            selectOnClose: false,
            placeholder: $(this).data("data-placeholder"),
            allowClear: true
        });
    }
    function reinitiateSelect2ById(elementId){
        $('#'+elementId).select2("destroy");
        initiateSelect2('#' + elementId);
    }
    function reinitiateSelect2ByClass(classToReinitiate){
        let selectRef = $('select.' + classToReinitiate);
        if (selectRef.hasClass('select2-hidden-accessible')) {
            selectRef.select2("destroy");
            initiateSelect2('.' + classToReinitiate);
        }
    }
    //==============================================Select 2 Scripts FINISH=================================================
    $.fn.setSelect2Placeholder = function (placeholder) {
        var $select2Container = $(this).data('select2').$container;
        if($(this).hasClass('select2-multiple') || $(this).hasClass('select2-multiple_default')){
            return $select2Container.find('.select2-search__field').attr('placeholder',placeholder);
        }else {
            return $select2Container.find('.select2-selection__placeholder').text(placeholder);
        }
    };

    /**
     * Initiates the Ajax based Select2
     * @param eleRef
     * @param url
     * @param data
     * @param placeholder
     * @param templateResult
     * @param templateSelection
     * @param requestType
     * @param isMultiple
     * @param dropdownParent
     */
    function initAjaxSelect2(eleRef, url, data, placeholder, templateResult = undefined, templateSelection = undefined,
                             requestType = 'GET', isMultiple = false, dropdownParent =  $(document.body)){
        eleRef.select2({
            dropdownParent: dropdownParent,
            selectOnClose: false,
            ajax: {
                type: requestType,
                url: url,
                data: data,
                cache: true
            },
            placeholder: placeholder,
            minimumInputLength: 0,
            templateResult: templateResult,
            templateSelection: templateSelection,
            closeOnSelect: !isMultiple,
            scrollAfterSelect: false,
            allowClear: true,
        }).on('select2:select', function (e) {
            $('.select2-search input').val('').trigger('change');
        });
        createSelect2Placeholder(eleRef, placeholder);
    }

    function createSelect2Placeholder(eleRef, placeholder){
        let placeholderSpan = $('span#select2-' + eleRef.attr('id') + '-container span.select2-selection__placeholder');
        if(placeholderSpan.length < 1){
            $('span#select2-' + eleRef.attr('id') + '-container').append('<span class="select2-selection__placeholder"></span>');
        }
        placeholderSpan = $('span#select2-' + eleRef.attr('id') + '-container span.select2-selection__placeholder');
        placeholderSpan.html(placeholder);
    }

    function fillSelect2(Ref, dataObject){
        Ref.select2('data', dataObject);
        Ref.empty();
        if($.isArray(dataObject)){
            $.each(dataObject, function(key, itemObject){
                Ref.select2("trigger", "select", {data: itemObject});
            })
        }else {
            Ref.select2("trigger", "select", {data: dataObject});
        }
    }
</script>
