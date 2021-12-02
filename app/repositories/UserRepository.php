<?php
namespace App\repositories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    /* query for insert a user in database */
    public function store($data)
    {
        $user = User::create($data);
        $userId = $user->id;

        return $user;
    }

    /* finding last user inserted in database: */
    public function lastUserId()
    {
        return User::query()->latest('id')->value('id');
    }

    /* finding user with requested email in database: */
    public function checkUser($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

}
