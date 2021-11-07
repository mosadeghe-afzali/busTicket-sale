<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'gender' => 'f',
                'password' => Hash::make(12345678),
                'status' => 1,
            ],
            [
                'id' => 2,
                'name' => 'super_user',
                'email' => 'super_user@gmail.com',
                'gender' => 'f',
                'password' => Hash::make(12345678),
                'status' => 1,
            ],
        ];

        User::query()->insert($data);
    }
}
