<?php

namespace App\repositories;

use App\Models\User;

class UserRoleRepository
{
    // query for filling pivot table of role_user in database
    public function store($user, $role)
    {
        $userId = $user->lastUserId();
        $roleId = $role->lastRoleId();

        $userRole = User::query()->find($userId);
        $userRole->roles()->attach($roleId);

    }

}
