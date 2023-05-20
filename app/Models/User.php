<?php

namespace App\Models;

use App\MyClasses\GeneralHelperFunctions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $mobile
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $avatar_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User findWithUuid($uuid, $with = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia, SoftDeletes;

    use HasRoles {
        hasPermissionTo as hasPermissionToOriginal;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validation Rules
     * @var array
     */
    public static $rules = [
        'avatar' => 'nullable',
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
        'mobile' => 'nullable|integer|digits:10',
        'password' => 'required',
        'role' => 'required|array',
        'role.*' => 'required|string|exists:roles,name',
    ];

    /**
     * Changing route key name
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }


    /**
     * Things require during the boot
     */
    protected static function boot()
    {
        parent::boot();

        //Auto-adding uuid to newly created instances
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }


    /**
     * Things require after the boot
     */
    protected static function booted() {
        parent::booted();


        static::creating(function(User $user){
        });
    }

    /**
     * Overridden as suggested at https://github.com/spatie/laravel-permission/issues/1156#issue-466659658 and
     *  https://github.com/spatie/laravel-permission/issues/1156#issuecomment-617439518 for single guard over roles and permissions
     * @param $permission
     * @param string $guardName
     * @return bool
     */
    public function hasPermissionTo($permission, $guardName = 'web'): bool {
        return $this->hasPermissionToOriginal($permission, $guardName);
    }

    /**
     * Overridden as suggested at https://github.com/spatie/laravel-permission/issues/1156#issue-466659658 for single guard over roles and permissions
     * @return string
     */
    protected function getDefaultGuardName(): string {
        return 'web';
    }

    /**
     * Get Object by UUID
     *
     * @param $query
     * @param $uuid
     * @param array $with
     * @return mixed
     */
    public function scopeFindWithUuid($query,$uuid,$with = []){
        return $query->where('uuid',$uuid)->with($with)->firstOrFail();
    }

    /**
     * Returns avatar url
     * @return mixed
     */
    public function getAvatarUrlAttribute(){
        return GeneralHelperFunctions::getSingleMediaUrls($this, 'users');
    }

    /**
     * Registering media collection
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType,['image/gif','image/png','image/jpeg']);
            })
            ->withResponsiveImages()
            ->singleFile();
    }

    /**
     * Register Media Conversions.
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb_100x100')
            ->width(100)
            ->height(100)
            ->nonQueued()
            ->keepOriginalImageFormat()
            ->performOnCollections('avatar');

        $this->addMediaConversion('thumb_250x250')
            ->width(250)
            ->height(250)
            ->nonQueued()
            ->keepOriginalImageFormat()
            ->performOnCollections('avatar');
    }

}
