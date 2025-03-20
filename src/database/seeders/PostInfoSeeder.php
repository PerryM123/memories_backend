<?php

namespace Database\Seeders;

use App\Models\PostInfo;
use Illuminate\Database\Seeder;

class PostInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostInfo::insert([
            [
                'post_info_id' => 1,
                'user_id' => 1,
                'message_title' => 'Test Post1',
                'message_text' => 'this is a message text1',
                // TODO: change to UTC at some point
                'post_date' => '2025/1/5',
                'frame_type' => 'normal',
                'is_edited' => false,
                'is_deleted' => false
            ],
            [
                'post_info_id' => 2,
                'user_id' => 1,
                'message_title' => 'Test Post2',
                'message_text' => 'this is a message text2',
                // TODO: change to UTC at some point
                'post_date' => '2025/1/6',
                'frame_type' => 'normal',
                'is_edited' => true,
                'is_deleted' => false
            ],
            [
                'post_info_id' => 3,
                'user_id' => 2,
                'message_title' => 'Test Post3',
                'message_text' => 'this is a message text3',
                // TODO: change to UTC at some point
                'post_date' => '2025/1/9',
                'frame_type' => 'normal',
                'is_edited' => false,
                'is_deleted' => true
            ],
        ]);
    }
}
