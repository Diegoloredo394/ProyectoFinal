<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;

class RecipesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Desayuno de avena con plátano
        $r1 = Recipe::create([
            'name'=>'Avena con Plátano',
            'description'=>'Avena cocida con rodajas de plátano.',
            'steps'=>'1. Cocer avena. 2. Cortar plátano. 3. Mezclar.',
        ]);
        $r1->ingredients()->attach([
            Ingredient::where('name','Avena')->first()->id => ['quantity'=>50,'unit'=>'g'],
            Ingredient::where('name','Plátano')->first()->id => ['quantity'=>1,'unit'=>'u'],
        ]);

        // Pollo con arroz y brócoli
        $r2 = Recipe::create([
            'name'=>'Pollo, Arroz y Brócoli',
            'description'=>'Pechuga de pollo al vapor con arroz y brócoli salteado.',
            'steps'=>'1. Cocer pollo. 2. Hervir arroz. 3. Saltear brócoli.',
        ]);
        $r2->ingredients()->attach([
            Ingredient::where('name','Pechuga de pollo')->first()->id => ['quantity'=>150,'unit'=>'g'],
            Ingredient::where('name','Arroz integral')->first()->id => ['quantity'=>100,'unit'=>'g'],
            Ingredient::where('name','Brócoli')->first()->id => ['quantity'=>80,'unit'=>'g'],
        ]);

        // Más recetas similares…
    }
}
