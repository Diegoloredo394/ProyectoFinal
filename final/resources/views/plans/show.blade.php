<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-white">
      {{ $plan->name }} ({{ $plan->start_date }} – {{ $plan->end_date }})
    </h2>
  </x-slot>

  <div class="m-6 p-6 bg-white rounded-xl shadow-md space-y-6">
    <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">Plan Semanal</h2>

    @php
        $days = [
            'Mon' => 'Lunes', 'Tue' => 'Martes', 'Wed' => 'Miércoles',
            'Thu' => 'Jueves', 'Fri' => 'Viernes', 'Sat' => 'Sábado', 'Sun' => 'Domingo'
        ];
    @endphp

    @foreach($days as $code => $day)
        @php
            $dayRecipes = $plan->recipes->filter(fn($r) => $r->pivot->day_of_week === $code);
        @endphp

        <div class="p-4 rounded bg-gray-50 border">
            <h3 class="text-lg font-semibold text-indigo-700 mb-2">{{ $day }}</h3>

            @if($dayRecipes->isEmpty())
                <p class="text-gray-500 italic">Sin recetas asignadas</p>
            @else
                <ul class="list-disc pl-6 space-y-1 text-gray-700">
                    @foreach($dayRecipes as $r)
                        <li>{{ $r->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
</div>

<div class="mt-6 px-6 flex justify-end space-x-3">
    <a href="{{ route('plans.index') }}"
       class="px-4 py-2 mb-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
        ← Volver a mis planes
    </a>

    <a href="{{ route('plans.pdf', $plan) }}"
       class="px-4 py-2 mb-2 bg-[#463f1a] text-white rounded-lg hover:bg-[#60492C] transition">
        Descargar PDF
    </a>
</div>

</x-app-layout>