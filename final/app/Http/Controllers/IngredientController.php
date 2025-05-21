<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IngredientController extends Controller
{
    /**
     * AJAX: devuelve sugerencias de Spoonacular.
     */
public function search(Request $request)
{
    $q = $request->get('q', '');
    if (strlen($q) < 2) {
        return response()->json([]);
    }

    $apiKey = config('services.spoonacular.key');
    $url    = config('services.spoonacular.autocomplete_url');

    $resp = Http::withOptions([
        'verify'  => false,   // DESACTIVA la verificación SSL
        'timeout' => 5,       // opcional, corta la petición si tarda >5s
    ])->get($url, [
        'apiKey' => $apiKey,
        'query'  => $q,
        'number' => 10,
    ]);

    if (! $resp->ok()) {
        return response()->json([], $resp->status());
    }

    $names = collect($resp->json())->pluck('name')->all();
    return response()->json($names);
}
}
