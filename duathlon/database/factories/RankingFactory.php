<?php

namespace Database\Factories;

use App\Models\Ranking;
use App\Models\Race;
use App\Models\Category;
use App\Models\Athlete;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankingFactory extends Factory
{
    protected $model = Ranking::class;

    public function definition()
    {
        return [
            'race_id' => Race::factory(),
            'category_id' => Category::factory(),
            'athlete_id' => Athlete::factory(),
            'team_id' => Team::factory(),
            'position' => $this->faker->numberBetween(1, 100),
        ];
    }
}

