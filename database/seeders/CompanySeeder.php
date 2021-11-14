<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
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
            'id' => 2,
           'name' => 'سیروسفر',
            'user_id' => 5,
                ],
            [
                'id' => 3,
                'name' => 'ایران پیما',
                'user_id' => 6,
            ],
        ];
        Company::query()->insert($data);
    }
}
