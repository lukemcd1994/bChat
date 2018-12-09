<?php

use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chats')->insert([
            [
                'user1_id' => 1,
                'user2_id' => 2,
                'delete_at' => '2018-12-20 00:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'pending' => 0,
                'pending_secret' => uniqid('', true)
            ],
            [
                'user1_id' => 1,
                'user2_id' => 2,
                'delete_at' => '2018-12-20 00:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'pending' => 1,
                'pending_secret' => uniqid('', true)
            ],
            [
                'user1_id' => 1,
                'user2_id' => 2,
                'delete_at' => '2018-12-20 00:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'pending' => 1,
                'pending_secret' => uniqid('', true)
            ]
        ]);
    }
}
