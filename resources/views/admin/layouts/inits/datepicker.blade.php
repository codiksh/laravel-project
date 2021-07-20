<script>
    function initDatepicker() {
        $('.datepicker').daterangepicker({
            timePicker: false,
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            locale: {
                "format": "DD/MM/YYYY",
            },
            autoUpdateInput: false,
        }).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
            if ($(this).hasClass('filter'))
                $(this).trigger('change');
        });
    }

    initDatepicker();
    $('.datetimepicker').daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        showDropdowns: true,
        timePicker24Hour: true,
        timePickerIncrement: 5,
        autoApply: true,
        locale: {
            "format": "DD/MM/YYYY HH:mm",
        },
        autoUpdateInput: false,
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY HH:mm'));
    });

    $('.dateRangePicker').daterangepicker({
        timePicker: false,
        autoApply: true,
        locale: {
            "format": "DD/MM/YYYY",
        },
    }).on('apply.daterangepicker', function (ev, picker) {
        if ($(this).hasClass('filter'))
            $(this).trigger('change');
    });

    /**
     * 1. Add a check for only daterangepicker objects
     * 2. when setting input vale, check if the date param is string or object. If object, format and set.
     * @param date
     */
    $.fn.setCustomDate = function (date) {
        if (!$(this).hasClass('datepicker'))
            return false;
        if (typeof date === 'object')
            if (Object.prototype.toString.call(date) === '[object Date]')
                date = moment(date).format("DD/MM/YYYY");
            else
                return false;
        $(this).data('daterangepicker').setStartDate(date);
        $(this).data('daterangepicker').setEndDate(date);
        $(this).val(date);
    };

    $.fn.setCustomDateTime = function (date) {
        if (!$(this).hasClass('datetimepicker'))
            return false;
        if (typeof date === 'object')
            if (Object.prototype.toString.call(date) === '[object Date]')
                date = moment(date).format("DD/MM/YYYY HH:mm");
            else
                return false;
        $(this).data('daterangepicker').setStartDate(date);
        $(this).data('daterangepicker').setEndDate(date);
        $(this).val(date);
    };

</script>
