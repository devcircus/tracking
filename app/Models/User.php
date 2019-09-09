<?php

namespace App\Models;

use App\Policies\ItemPolicy;
use App\Policies\InventoryPolicy;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Collection;

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
    protected $casts = [
        'is_admin' => 'boolean',
        'is_artist' => 'boolean',
    ];

    /** @var array */
    protected static $recordEvents = [];

    /**
     * A user has many posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Order query by user name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByName($builder)
    {
        $builder->orderBy('name');
    }

    /**
     * Filter the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  array  $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
     * Create a user with the provided data.
     *
     * @param  array  $user
     *
     * @return \App\Models\User
     */
    public function createUser(array $user)
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
     *
     * @return \App\Models\User
     */
    public function deleteUser()
    {
        return tap($this, function ($instance) {
            return $this->delete();
        });
    }

    /**
     * Restore a deleted user.
     *
     * @return \App\Models\User
     */
    public function restoreUser()
    {
        return tap($this, function ($instance) {
            return $this->restore();
        });
    }

    /**
     * Update user data.
     *
     * @param  array  $data
     */
    public function updateUserData(array $data): User
    {
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

    public function getAuthorizationDetails()
    {
        return [
            InventoryPolicy::ADMINISTER => $this->can(InventoryPolicy::ADMINISTER, Tag::class),
            InventoryPolicy::ACTIVATE => $this->can(InventoryPolicy::ACTIVATE, Tag::class),
            InventoryPolicy::RESTORE => $this->can(InventoryPolicy::RESTORE, Tag::class),
            InventoryPolicy::FINISH => $this->can(InventoryPolicy::FINISH, Tag::class),
            InventoryPolicy::DELETE => $this->can(InventoryPolicy::DELETE, Tag::class),
            ItemPolicy::ADMINISTER => $this->can(ItemPolicy::ADMINISTER, InventoryItem::class),
            ItemPolicy::DELETE => $this->can(ItemPolicy::DELETE, InventoryItem::class),
            ItemPolicy::RESTORE => $this->can(ItemPolicy::RESTORE, InventoryItem::class),
            ItemPolicy::UPDATE => $this->can(ItemPolicy::UPDATE, InventoryItem::class),
            ItemPolicy::CREATE => $this->can(ItemPolicy::CREATE, InventoryItem::class),
        ];
    }
}
