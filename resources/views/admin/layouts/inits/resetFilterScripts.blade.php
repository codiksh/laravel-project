<script>
    $('.buttons-reset').click(function () {
        $('.filter').each(function (i, e) {
            e.value = null;
            if (e.classList.contains('select2_with_placeholder'))
                reinitiateSelect2ByClass('select2_with_placeholder');
            if (e.classList.contains('select2-multiple'))
                reinitiateSelect2ByClass('select2-multiple');
        });
        $('.buttons-reload').click();
    });
</script>
