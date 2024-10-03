<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['race_id', 'name', 'type', 'abbreviation'];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function athletes()
    {
        return $this->hasMany(Athlete::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
