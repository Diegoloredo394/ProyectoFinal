<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;

// Welcome público
Route::get('/', fn() => view('welcome'));

// Autenticación (Breeze)
require __DIR__.'/auth.php';

// Rutas protegidas
Route::middleware('auth')->group(function(){

    // Dashboard
    Route::get('/dashboard', [HomeController::class,'index'])
         ->name('dashboard');

    // ——— Ingredientes ———
    // 1) Ruta AJAX para la búsqueda inteligente
    Route::get('ingredients/search', [IngredientController::class,'search'])
         ->name('ingredients.search');

    // ——— Recetas ———
    Route::resource('recipes', RecipeController::class);

    // ——— Planes ———
    Route::get(   'plans',             [PlanController::class,'index']  )->name('plans.index');
    Route::get(   'plans/create',      [PlanController::class,'create'] )->name('plans.create');
    Route::post(  'plans',             [PlanController::class,'store']  )->name('plans.store');
    Route::get(   'plans/{plan}',      [PlanController::class,'show']   )->name('plans.show');
    Route::get(   'plans/{plan}/edit', [PlanController::class,'edit']   )->name('plans.edit');
    Route::put(   'plans/{plan}',      [PlanController::class,'update'] )->name('plans.update');
    Route::delete('plans/{plan}',      [PlanController::class,'destroy'])->name('plans.destroy');
    Route::get(   'plans/{plan}/pdf',  [PlanController::class,'pdf']    )->name('plans.pdf');

    // ——— Perfil (Breeze) ———
    Route::get(   '/profile',    [ProfileController::class,'edit'])    ->name('profile.edit');
    Route::patch( '/profile',    [ProfileController::class,'update'])  ->name('profile.update');
    Route::delete('/profile',    [ProfileController::class,'destroy']) ->name('profile.destroy');

});
