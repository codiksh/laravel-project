<?php

namespace App\Repositories\Admin;

use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

/**
 * Class RoleRepository
 * @package App\Repositories\Admin
 * @version February 12, 2022, 8:00 pm IST
*/

class RoleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return Role::class;
    }

    /**
     * request handler for store and update
     * @param Request $request
     * @return array
     */
    public static function requestHandler(Request $request)
    {
        return [];
    }
}
