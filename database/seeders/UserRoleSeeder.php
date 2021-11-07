<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
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
                'user_id' => 1,
                'role_id' => 1
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'role_id' => 2
            ],

        ];

        DB::table('role_user')->insert($data);
    }
}
