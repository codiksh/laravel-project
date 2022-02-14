<script type="text/template" class="existingFileTemplate">
    <tr class="files_row row-%%ROW-COUNTER%%" data-globalRow="%%GLOBAL-ROW%%">
        <td style="width: 80%; vertical-align: middle;">
            <a href="" id="%%ATTACHED_FILE%%" target="_blank"></a> &nbsp;
        </td>
        <td style="width: 20%; vertical-align: middle;" class="text-center">
            {{-- Delete Button --}}
            <span class="deleteItemBtn" ondragstart="return false;" style="cursor: pointer;">
                <img class="deleteFileImg" src="{{ asset('/images/close.png') }}" width="20" ondragstart="return false;" >
            </span>
        </td>
    </tr>
</script>
<script type="text/javascript">

    var rowCounter = 1;
    let globalRowCounter = 1;

    function fillAttachmentRow(inOutData, dropzoneElement) {
        let tableRef = dropzoneElement.parent().find('.existingFilesList');
        for (let i = 0; i < inOutData.length; i++) {
            makeAttachmentInRow(tableRef);
            if(inOutData[i].name)
                tableRef.find('#attachment_' + globalRowCounter).html(inOutData[i].name);
            if(inOutData[i].url)
                tableRef.find('#attachment_' + globalRowCounter).attr('href', inOutData[i].url);
            if(inOutData[i].uuid)
                tableRef.find('#attachment_' + globalRowCounter).parents('tr').attr('data-attachment-uuid', inOutData[i].uuid)
                    .attr('data-attachment-name', inOutData[i].name);
            rowCounter++;
            globalRowCounter++;
        }
    }

    function makeAttachmentInRow(tableRef) {
        // $('.dz-file-attachment').removeClass('d-none');
        let rowHtml = $('.existingFileTemplate').html()
            .replace(/%%ATTACHED_FILE%%/g, 'attachment_' + globalRowCounter)
            .replace(/%%GLOBAL-ROW%%/g, globalRowCounter)
            .replace(/%%ROW-COUNTER%%/g, rowCounter);
        $(rowHtml).appendTo(tableRef.find('tbody')).animateCss('zoomIn');
    }

    //Managing Item Row Deletions
    $(document).on('click', 'img.deleteFileImg', function () {
        deleteAttachmentFiles($(this).parents('tr'));
    });

    function deleteAttachmentAndRow(rowRef, animate = true){
        let rowRefLength = rowRef.length;
        if(animate) {
            rowRef.animateCss('zoomOutRight', function (e) {
                //Things to perform after animation
                rowRef.remove();    //Deleting Current TR.
                rowCounter -= rowRefLength;       // Updating Row
            });
        }else{
            rowRef.remove();    //Deleting Current TR.
            rowCounter -= rowRefLength;       // Updating Row
        }
    }

    function deleteAttachmentFiles(rowRef){
        deleteResource({
            confirmationText: 'Are you sure, you want to remove ' + rowRef.data('attachment-name'),
            ajax: {
                type: 'POST',
                url: '{{ route('file.remove') }}',
                data: {mediaUuid: rowRef.data('attachment-uuid')},
            },
            successCallbackFunc: function (){
                deleteAttachmentAndRow(rowRef);
            }
        })
    }

    function resetAttachmentInsRow() {
        deleteAttachmentsRow($('.proofs_row'), false, function () {
            addAttachmentOutRow(2);
        });
    }
</script>
