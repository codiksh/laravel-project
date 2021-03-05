<script>
    $('.datetimepicker').each(function () {
        if ($(this).val() !== '' && $(this).val() !== undefined && !isNaN(Date.parse($(this).val()))) {
            $(this).setCustomDateTime(moment($(this).val()).format('DD/MM/YYYY HH:mm'));
        }
    });
</script>
