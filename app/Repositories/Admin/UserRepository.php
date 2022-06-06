<?php

namespace App\Repositories\Admin;

use App\MyClasses\GeneralHelperFunctions;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
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
    public static function requestHandler(ParameterBag $request)
    {
        if($request->has('password') && !is_null($request->get('password'))){
            $request->set('password', bcrypt($request->get('password')));
        }else{
            $request->remove('password');
        }
        if($user = $request->get('user')){
            //When Edit Request
            if(! $user->hasMedia('avatar') && ! request()->hasFile('avatar')){
                $request->set('provideDefaultAvatar', true);
            }
        }else{
            //When create request
            if(! request()->hasFile('avatar')){
                $request->set('provideDefaultAvatar', true);
            }
        }

        return $request->all();
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
