<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = ['race_id', 'category_id', 'athlete_id', 'team_id', 'arrival_time', 'position'];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
