<?php
namespace App\repositories;

use App\Models\User;

class UserRepository
{
    /**
     * query for insert a user in database.
     *
     * @param array $data
     */
    public function store($data)
    {
       return User::create($data);
    }

    /**
     * finding last user inserted in database.
     *
     * @return mixed
     */
    public function lastUserId()
    {
        return User::query()->latest('id')->value('id');
    }

    /**
     * finding user with requested email in database.
     *
     * @param string $email
     * @return
     */
    public function checkUser($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }
}
