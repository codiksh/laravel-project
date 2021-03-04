<script type="text/javascript">
    function moderateResource(inputs){
        inputs['swal'] = {
            title: inputs.title !== undefined ? inputs.title : 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonClass: inputs.confirmButtonClass !== undefined ? inputs.confirmButtonClass : 'btn btn-lg bg-danger',
            cancelButtonClass: inputs.cancelButtonClass !== undefined ? inputs.cancelButtonClass : 'btn btn-lg bg-success',
            confirmButtonText: inputs.confirmButtonText !== undefined ? inputs.confirmButtonText : 'MODERATE',
            cancelButtonText: inputs.cancelButtonText !== undefined ? inputs.cancelButtonText : 'CANCEL',
        };
        swalBasedAjax(inputs);
    }
    function deleteResource(inputs){
        inputs['swal'] = {
            title: inputs.title !== undefined ? inputs.title : 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonClass: inputs.confirmButtonClass !== undefined ? inputs.confirmButtonClass : 'btn btn-lg bg-danger',
            cancelButtonClass: inputs.cancelButtonClass !== undefined ? inputs.cancelButtonClass : 'btn btn-lg bg-success',
            confirmButtonText: inputs.confirmButtonText !== undefined ? inputs.confirmButtonText : 'DELETE',
            cancelButtonText: inputs.cancelButtonText !== undefined ? inputs.cancelButtonText : 'CANCEL',
        };
        swalBasedAjax(inputs);
    }

    function swalBasedAjax(inputs){
        swal({
            title: inputs.swal.title !== undefined ? inputs.swal.title : 'Are you sure?',
//            text: inputs.confirmationText,
            html: inputs.confirmationText,
            type: inputs.swal.type !== undefined ? inputs.swal.type : 'warning',
            showCancelButton: inputs.swal.showCancelButton === undefined ? true : inputs.swal.showCancelButton,
            reverseButtons: inputs.swal.reverseButtons === undefined ? false : inputs.swal.reverseButtons,
            confirmButtonClass: inputs.swal.confirmButtonClass !== undefined ? inputs.swal.confirmButtonClass : 'btn btn-lg bg-success',
            cancelButtonClass: inputs.swal.cancelButtonClass !== undefined ? inputs.swal.cancelButtonClass : 'btn btn-lg bg-danger',
            confirmButtonText: inputs.swal.confirmButtonText !== undefined ? inputs.swal.confirmButtonText : 'CONFIRM',
            cancelButtonText: inputs.swal.cancelButtonText !== undefined ? inputs.swal.cancelButtonText : 'CANCEL',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !swal.isLoading(),
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        type: inputs.ajax.type,
                        url: inputs.ajax.url,
                        data: inputs.ajax.data,
                        success: function (response) {
                            if(inputs.successCallbackFunc !== undefined) {
                                inputs.successCallbackFunc(response);
                            }
                            swal(
                                'SUCCESS!',
                                response['msg'],
                                'success'
                            );
                        },
                        error: function (error) {
                            if(inputs.failureCallbackFunc !== undefined) {
                                inputs.failureCallbackFunc(error.responseText);
                            }
                            var response = $.parseJSON(error.responseText);
                            swal.showValidationError(
                                response['message']
                            );
                            swal.enableButtons();
                            swal.disableLoading();
                        }
                    });
                })
            }
        });
    }
</script>
