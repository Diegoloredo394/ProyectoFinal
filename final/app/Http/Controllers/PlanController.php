<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Recipe;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // Listado para el miembro
    public function index()
    {
        if (auth()->user()->role !== 'member') {
            abort(403);
        }
        $plans = auth()->user()->plans()->with('recipes')->get();
        return view('plans.index', compact('plans'));
    }

    // Mostrar formulario de creación (solo admin)
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $recipes = Recipe::all();
        return view('plans.create', compact('recipes'));
    }

    // Guardar nuevo plan (admin)
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'recipes'    => 'array', // ids de recetas
        ]);

        $plan = Plan::create($data);
        if (!empty($data['recipes'])) {
            // day_of_week vendrá junto en request, p.ej. recipes[Mon] = [1,2]
            foreach ($data['recipes'] as $day => $ids) {
                foreach ($ids as $rid) {
                    $plan->recipes()->attach($rid, ['day_of_week' => $day]);
                }
            }
        }

        return redirect()->route('plans.index')
                         ->with('success','Plan creado correctamente');
    }

    // Para miembros o admin, ver un plan concreto
    public function show(Plan $plan)
    {
        if (
            auth()->user()->role === 'admin' ||
            (auth()->user()->role === 'member' && $plan->user_id === auth()->id())
        ) {
            $plan->load('recipes');
            return view('plans.show', compact('plan'));
        }
        abort(403);
    }

    // Generar PDF (ejemplo)
    public function pdf(Plan $plan)
    {
        // Lógica similar: validaciones de rol, luego
        $pdf = \PDF::loadView('plans.pdf', compact('plan'));
        return $pdf->download("Plan-{$plan->id}.pdf");
    }

    //  recordatorio por correo…
}
