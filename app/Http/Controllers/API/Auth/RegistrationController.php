<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\MyClasses\ApiHelpers;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Response;

class RegistrationController extends Controller {

    public function __construct(UserRepository $userRepo) {
        $this->userRepository = $userRepo;
    }

    /**
     * Register api
     *
     * @param RegistrationRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function register(RegistrationRequest $request) {
        DB::beginTransaction();

        $user = User::create($request->validated());
        $user->assignRole('Super Admin');
        $this->userRepository->updateOrCreate_avatar($user, $request);
        $objToken = $user->createToken($user->name);
        $strToken = $objToken->accessToken;
        $expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());

        DB::commit();

        event(new Registered($user));

        return ApiHelpers::response('User Registered Registered Successfully try to login', [
            'user' => new UserResource($user),
            'token' => [
                'access_token' => $strToken,
                'expires_in' => $expiration,
                'token_type' => 'Bearer',
            ]
        ]);
    }


}
