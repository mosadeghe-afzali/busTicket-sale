<?php

namespace App\repositories;

use App\Models\Role;

class RoleRepository
{
    // query for insert role of user in database
    public function store()
    {
        $role = Role::create(['role' => 'common_user']);

        return $role;
    }

    // finding last role inserted in database:
    public function lastRoleId()
    {
        $role = Role::query()->latest('id')->value('id');

        return $role;
    }

}
