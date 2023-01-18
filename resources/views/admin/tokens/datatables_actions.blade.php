<div class="btn-group d-flex justify-content-center">
    <div class="btn-group dropleft datatables_action" role="group">
        <button type="button" class="btn btn-lg action-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-stroke-vertical"></i>
        </button>
        <div class="dropdown-menu">

            <a class='dropdown-item py-2 bg-danger' href="javascript:void(0);" style="color: white; padding-bottom: 10px" onclick="ajaxCallDelete('{{ route('admin.userTokens.destroy' ,[request()->route('user'),$PersonalAccessToken]) }}',
                'Are you sure?', 'userToken-index')">
                <i class="fas fa-trash-alt mr-1"></i>&nbsp;&nbsp;Delete
            </a>
        </div>
    </div>
</div>
