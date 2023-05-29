<script>
    let action = $('.datatables_action');
    let url = window.location.href;
    $(action).each(function (){
        $(action).find('a').each(function() {
            if($(this).attr('href') === url){
                $(this).addClass("d-none")
            }
        });
    });
</script>
