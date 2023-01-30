<?php

namespace App\Repositories\Admin;

use App\MyClasses\GeneralHelperFunctions;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class UserRepository
 * @package App\Repositories\Admin
 * @version September 12, 2020, 10:32 pm UTC
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'mobile',
        'short_bio'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    /**
     * request handler for store and update
     * @param ParameterBag $request
     * @return array
     */
    public static function requestHandler(Request $request)
    {
        return
            [
                'password' =>  Hash::make($request->input('password')),
            ];

    }

    /**
     * @param User $user
     * @param Request $request
     * @return bool|\Spatie\MediaLibrary\Models\Media
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function updateOrCreate_avatar(User $user, Request $request) {
        $defaultMedia = 'https://ui-avatars.com/api/?' . http_build_query(['name' => $user->name, 'size' => '500']);
        return GeneralHelperFunctions::updateOrCreate_singleMedia_viaDropZone($user, $request->input('avatar'),  $defaultMedia);
    }
}
