<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BooksSeeder::class,
            RankingCategoriesSeeder::class,
            RankInfoSeeder::class,
            PostInfoSeeder::class,
            UserInfoSeeder::class,
            ReceiptInfoSeeder::class,
            BoughtItemsInfoSeeder::class,
        ]);
    }
}
