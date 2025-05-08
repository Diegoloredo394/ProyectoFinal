<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">Recetas</h2>
    </x-slot>
  
    <div class="p-4">
      <!-- Botón para crear nueva receta -->
      <a href="{{ route('recipes.create') }}"
         class="inline-block mb-4 px-4 py-2 bg-green-900 text-white rounded hover:bg-green-800">
        Nueva Receta
      </a>
  
      <!-- Grid de recetas -->
      <div class="grid grid-cols-2 gap-4">
        @foreach($recipes as $recipe)
          <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
            <h3 class="text-lg font-bold">{{ $recipe->name }}</h3>
            <p class="text-sm text-gray-600 mt-1">
              {{ Str::limit($recipe->description, 100) }}
            </p>
            <a href="{{ route('recipes.show', $recipe) }}"
               class="mt-2 inline-block text-temu-900 hover:underline hover:text-green-800">
              Ver detalles
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </x-app-layout>