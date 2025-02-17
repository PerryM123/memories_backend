<?php

namespace Database\Seeders;

use App\Models\RankingCategories;
use Illuminate\Database\Seeder;

class RankingCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RankingCategories::insert([
            [
                'ranking_categories_id' => '1',
                'rank_title' => 'Top 4 Movies'
            ],
            [
                'ranking_categories_id' => '2',
                'rank_title' => 'Top 5 Parks'
            ],
            [
                'ranking_categories_id' => '3',
                'rank_title' => 'Top 3 Songs',
            ]
        ]);
    }
}
