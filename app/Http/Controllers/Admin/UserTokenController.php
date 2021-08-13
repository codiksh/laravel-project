<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TokenDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Response;

class UserTokenController extends Controller
{
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

    public function generate(User $user, Request $request) {

        $token = $user->createToken('Auth-token')->plainTextToken;

        return Response::json(['message' => 'Token generated successfully','token'=>$token]);
    }
}
