<?php

namespace Database\Seeders;

use App\Models\BoughtItemsInfo;
use Illuminate\Database\Seeder;

class BoughtItemsInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoughtItemsInfo::insert([
            [
                'bought_item_id' => 1,
                'receipt_id' => 1,
                'name' => 'ビスコフ',
                'price' => 252,
                'payer_name' => 'perry'
            ],
            [
                'bought_item_id' => 2,
                'receipt_id' => 1,
                'name' => 'レタス',
                'price' => 152,
                'payer_name' => 'perry'
            ],
            [
                'bought_item_id' => 3,
                'receipt_id' => 1,
                'name' => '牛乳',
                'price' => 159,
                'payer_name' => 'perry'
            ],
            [
                'bought_item_id' => 4,
                'receipt_id' => 2,
                'name' => '豆腐',
                'price' => 96,
                'payer_name' => 'hannah'
            ],
            [
                'bought_item_id' => 5,
                'receipt_id' => 2,
                'name' => 'キムチ',
                'price' => 156,
                'payer_name' => 'both'
            ],
            [
                'bought_item_id' => 6,
                'receipt_id' => 2,
                'name' => '大きいヨーグルト',
                'price' => 159,
                'payer_name' => 'hannah'
            ],
            [
                'bought_item_id' => 7,
                'receipt_id' => 3,
                'name' => '水',
                'price' => 97,
                'payer_name' => 'perry'
            ],
            [
                'bought_item_id' => 8,
                'receipt_id' => 3,
                'name' => 'カレー弁当',
                'price' => 399,
                'payer_name' => 'both'
            ],
            [
                'bought_item_id' => 9,
                'receipt_id' => 3,
                'name' => 'アイス',
                'price' => 121,
                'payer_name' => 'both'
            ]
        ]);
    }
}
