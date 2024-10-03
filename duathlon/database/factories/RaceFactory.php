<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Race;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Race>
 */
class RaceFactory extends Factory
{
    protected $model = Race::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word . ' Duathlon',
            'date' => $this->faker->date(),
        ];
    }
}
