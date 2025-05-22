<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-semibold text-white">Recetas</h2>
    </div>
  </x-slot>

  <div class="p-6 min-h-screen">
    <!-- Botón para crear nueva receta -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('recipes.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-[#60492C] text-white text-sm font-semibold rounded-lg shadow hover:bg-[#463F1A] transition duration-200">
            ➕ Nueva Receta
        </a>
    </div>

    <!-- Grid de recetas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <div class="bg-[#463F1A] rounded-xl shadow-md hover:shadow-lg transition duration-200 p-5 transform transition duration-300 hover:scale-105 hover:shadow-lg">
                <h3 class="text-xl font-semibold text-white mb-2">{{ $recipe->name }}</h3>
                <p class="text-gray-400 text-sm mb-4">
                    {{ Str::limit($recipe->description, 100) }}
                </p>
                <a href="{{ route('recipes.show', $recipe) }}"
                   class="text-[#A6A15E] font-medium hover:underline">
                    🔍 Ver detalles
                </a>
            </div>
        @endforeach
    </div>
</div>

</x-app-layout>
