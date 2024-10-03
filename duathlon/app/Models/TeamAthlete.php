<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamAthlete extends Pivot
{
    use HasFactory;

    protected $table = 'team_athletes';
}
