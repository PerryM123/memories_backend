<?php

namespace Database\Seeders;

use App\Models\ReceiptInfo;
use Illuminate\Database\Seeder;

class ReceiptInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReceiptInfo::insert([
            [
                'receipt_id' => 1,
                'title' => 'OKスーパー 2025/4/5（土）',
                'image_url' => 'https://some-url-here.com/1.jpg',
                'user_who_paid' => 'perry',
                'total_amount' => 2304,
                'person_1_amount' => 1200,
                'person_2_amount' => 1104,
                'created_at' => '2025-05-11 02:49:03',
                'updated_at' => '2025-05-11 02:49:03'
            ],
            [
                'receipt_id' => 2,
                'title' => 'OKスーパー 2025/4/2（水）',
                'image_url' => 'https://some-url-here.com/2.jpg',
                'user_who_paid' => 'hannah',
                'total_amount' => 4129,
                'person_1_amount' => 2200,
                'person_2_amount' => 1929,
                'created_at' => '2025-05-13 02:49:03',
                'updated_at' => '2025-05-13 02:49:03'
            ],
            [
                'receipt_id' => 3,
                'title' => 'OKスーパー 2025/4/1（水）',
                'image_url' => 'https://some-url-here.com/3.jpg',
                'user_who_paid' => 'hannah',
                'total_amount' => 7777,
                'person_1_amount' => 2000,
                'person_2_amount' => 5777,
                'created_at' => '2025-05-17 02:49:03',
                'updated_at' => '2025-05-17 02:49:03'
            ]
        ]);
    }
}
