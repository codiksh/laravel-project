<script>
    function fillDropDown(selector, options, dataTableObj, dataTable_field, itemChangedTriggeringClass){
        $('body').on('click',selector, function () {
            let ddMenuRef = $(this).parent('.drop-down').find('.dropdown-menu');
            ddMenuRef.html('');

            let thisVal = dataTableObj.row(getDtParentRow($(this))).data()[dataTable_field];
            $.each(options, function(key, value){
                let activeClass = thisVal === value ? 'active' : '';
                ddMenuRef.append(`<a class="dropdown-item ${itemChangedTriggeringClass} ${activeClass}" data-uuid="${key}" href="javascript:void(0);">${value}</a>`)
            });
        });
    }
</script>
