<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">
      {{ $plan->name }} ({{ $plan->start_date }} – {{ $plan->end_date }})
    </h2>
  </x-slot>

  <div class="p-4 space-y-6 bg-white rounded shadow">
    @php
      $days = ['Mon'=>'Lunes','Tue'=>'Martes','Wed'=>'Miércoles',
               'Thu'=>'Jueves','Fri'=>'Viernes','Sat'=>'Sábado','Sun'=>'Domingo'];
    @endphp

    @foreach($days as $code => $day)
      @php
        $dayRecipes = $plan->recipes->filter(fn($r)=> $r->pivot->day_of_week === $code);
      @endphp
      <div>
        <h3 class="font-semibold text-gray-800">{{ $day }}</h3>
        @if($dayRecipes->isEmpty())
          <p class="text-gray-600">Sin recetas asignadas</p>
        @else
          <ul class="list-disc pl-5 text-gray-700">
            @foreach($dayRecipes as $r)
              <li>{{ $r->name }}</li>
            @endforeach
          </ul>
        @endif
      </div>
    @endforeach
  </div>

  <div class="mt-4 p-4 flex space-x-2">
    <a href="{{ route('plans.index') }}"
       class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
      Volver a mis planes
    </a>
    <a href="{{ route('plans.pdf', $plan) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
      Descargar PDF
    </a>
  </div>
</x-app-layout>