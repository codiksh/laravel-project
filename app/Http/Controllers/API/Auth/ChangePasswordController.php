<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Models\User;
use App\MyClasses\ApiHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller{

    /**
     * Changes the user password
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function changePassword(ChangePasswordRequest $request){

        $user = Auth::user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return ApiHelpers::response('Current Password is incorrect', [], 422);
        }
        $user->update(['password' => Hash::make($request->input('new_password'))]);
        return ApiHelpers::response('Password has been updated successfully!');
    }
}
