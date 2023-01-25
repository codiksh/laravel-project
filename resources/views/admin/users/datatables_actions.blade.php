<div class="d-flex justify-content-end datatables_action">
    <a href="{{ route('admin.users.show', $uuid) }}" title="View User" class="btn btn-lg text-primary">
        <i class="fas fa-eye"></i></a>
    <a href="{{ route('admin.users.edit', $uuid) }}" title="Edit User" class="btn btn-lg text-primary">
        <i class="fas fa-edit"></i></a>
    <div class="dropleft " title="More options">
        <button type="button" class="btn btn-lg pr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-stroke-vertical"></i>
        </button>
        <div class="dropdown-menu">
            <a href="{{ route('admin.userTokens.index', $uuid) }}" title="Manage Token" class="dropdown-item py-2">
                <i class="fas fa-cog mr-2"></i>Manage Token</a>
            <a href="{{ route('admin.users.changePassword.index', $uuid) }}" class="dropdown-item py-2">
                <i class="fas fa-key mr-2"></i>Change Password</a>
            <a class='dropdown-item py-2 bg-danger' href="javascript:void(0);"
               style="color: white; padding-bottom: 10px"
               onclick="ajaxCallDelete('{{ route('admin.users.destroy', $uuid) }}',
                'Are you sure?', 'User-index')">
                <i class="fas fa-trash-alt mr-1"></i>&nbsp;&nbsp;Delete
            </a>
        </div>
    </div>
</div>

