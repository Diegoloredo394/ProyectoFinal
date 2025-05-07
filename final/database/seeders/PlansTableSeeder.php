<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\User;
use App\Models\Recipe;
use Carbon\Carbon;

class PlansTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role','member')->first();
        $start = Carbon::today();
        $plan = Plan::create([
            'user_id'    => $user->id,
            'name'       => 'Plan Semanal Ejemplo',
            'start_date' => $start,
            'end_date'   => $start->copy()->addDays(6),
        ]);

        // Asignar recetas a días
        $mondRecipe = Recipe::where('name','Avena con Plátano')->first();
        $wedRecipe  = Recipe::where('name','Pollo, Arroz y Brócoli')->first();

        $plan->recipes()->attach([
            $mondRecipe->id => ['day_of_week'=>'Mon'],
            $wedRecipe->id  => ['day_of_week'=>'Wed'],
        ]);
    }
}

