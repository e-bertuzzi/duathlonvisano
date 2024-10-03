<?php

namespace Database\Factories;

use App\Models\Athlete;
use App\Models\Category;
use App\Models\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteFactory extends Factory
{
    protected $model = Athlete::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->date(),
            'race_id' => Race::factory(),
            'category_id' => Category::factory(),
        ];
    }
}

