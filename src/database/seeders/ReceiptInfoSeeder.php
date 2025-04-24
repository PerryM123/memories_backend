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
                'total_amount' => 2304
            ],
            [
                'receipt_id' => 2,
                'title' => 'OKスーパー 2025/4/2（水）',
                'image_url' => 'https://some-url-here.com/2.jpg',
                'user_who_paid' => 'hannah',
                'total_amount' => 4129
            ]
        ]);
    }
}
