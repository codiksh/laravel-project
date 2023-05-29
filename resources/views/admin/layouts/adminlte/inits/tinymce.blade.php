<script src="{{ asset('/assets/bower_components/tinymce/tinymce.min.js') }}"></script>

<script>
    //Initializing TinyMCE
    initTinyMCE_bySelector('.hasTinyMCE')

    function initTinyMCE_bySelector(selector){
        tinymce.init({
            selector: selector,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount placeholder autoresize'
            ],
            min_height: 300,
            extended_valid_elements: 'span',
            toolbar: "undo redo | fontselect fontsizeselect formatselect bold italic underline | forecolor backcolor casechange permanentpen formatpainter removeformat | alignleft aligncenter alignright alignfull | numlist bullist | outdent indent  | fullscreen  preview ",
            setup: function(editor) {
                editor.on('init', function(e) {
                    if(typeof tinyMCEInitiated === 'function'){
                        tinyMCEInitiated();
                    }
                });
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    }
</script>
