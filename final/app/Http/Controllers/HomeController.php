<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('recipes.index');
        }

        // Para el miembro, redirige al listado de sus planes
        return redirect()->route('plans.index');
    }
}
