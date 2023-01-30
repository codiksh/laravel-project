<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('permission:roles.permissions.manage');
    }

    /**
     * Returns Add Permission index page.
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function index(Role $role) {
        $allPermissions = Permission::orderBy('group')->get()->groupBy('group');
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.manage-permissions.index', compact('role', 'allPermissions', 'selectedPermissions'));
    }


    /**
     * Update the specified role's permission.
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role)
    {
        $roleName = str_replace(' ', '-', $role->name);
        $role->syncPermissions(request()->input($roleName));
        return Response::json(['message' => 'Permission updated successfully.']);
    }
}
