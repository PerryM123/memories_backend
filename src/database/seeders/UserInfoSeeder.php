<?php

namespace Database\Seeders;

use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserInfo::insert([
            [
                'user_id' => 1,
                'user_name' => 'john',
                'password' => bcrypt('111'),
                'profile_image_url' => 'https://s3-url-example-url/1/here/rank1.jpg',
                'fcm_token' => 'fQ9UGsd3g30ZsDdI5v3YUz:APA91bEbD_4eG4Jvtxx8k-H4Fw_a9m1T69jv0kc5k9cA1',
            ],
            [
                'user_id' => 2,
                'user_name' => 'bill',
                'password' => bcrypt('222'),
                'profile_image_url' => 'https://s3-url-example-url/1/here/rank2.jpg',
                'fcm_token' => 'd1gKHJs41L12MGwPr6nBl9:APA91bFy_7Bpl9vVNCvhOeHQtD7wFb2XbhlJHKd8o5lmH',
            ],
            [
                'user_id' => 3,
                'user_name' => 'selena',
                'password' => bcrypt('333'),
                'profile_image_url' => 'https://s3-url-example-url/1/here/rank3.jpg',
                'fcm_token' => 'd2kJWhw0e28zODt8s23bn0:APA91bEiSh_hUu9ik_z5Hfj-QT6V4shB4Y42uH6BQW9Fx',
            ],
        ]);
    }
}
