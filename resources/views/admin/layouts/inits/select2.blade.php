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
        $('#'+elementId).select2("destroy").select2();
    }
    function reinitiateSelect2ByClass(classToReinitiate){
        let selectRef = $('select.' + classToReinitiate);
        if (selectRef.hasClass('select2-hidden-accessible'))
            selectRef.select2("destroy").select2();
    }
    //==============================================Select 2 Scripts FINISH=================================================

</script>
