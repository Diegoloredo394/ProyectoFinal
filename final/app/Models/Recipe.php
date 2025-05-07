<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name','description','steps'];

    // Relación con ingredientes (pivot ingredient_recipe)
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
                    ->withPivot('quantity','unit')
                    ->withTimestamps();
    }

    // (Opcional más adelante): relación con planes
    public function plans()
    {
        return $this->belongsToMany(Plan::class)
                    ->withPivot('day_of_week')
                    ->withTimestamps();
    }
}
