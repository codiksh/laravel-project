<script>
    $('.datepicker').each(function(){
        if ($(this).val() !== '' && $(this).val() !== undefined && !isNaN(Date.parse($(this).val()))) {
            $(this).setCustomDate(moment($(this).val()).format('DD/MM/YYYY'));
        }
    });
</script>
