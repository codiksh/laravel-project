<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Http\Requests\Admin\UpdateUserPasswordRequest;
use App\Models\User;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\MyClasses\GeneralHelperFunctions;
use App\Repositories\Admin\UserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Response;
use Throwable;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('permission:users.index')->only(['index',]);
        $this->middleware('permission:users.create')->only(['create','store']);
        $this->middleware('permission:users.edit')->only(['edit','update']);
        $this->middleware('permission:users.view')->only('show');
        $this->middleware('permission:users.delete')->only('destroy');
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new User.
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created User in storage.
     * @param CreateUserRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        $user = User::create($request->validated());
        $user->syncRoles($request->input('role'));
        $user->markEmailAsVerified();
        $this->userRepository->updateOrCreate_avatar($user,$request);
        DB::commit();

        return Response::json(['message' => 'User has been created successfully.'
            . GeneralHelperFunctions::getSuccessResponseBtn($user, route('admin.users.edit', $user))]);

    }

    /**
     * Display the specified User.
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     * @param User $user
     * @param UpdateUserRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        DB::beginTransaction();
        $user->update($request->validated());
        $user = $user->fresh();
        $user->syncRoles($request->input('role'));
        $this->userRepository->updateOrCreate_avatar($user,$request);
        DB::commit();

        return Response::json(['message' => 'User updated successfully.']);
    }

    /**
     * Remove the specified User from storage.
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->userRepository->delete($user->id);
        return Response::json(['message' => 'User deleted successfully']);
    }

    /**
     * Opens the change password page.
     * @param User $user
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function changePassword(User $user)
    {
        return view('admin.users.changePassword');
    }

    /**
     * Changes the User's Password
     * @param User $user
     * @param UpdateUserPasswordRequest $request
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function changePassword_process(User $user, UpdateUserPasswordRequest $request) {

        $user->update(['password' => $request->input('password')]);
        $user->save();

        return Response::json(['message' => 'Password updated successfully.']);
    }
}
