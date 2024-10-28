<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{!! $user->name !!}</td>
                <td>{!! $user->email !!}</td>
                <td>
                    {!! html()->form('DELETE', route('users.destroy', $user->id))->open() !!}
                    <div class='btn-group'>
                        <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'>
                            <i class="fa fa-edit"></i>
                        </a>
                        {!! html()->button('<i class="fa fa-trash"></i>')
                            ->type('submit')
                            ->class('btn btn-danger btn-xs')
                            ->attribute('onclick', "return confirm('Are you sure?')") !!}
                    </div>
                    {!! html()->form()->close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
