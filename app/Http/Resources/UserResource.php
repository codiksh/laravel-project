<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * Class StickerResource
 * @mixin User
 * @package App\Http\Resources
 */
class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request) {
        return array_merge($this->only([
            'name',
            'email',
            'mobile',
            'uuid',
        ]), [
            'roles' => $this->getRoleNames()->join(', '),
        ]);
    }
}
