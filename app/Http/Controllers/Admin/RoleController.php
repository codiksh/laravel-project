<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\RoleDataTable;
use App\MyClasses\GeneralHelperFunctions;
use App\Models\Role;
use App\Http\Requests\Admin\Role\CreateRequest;
use App\Repositories\Admin\RoleRepository;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\DB;

class RoleController extends AppBaseController
{
    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->middleware('permission:roles.index')->only(['index',]);
        $this->middleware('permission:roles.create')->only(['create','store']);
        $this->middleware('permission:roles.delete')->only('destroy');
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('admin.roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     *@throws \Throwable
     */
    public function store(CreateRequest $request)
    {
        DB::beginTransaction();
        $role = $this->roleRepository->create(array_merge($request->validated(), ['guard_name' => 'web']));
        DB::commit();

        return Response::json(['message' => 'Role has been created successfully.'
                    . GeneralHelperFunctions::getSuccessResponseBtn($role, route('admin.roles.permissions.manage.index', $role), 'name', 'Manage Permissions')]);
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  Role $role
     *
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if($role->name == 'Super Admin'){
            return abort(403, 'Super Admin role can not be deleted.');
        }
        Role::where('name', $role->name)->delete();

        return Response::json(['message' => 'Role deleted successfully']);
    }
}
