<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo admin
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Solo admin
        abort_if(auth()->user()->role !== 'admin', 403);
        $allIngredients = Ingredient::all(); 
        return view('recipes.create', compact( 'allIngredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'steps'       => 'nullable|string',
            'ingredients' => 'nullable|array',
            'ingredients.*.name'     => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit'     => 'required|string|max:10',
        ]);

        $recipe = Recipe::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? '',
            'steps'       => $data['steps'] ?? '',
        ]);

        foreach ($data['ingredients'] ?? [] as $ing) {
            $ingredient = Ingredient::firstOrCreate(['name' => $ing['name']]);
            $recipe->ingredients()->attach($ingredient->id, [
                'quantity' => $ing['quantity'],
                'unit'     => $ing['unit'],
            ]);
        }

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Receta creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        //
        $ingredients = Ingredient::all(); 
        return view('recipes.edit', compact('recipe', 'ingredients'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
        abort_if(auth()->user()->role !== 'admin', 403);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'steps'       => 'nullable|string',
            'ingredients' => 'nullable|array',
            'ingredients.*.name'     => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit'     => 'required|string|max:10',
        ]);

        $recipe->update([
            'name'        => $data['name'],
            'description' => $data['description'] ?? '',
            'steps'       => $data['steps'] ?? '',
        ]);

        // Sincronizar ingredientes
        $syncData = [];
        foreach ($data['ingredients'] ?? [] as $ing) {
            $ingredient = Ingredient::firstOrCreate(['name' => $ing['name']]);
            $syncData[$ingredient->id] = [
                'quantity' => $ing['quantity'],
                'unit'     => $ing['unit'],
            ];
        }
        $recipe->ingredients()->sync($syncData);

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Receta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        //
        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Receta eliminada.');
    }
}
