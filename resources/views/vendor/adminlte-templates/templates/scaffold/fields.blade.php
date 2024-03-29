{!! $fields_data !!}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button class="btn btn-lg btn-success rspSuccessBtns" type="submit"><i class="fa-duotone fa-floppy-disk"></i> Save
    </button>
    <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}" class="btn btn-lg btn-outline-danger">
        <i class="fa-duotone fa-arrow-left-to-line"></i> Back</a>
</div>
@@push('stackedScripts')
    @@include('admin.layouts.scripts.regAnotherScript')
    @@include('admin.layouts.scripts.swalAjax')
    <script>
        $('.submitsByAjax').submit(function (e) {
            e.preventDefault();
            let type = '{{ $type ?? '' }}'
            let dataToPass = new FormData($(this)[0]);
            ajaxCallFormSubmit($(this), false, 'Loading! Please wait...', dataToPass,
                type === 'create' ? postCreate : undefined);
        });

        function postCreate(){
            switch_between_register_to_registerAnother_btn($('.submitsByAjax'), false)
        }
    </script>
@@endpush
