<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name','unit','calories','image_url'];

    // Relación con recetas (pivot ingredient_recipe)
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)
                    ->withPivot('quantity','unit')
                    ->withTimestamps();
    }
}
