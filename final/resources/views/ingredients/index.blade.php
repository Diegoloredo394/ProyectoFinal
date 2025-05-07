<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">Ingredientes</h2>
    </x-slot>
  
    <div class="p-4">
      <!-- Botón para crear nuevo ingrediente -->
      <a href="{{ route('ingredients.create') }}"
         class="inline-block mb-4 px-4 py-2 bg-temu-900 text-white rounded hover:bg-temu-800">
        Nuevo Ingrediente
      </a>
  
      <!-- Grid de ingredientes -->
      <div class="grid grid-cols-2 gap-4">
        @foreach($ingredients as $ingredient)
          <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
            <h3 class="text-lg font-bold">{{ $ingredient->name }}</h3>
            <p class="text-sm text-gray-600 mt-1">
              Unidad: {{ $ingredient->unit ?? '—' }} | Calorías: {{ $ingredient->calories ?? '—' }}
            </p>
            <a href="{{ route('ingredients.show', $ingredient) }}"
               class="mt-2 inline-block text-temu-900 hover:underline">
              Ver detalles
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </x-app-layout>