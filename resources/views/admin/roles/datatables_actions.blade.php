<div class="d-flex justify-content-end datatables_action">
    <a href="{{ route('admin.roles.permissions.manage.index', $role->name) }}" title="Manage Permissions" class="btn btn-lg text-primary"><i class="fas fa-key"></i></a>
    <div class="dropleft " title="More options">
        <button type="button" class="btn btn-lg pr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-stroke-vertical"></i>
        </button>
        <div class="dropdown-menu">
            <a class='dropdown-item py-2 bg-danger' href="javascript:void(0);" style="color: white; padding-bottom: 10px" onclick="ajaxCallDelete('{{ route('admin.roles.destroy', $role->name) }}',
                'Are you sure?', 'role-index')">
                <i class="fas fa-trash-alt mr-1"></i>&nbsp;&nbsp;Delete
            </a>
        </div>
    </div>
</div>

