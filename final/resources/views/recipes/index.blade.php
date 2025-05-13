<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-semibold text-gray-900">Recetas</h2>
    </div>
  </x-slot>

  <div class="p-4">
    <!-- Botón para crear nueva receta -->
    <a href="{{ route('recipes.create') }}"
       class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
      Nueva Receta
    </a>

    <!-- Grid de recetas -->
    <div class="grid grid-cols-2 gap-4">
      @foreach($recipes as $recipe)
        <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
          <h3 class="text-lg font-bold text-gray-800">{{ $recipe->name }}</h3>
          <p class="text-sm text-gray-600 mt-1">
            {{ Str::limit($recipe->description, 100) }}
          </p>
          <a href="{{ route('recipes.show', $recipe) }}"
             class="mt-2 inline-block text-blue-600 hover:underline">
            Ver detalles
          </a>
        </div>
      @endforeach
    </div>
  </div>
</x-app-layout>
