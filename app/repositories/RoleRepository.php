<?php

namespace App\repositories;

use App\Models\Role;

class RoleRepository
{
    /**
     *  query for insert role of user in database.
     *
     */
    public function store()
    {
         Role::create(['role' => 'common_user']);
    }

    /**
     * finding last role inserted in database.
     *
     * @return int
     */
    public function lastRoleId()
    {
        return Role::query()->latest('id')->value('id');
    }
}
