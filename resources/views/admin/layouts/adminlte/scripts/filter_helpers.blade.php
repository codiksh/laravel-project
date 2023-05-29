<script>
    let appliedFilter = false;
    let filterRef_underHelperScope = $('.filter');

    function updateFilterButton() {
        appliedFilter = false;
        filterRef_underHelperScope.each(function (i, e) {
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
    filterRef_underHelperScope.change(function(){
        if(! filterStorageExists()){
            filterRef_underHelperScope.each(function(){
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
            dataToStore = Array.isArray(dataToStore) ? JSON.stringify(dataToStore) : dataToStore;
            if (eleRef.hasClass('hasAjaxSelect2') && eleRef.select2('data') !== undefined) {
                dataToStore = JSON.stringify(eleRef.select2('data') ?? {});
            }
        }
        if(dataToStore !== undefined && dataToStore !== null) {
            localStorage.setItem(storageId, dataToStore);
        }
    }

    function setStoredFilters(){
        filterRef_underHelperScope.each(function(){
            let storageId = storage_prefix + $(this).attr('id');
            let data = localStorage.getItem(storageId);
            setDataToInputs(data, $(this));
        });
    }

    function setDataToInputs(data, Ref){
        if(data !== undefined && data !== null) {
            if (Ref.is('select')) {
                if(Ref.prop('multiple') || Ref.hasClass('hasAjaxSelect2')) {
                    data = JSON.parse(data);
                }
                if(data === null)   return;
                if (Ref.hasClass('hasAjaxSelect2')) {
                    if (Array.isArray(data)) {
                        fillSelect2(Ref, data);
                    } else {
                        if (data.hasOwnProperty('id'))
                            fillSelect2(Ref, data);
                        else
                            Ref.empty();
                    }
                }else{
                    Ref.val(data);
                }
            } else if (Ref.hasClass('datepicker')) {
                if (data) Ref.setCustomDate(data); else Ref.val('');
            } else if (Ref.hasClass('datetimepicker')) {
                if (data) Ref.setCustomDateTime(data); else Ref.val('');
            } else {
                Ref.val(data);
            }
            Ref.trigger('change');
        }
    }

    function removeStoredFilters(){
        filterRef_underHelperScope.each(function(){
            let storageId = storage_prefix + $(this).attr('id');
            localStorage.removeItem(storageId)
        });
    }

    function filterStorageExists(){
        let count = 0;
        filterRef_underHelperScope.each(function() {
            let storageId = storage_prefix + $(this).attr('id');
            if(localStorage.hasOwnProperty(storageId))  count ++;
        });
        return count > 0;
    }

    function emptyFilters(callback){
        filterRef_underHelperScope.each(function (i, e) {
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

    function setFilters_fromSession(){
        let sessionFilters = @json(session('url-filters'));
        if(!sessionFilters)     return;
        emptyFilters(function(){
            typeof initFilterSelect2 === 'function' && initFilterSelect2();
        });
        removeStoredFilters();
        $.each(sessionFilters, function (key, value) {
            setDataToInputs(value, $('#'+key));
        });
        $('.buttons-reload').click();
    }
    $(document).ready(function(){
        setFilters_fromSession();
    });
</script>
