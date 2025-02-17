<?php

namespace Database\Seeders;

use App\Models\RankingPost;
use Illuminate\Database\Seeder;

class RankingPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: create is for flat and simple attributes
        RankingPost::create([
            'title' => 'The Best Books of 2024',
            'author' => 'Perry',
            'ranking_info' => json_encode([
                [
                    'title' => 'Hamazushi',
                    'image' => 'https://perry.com/1.jpg'
                ],
                [
                    'title' => 'Chocolate',
                    'image' => 'https://perry.com/2.jpg'
                ],
                [
                    'title' => 'Ice cream',
                    'image' => 'https://perry.com/3.jpg'
                ]
            ])
        ]);
    }
}
