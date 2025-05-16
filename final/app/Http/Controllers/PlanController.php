<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Mail\PlanCreated;
use Illuminate\Support\Facades\Mail;


class PlanController extends Controller
{
    // 1. Formulario de creación (solo admin)
    public function create()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $recipes = Recipe::all();
        return view('plans.create', compact('recipes'));
    }

        // 2. Guardar nuevo plan (solo admin)
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'recipes'    => 'array',
            'recipes.*'  => 'array',
            'recipes.*.*'=> 'integer|exists:recipes,id',
        ]);

        $plan = Plan::create([
            'user_id'    => $data['user_id'],             // ← asignación real
            'name'       => 'Plan '.$data['start_date'].' - '.$data['end_date'],
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
        ]);

        // adjuntar recetas…
        foreach ($data['recipes'] as $day => $ids) {
            foreach ($ids as $rid) {
                $plan->recipes()->attach($rid, ['day_of_week' => $day]);
            }
        }

        // enviar correo…
        Mail::to(env('PROVIDER_EMAIL'))->send(new PlanCreated($plan));

        return redirect()
            ->route('plans.index')
            ->with('success','Plan creado y correo enviado correctamente');
    }


    // 3. Listado de planes (admin y member)
    public function index()
    {
        if (auth()->user()->role === 'member') {
            // solo sus propios planes
            $plans = auth()->user()->plans()->with('recipes')->get();
        } else {
            // admin ve todos
            $plans = Plan::with('recipes','user')->get();
        }

        return view('plans.index', compact('plans'));
    }

    // 4. Detalle de un plan
    public function show(Plan $plan)
    {
        if (auth()->user()->role === 'member') {
            // miembros solo ven los suyos
            abort_unless($plan->user_id === auth()->id(), 403);
        }
        // admin puede ver cualquiera
        $plan->load('recipes');
        return view('plans.show', compact('plan'));
    }

    // 5. PDF de un plan
    public function pdf(Plan $plan)
    {
        if (auth()->user()->role === 'member') {
            abort_unless($plan->user_id === auth()->id(), 403);
        }
        $plan->load('recipes');
        $pdf = PDF::loadView('plans.pdf', compact('plan'));
        return $pdf->download("plan-{$plan->id}.pdf");
    }


    public function edit(Plan $plan)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $recipes = Recipe::all();
        return view('plans.edit', compact('plan','recipes'));
    }

    /**
     * Procesa la actualización (solo admin).
     */
    public function update(Request $request, Plan $plan)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'recipes'    => 'array',
            'recipes.*'  => 'array',
            'recipes.*.*'=> 'integer|exists:recipes,id',
        ]);

        $plan->update([
            'user_id'    => $data['user_id'],             // ← posible reasignación
            'name'       => 'Plan '.$data['start_date'].' - '.$data['end_date'],
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
        ]);

        // resetear y volver a adjuntar recetas…
        $plan->recipes()->detach();
        foreach ($data['recipes'] as $day => $ids) {
            foreach ($ids as $rid) {
                $plan->recipes()->attach($rid, ['day_of_week' => $day]);
            }
        }

        return redirect()
            ->route('plans.index')
            ->with('success','Plan actualizado correctamente');
    }

    /**
     * Elimina un plan (solo admin).
     */
    public function destroy(Plan $plan)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $plan->delete();

        return redirect()
            ->route('plans.index')
            ->with('success','Plan eliminado correctamente');
    }

}
