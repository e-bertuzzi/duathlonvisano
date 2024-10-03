<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'start_time'];

    public function categories()
    {
        return $this->hasMany(Category::class);
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
