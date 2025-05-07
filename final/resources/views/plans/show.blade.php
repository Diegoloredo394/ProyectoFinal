<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">
        {{ $plan->name }} ({{ $plan->start_date }} – {{ $plan->end_date }})
      </h2>
    </x-slot>
  
    <div class="p-4 space-y-6 bg-white rounded shadow">
      @foreach(['Mon'=>'Lunes','Tue'=>'Martes','Wed'=>'Miércoles','Thu'=>'Jueves','Fri'=>'Viernes','Sat'=>'Sábado','Sun'=>'Domingo'] as $code=>$day)
        @php
          $dayRecipes = $plan->recipes->filter(fn($r) => $r->pivot->day_of_week === $code);
        @endphp
        <div>
          <h3 class="font-semibold text-gray-800">{{ $day }}</h3>
          @if($dayRecipes->isEmpty())
            <p class="text-gray-600">No hay recetas asignadas.</p>
          @else
            <ul class="list-disc pl-5">
              @foreach($dayRecipes as $r)
                <li>{{ $r->name }}</li>
              @endforeach
            </ul>
          @endif
        </div>
      @endforeach
    </div>
  
    <div class="p-4 flex space-x-2">
      <a href="{{ route('plans.index') }}"
         class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
        ← Volver a mis planes
      </a>
      <a href="{{ route('plans.pdf', $plan) }}"
         class="px-4 py-2 bg-temu-900 text-white rounded hover:bg-temu-800">
        Descargar PDF
      </a>
    </div>
  </x-app-layout>