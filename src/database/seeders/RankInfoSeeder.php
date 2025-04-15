<?php

namespace Database\Seeders;

use App\Models\RankInfo;
use Illuminate\Database\Seeder;

class RankInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RankInfo::insert([
            [
                'ranking_categories_id' => '1',
                'rank_number' => '1',
                'title' => 'Movie Title 1',
                'image_url' => 'https://s3-url-example-url/1/here/rank1.jpg'
            ],
            [
                'ranking_categories_id' => '1',
                'rank_number' => '2',
                'title' => 'Movie Title 2',
                'image_url' => 'https://s3-url-example-url/1/here/rank2.jpg'
            ],
            [
                'ranking_categories_id' => '1',
                'rank_number' => '3',
                'title' => 'Movie Title 3',
                'image_url' => 'https://s3-url-example-url/1/here/rank3.jpg'
            ],
            [
                'ranking_categories_id' => '2',
                'rank_number' => '1',
                'title' => 'Park Title 1',
                'image_url' => 'https://s3-url-example-url/1/here/rank4.jpg'
            ],
            [
                'ranking_categories_id' => '2',
                'rank_number' => '2',
                'title' => 'Park Title 2',
                'image_url' => 'https://s3-url-example-url/1/here/rank5.jpg'
            ],
            [
                'ranking_categories_id' => '2',
                'rank_number' => '3',
                'title' => 'Park Title 3',
                'image_url' => 'https://s3-url-example-url/1/here/rank6.jpg'
            ],
            [
                'ranking_categories_id' => '2',
                'rank_number' => '4',
                'title' => 'Park Title 4',
                'image_url' => 'https://s3-url-example-url/1/here/rank7.jpg'
            ],
            [
                'ranking_categories_id' => '2',
                'rank_number' => '5',
                'title' => 'Park Title 5',
                'image_url' => 'https://s3-url-example-url/1/here/rank8.jpg'
            ],
            [
                'ranking_categories_id' => '3',
                'rank_number' => '1',
                'title' => 'Song Title 1',
                'image_url' => 'https://s3-url-example-url/1/here/rank8.jpg'
            ],
            [
                'ranking_categories_id' => '3',
                'rank_number' => '2',
                'title' => 'Song Title 2',
                'image_url' => 'https://s3-url-example-url/1/here/rank8.jpg'
            ],
            [
                'ranking_categories_id' => '3',
                'rank_number' => '3',
                'title' => 'Song Title 3',
                'image_url' => 'https://s3-url-example-url/1/here/rank8.jpg'
            ],
            [
                'ranking_categories_id' => '1',
                'rank_number' => '4',
                'title' => 'Movie Title 4',
                'image_url' => 'https://s3-url-example-url/1/here/rank8.jpg'
            ]
        ]);
    }
}
