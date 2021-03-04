<?php

namespace App\Models;

use App\MyClasses\GeneralHelperFunctions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $avatar_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|User findWithUuid($uuid, $with = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid'
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

    protected static function booted() {
        parent::booted();


        static::created(function(User $user){
            $user->uuid = Str::uuid()->toString();
            $user->save();

            $defaultMedia = 'https://ui-avatars.com/api/?' . http_build_query(['name' => $user->name, 'size' => '350']);
            GeneralHelperFunctions::updateOrCreate_defaultMedia($user, $defaultMedia, 'avatar', true);
        });
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
