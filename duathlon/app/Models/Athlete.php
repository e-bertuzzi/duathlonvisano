<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'birth_date', 'pdf_path', 'race_id', 'category_id'];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_athletes');
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
