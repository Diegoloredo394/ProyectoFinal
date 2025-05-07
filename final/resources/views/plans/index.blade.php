<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">
        {{ auth()->user()->role === 'admin' ? 'Gestionar Planes' : 'Mis Planes' }}
      </h2>
    </x-slot>
  
    <div class="p-4 flex justify-between items-center">
      <h3 class="text-lg">{{ auth()->user()->role === 'admin' ? '' : 'Planes disponibles' }}</h3>
  
      @if(auth()->user()->role === 'admin')
        <a href="{{ route('plans.create') }}"
           class="px-4 py-2 bg-temu-900 text-white rounded hover:bg-temu-800">
          Nuevo Plan
        </a>
      @endif
    </div>
  
    <div class="p-4 grid grid-cols-2 gap-4">
      @foreach($plans as $plan)
        <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
          <h4 class="font-bold">{{ $plan->name }}</h4>
          <p class="text-gray-600 text-sm">
            {{ $plan->start_date }} al {{ $plan->end_date }}
          </p>
          <div class="mt-2 space-x-2">
            <a href="{{ route('plans.show', $plan) }}"
               class="text-temu-900 hover:underline">Ver</a>
            <a href="{{ route('plans.pdf', $plan) }}"
               class="text-temu-900 hover:underline">PDF</a>
          </div>
        </div>
      @endforeach
    </div>
  </x-app-layout>