<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientsTableSeeder extends Seeder
{
    public function run(): void
    {
        $list = [
            ['name'=>'Avena','unit'=>'g','calories'=>389],
            ['name'=>'Huevos','unit'=>'u','calories'=>78],
            ['name'=>'Pechuga de pollo','unit'=>'g','calories'=>165],
            ['name'=>'Arroz integral','unit'=>'g','calories'=>123],
            ['name'=>'Brócoli','unit'=>'g','calories'=>34],
            ['name'=>'Plátano','unit'=>'u','calories'=>89],
            ['name'=>'Almendras','unit'=>'g','calories'=>576],
            ['name'=>'Tomate','unit'=>'g','calories'=>18],
        ];

        foreach($list as $data) {
            Ingredient::create($data);
        }
    }
}
