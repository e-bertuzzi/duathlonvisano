<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'race_id' => Race::factory(),
            'name' => $this->faker->randomElement(['Singolo', 'Coppia Mista', 'Coppia Maschile', 'Coppia Femminile']),
            'type' => $this->faker->randomElement(['singolo', 'coppia']),
            'abbreviation' => $this->faker->lexify('CAT-???'),
        ];
    }
}
