<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListUsersService
{
    use SelfCallingService;

    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new ListUsersService.
     *
     * @param  \App\Models\User  $users
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $keys
     */
    public function run(array $keys): Collection
    {
        return $this->users->orderByName()->filter($keys)
            ->get()
            ->transform(static function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'deleted_at' => $user->deleted_at,
                ];
            });
    }
}
