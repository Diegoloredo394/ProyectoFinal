<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['user_id','name','start_date','end_date'];

    // Relación con recetas (pivot plan_recipe)
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)
                    ->withPivot('day_of_week')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
