<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pdf_path', 'race_id', 'category_id'];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class, 'team_athletes');
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
