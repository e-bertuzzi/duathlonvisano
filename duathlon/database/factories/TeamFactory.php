<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Category;
use App\Models\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'name' => 'Team ' . $this->faker->word,
            'race_id' => Race::factory(),
            'category_id' => Category::factory(),
        ];
    }
}

