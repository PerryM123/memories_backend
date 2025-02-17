<?php

namespace Database\Factories;

use App\Models\RankInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ranking_categories_id' => $this->faker->word(),
            'rank_number' => $this->faker->randomNumber(),
            'title' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl()
        ];
    }
}
