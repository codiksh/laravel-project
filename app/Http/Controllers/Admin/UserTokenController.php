<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TokenDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Response;

class UserTokenController extends Controller
{

    public function __construct() {
        $this->middleware('permission:userTokens.index')->only('index');
        $this->middleware('permission:userTokens.generate')->only('generate');
        $this->middleware('permission:userTokens.delete')->only('destroy');

    }

    /**
     * Display a listing of the User.
     *
     * @param User $user
     * @param TokenDataTable $tokenDataTable
     * @return Response
     */
    public function index(User $user, TokenDataTable $tokenDataTable)
    {
        return $tokenDataTable->render('admin.tokens.index');
    }

    /**
     * Generate user token
     *
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function generate(User $user, Request $request) {

        $token = $user->createToken('Auth-token')->plainTextToken;

        return Response::json(['message' => 'Token generated successfully','token'=>$token]);
    }

    /**
     * Delete User token
     *
     * @param $userid
     * @param $tokenid
     * @param Request $request
     * @param PersonalAccessToken $personalAccessToken
     * @return mixed
     */
    public function destroy($userid, $tokenid, Request $request, PersonalAccessToken $personalAccessToken)
    {
        $model = PersonalAccessToken::findOrFail($tokenid);
        $model->delete();

        return Response::json(['message' => 'User deleted successfully']);
    }
}
