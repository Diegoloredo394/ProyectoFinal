<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PlanController;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas de Auth (login, register, logout, reset, etc.)
require __DIR__.'/auth.php';

// Dashboard genérico: redirige según rol
Route::middleware('auth')->get('/dashboard', [HomeController::class, 'index'])
     ->name('dashboard');

// Rutas para Admin (Nutricionista)
Route::middleware('auth')->group(function () {
    // Gestión de recetas
    Route::resource('recipes', RecipeController::class);

    // Gestión de ingredientes
    Route::resource('ingredients', IngredientController::class);

    // Crear un plan (formulario) y guardarlo
    Route::get('plans/create', [PlanController::class, 'create'])
         ->name('plans.create');
    Route::post('plans', [PlanController::class, 'store'])
         ->name('plans.store');
});

// Rutas para Member (Usuario)
Route::middleware('auth')->group(function () {
    // Listar todos sus planes
    Route::get('plans', [PlanController::class, 'index'])
         ->name('plans.index');

    // Mostrar un plan y descargar su PDF
    Route::get('plans/{plan}', [PlanController::class, 'show'])
         ->name('plans.show');
    Route::get('plans/{plan}/pdf', [PlanController::class, 'pdf'])
         ->name('plans.pdf');
});
