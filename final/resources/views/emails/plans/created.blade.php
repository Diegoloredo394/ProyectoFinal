@component('mail::message')
# Nuevo plan semanal creado

Hola {{ $plan->user->name }},

Adjunto encontrarás tu plan **{{ $plan->name }}** ({{ $plan->start_date }} – {{ $plan->end_date }}) en formato PDF.

Gracias por usar Meal Planner!

@endcomponent
