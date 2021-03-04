<script>
    let appliedFilter = false;

    function updateFilterButton() {
        appliedFilter = false;
        let filterRef = $('.filter');
        filterRef.each(function (i, e) {
            let data = $('#' + e.id).val();
            if (data !== null && data !== undefined && data !== "" && data.length !== 0) {
                if(! ($(this).is('select') && !$(this).attr('multiple'))) {
                    appliedFilter = true;
                    return false;
                }
            }
        });
        if (appliedFilter) {
            $('#filter-button').addClass('bg-yellow').removeClass('btn-primary').html('<i class="fa fa-filter"></i>&nbsp;Filtered');
            $('#clear-filter').removeClass('d-none');
        } else {
            $('#filter-button').removeClass('bg-yellow').addClass('btn-primary').html('<i class="fa fa-filter"></i>&nbsp;Filter');
            $('#clear-filter').addClass('d-none');
        }
    }

    let storage_prefix = 'codiksh.{{ isset($filterScope) ? "$filterScope." : '' }}filter.';
    filterRef.change(function(){
        if(! filterStorageExists()){
            filterRef.each(function(){
                storeFilters($(this));
            })
        }else{
            storeFilters($(this));
        }
    });

    function storeFilters(eleRef){
        let dataToStore = eleRef.val();
        let storageId = storage_prefix + eleRef.attr('id');
        if(eleRef.is('select')){
            dataToStore = JSON.stringify(dataToStore);
            if (eleRef.hasClass('hasAjaxSelect2') && eleRef.select2('data') !== undefined) {
                dataToStore = JSON.stringify(eleRef.select2('data') ?? {});
            }
        }
        if(dataToStore !== undefined && dataToStore !== null) {
            localStorage.setItem(storageId, dataToStore);
        }
    }

    function setStoredFilters(){
        filterRef.each(function(){
            // debugger;
            let storageId = storage_prefix + $(this).attr('id');
            let data = localStorage.getItem(storageId);
            if(data !== undefined && data !== null) {
                if ($(this).is('select')) {
                    data = JSON.parse(data);
                    if(data === null)   return;
                    if ($(this).hasClass('hasAjaxSelect2')) {
                        if (Array.isArray(data)) {
                            fillSelect2($(this), data);
                        } else {
                            if (data.hasOwnProperty('id'))
                                fillSelect2($(this), data);
                            else
                                $(this).empty();
                        }
                    }else{
                        $(this).val(data);
                    }
                } else if ($(this).hasClass('datepicker')) {
                    if (data) $(this).setCustomDate(data); else $(this).val('');
                } else if ($(this).hasClass('datetimepicker')) {
                    if (data) $(this).setCustomDateTime(data); else $(this).val('');
                } else {
                    $(this).val(data);
                }
                $(this).trigger('change');
            }
        });
    }

    function removeStoredFilters(){
        filterRef.each(function(){
            let storageId = storage_prefix + $(this).attr('id');
            localStorage.removeItem(storageId)
        });
    }

    function filterStorageExists(){
        let count = 0;
        filterRef.each(function() {
            // debugger;
            let storageId = storage_prefix + $(this).attr('id');
            if(localStorage.hasOwnProperty(storageId))  count ++;
        });
        return count > 0;
    }

    function emptyFilters(callback){
        filterRef.each(function (i, e) {
            e.value = null;
            if (e.classList.contains('select2_with_placeholder'))
                reinitiateSelect2ByClass('select2_with_placeholder');
            if (e.classList.contains('select2-multiple'))
                reinitiateSelect2ByClass('select2-multiple');
            if($(this).is('select') && !$(this).attr('multiple')) {
                $(this).val($(this).find('option:first').val());
                reinitiateSelect2ByClass('select2_default');
            }
        });
        if (typeof callback === 'function') {
            callback();
        }
    }
</script>
