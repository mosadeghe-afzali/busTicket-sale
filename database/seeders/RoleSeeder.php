<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'role' => 'admin',
            ],
            [
                'id' => 2,
                'role' => 'super_user',
            ],
            [
                'id' => 3,
                'role' => 'company'
            ],
            [
                'id' => 4,
                'role' => 'common_user',
            ],

        ];

        Role::query()->insert($data);
    }
}
