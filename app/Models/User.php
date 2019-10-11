<?php

namespace App\Models;

use App\Authorization\Policies;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Cache\CacheForgetService;
use App\Services\Cache\CacheForeverService;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Authenticatable implements AuthorizableContract, MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use Authorizable;
    use LogsActivity;
    use CausesActivity;

    /** @var array */
    protected $guarded = [];

    /** @var int */
    protected $perPage = 10;

    /** @var array */
    protected $appends = [
        'is_super_admin',
    ];

    /** @var array */
    protected $casts = [
        'is_admin' => 'boolean',
        'is_artist' => 'boolean',
    ];

    /** @var array */
    protected static $recordEvents = [];

    /**
     * A user has many posts.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Order query by user name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public function scopeOrderByName($builder): Builder
    {
        return $builder->orderBy('name');
    }

    /**
     * Filter the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  array  $filters
     *
     * @return mixed
     */
    public function scopeFilter($builder, array $filters)
    {
        $builder->when($filters['search'] ?? null, function ($builder, $search) {
            $builder->where(function ($builder) use ($search) {
                $builder->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($builder, $trashed) {
            if ('with' === $trashed) {
                $builder->withTrashed();
            } elseif ('only' === $trashed) {
                $builder->onlyTrashed();
            }
        });
    }

    /**
     * Get the is_super_admin attribute.
     */
    public function getIsSuperAdminAttribute(): bool
    {
        return $this->email === config('auth.admin.email');
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }

    /**
     * Get all users who are administrators.
     */
    public function administrators(): Collection
    {
        return $this->where('is_admin', true)->get();
    }

    /**
     * Get the super-administrator.
     */
    public function superAdministrator(): User
    {
        $administrators = $this->administrators();

        return $administrators->where('is_super_admin', true)->first();
    }

    /**
     * Create a user with the provided data.
     *
     * @param  array  $user
     */
    public function createUser(array $user): User
    {
        return $this->create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => bcrypt($user['password']),
            'is_admin' => $user['is_admin'],
            'is_artist' => $user['is_artist'],
        ]);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(): User
    {
        return tap($this, function ($instance) {
            return $instance->delete();
        });
    }

    /**
     * Restore a deleted user.
     */
    public function restoreUser(): User
    {
        return tap($this, function ($instance) {
            return $instance->restore();
        });
    }

    /**
     * Update user data.
     *
     * @param  array  $data
     */
    public function updateUserData(array $data): User
    {
        CacheForgetService::call('policies', $this->email);

        return tap($this, function ($user) use ($data) {
            return $user->update($data);
        })->fresh();
    }

    /**
     * Update user password.
     *
     * @param  array  $data
     */
    public function updateUserPassword(array $data): User
    {
        return tap($this, function ($user) use ($data) {
            return $user->update([
                'password' => bcrypt($data['password']),
            ]);
        })->fresh();
    }

    /**
     * Get the authorization details for the User.
     */
    public function getAuthorizationDetails(): array
    {
        return CacheForeverService::call('policies', function () {
            $policies = resolve(Policies::class)->getPolicies();

            $can = [];

            foreach ($policies as $key => $policy) {
                $can[$policy] = $this->can($policy);
            }

            return $can;
        }, $this->email);
    }
}
