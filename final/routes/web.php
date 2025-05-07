<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;    

// Welcome
Route::get('/', fn() => view('welcome'));

// Rutas de auth (Breeze)
require __DIR__.'/auth.php';

// Dashboard genérico
Route::middleware('auth')->get('/dashboard', [HomeController::class,'index'])
     ->name('dashboard');

// Admin: recetas, ingredientes, crear planes
Route::middleware('auth')->group(function(){
    Route::resource('recipes', RecipeController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::get('plans/create', [PlanController::class,'create'])->name('plans.create');
    Route::post('plans',      [PlanController::class,'store'])->name('plans.store');
});

// Member: ver planes y PDF
Route::middleware('auth')->group(function(){
    Route::get('plans',            [PlanController::class,'index'])->name('plans.index');
    Route::get('plans/{plan}',     [PlanController::class,'show' ])->name('plans.show');
    Route::get('plans/{plan}/pdf', [PlanController::class,'pdf'   ])->name('plans.pdf');
});

// ————————————————————————————————
// ➤ Rutas de perfil (Breeze)
// ————————————————————————————————
Route::middleware('auth')->group(function(){
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');
});
