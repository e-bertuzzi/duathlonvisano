<?php

namespace Database\Factories;

use App\Models\TeamAthlete;
use App\Models\Team;
use App\Models\Athlete;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamAthleteFactory extends Factory
{
    protected $model = TeamAthlete::class;

    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'athlete_id' => Athlete::factory(),
        ];
    }
}

