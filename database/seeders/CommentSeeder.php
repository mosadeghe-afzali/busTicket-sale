<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
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
                'content' => 'سایت بسیار خوبی است و امکانات خیلی خوبی دارد',
                'company_id' => 1
            ],
            [
                'id' => 2,
                'content' => 'خیلی خوب و حرفه ای است',
                'company_id' => 2
            ],

        ];

        Comment::query()->insert($data);
    }
}
