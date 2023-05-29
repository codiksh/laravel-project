<script type="text/javascript">
    function switch_between_register_to_registerAnother_btn(formRef, forceRegister = false, nameFieldRef = $('#name'), regBtnRef = $('.rspSuccessBtns')){
        if(regBtnRef.data('type') === undefined)    regBtnRef.data('type','reg');
        if(forceRegister === true){
            regBtnRef.data('type','regAno');
        }
        if(regBtnRef.data('type') === 'reg'){
            {{--Currently, its an register button, we have to make it to register Another button--}}
            $('textarea').css('resize','none');
            $('img.deleteItemIconImg').css('pointer-events','none');
            $('img.deleteAllItemIconImg').css('pointer-events','none');
            $('span.deleteItemBtn').css('cursor','not-allowed');
            $('span.delete_allItemBtn').css('cursor','not-allowed');

            formRef.find("input,button:not('.rspMsgDismissible'),textarea,select").attr("disabled", true);
            $('.helper-links').addClass('d-none');
            regBtnRef.data('type','regAno')
        }else{
            {{--Currently, its an register another button, we have to make it to register button--}}
            $('textarea').css('resize','');
            $('span.deleteItemBtn').css('cursor','pointer');
            $('span.delete_allItemBtn').css('cursor','pointer');
            $('img.deleteItemIconImg').css('pointer-events','');
            $('img.deleteAllItemIconImg').css('pointer-events','');

            formRef.find("input,button:not('.rspMsgDismissible'),textarea,select").attr("disabled", false);
            regBtnRef.data('type','reg');
            nameFieldRef.focus();
            $('.helper-links').removeClass('d-none');
            $('button.rspMsgDismissible').click();
            if(typeof reUploadDzFile === 'function')    reUploadDzFile();
            if(typeof reUploadDzMultipleFile === 'function')    reUploadDzMultipleFile();
            if(typeof reUploadDzAttachmentFile === 'function')    reUploadDzAttachmentFile();
        }
    }
</script>
