<div class='btn-group'>
    <a href="{{ route('admin.users.show', $uuid) }}" class='btn btn-default btn-xs' title="Show User">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.users.edit', $uuid) }}" class='btn btn-default btn-xs' title="Edit User">
        <i class="fas fa-edit"></i>
    </a>
    <a class='btn btn-danger btn-xs' title="Delete User" onclick="ajaxCallDelete('{{ route('admin.users.destroy', $uuid) }}',
        'Are you sure?', 'User-index')">
        <i class="fas fa-trash-alt"></i>
    </a>
</div>
