<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">{{ $recipe->name }}</h2>
    </x-slot>
  
    <div class="m-6 p-6 bg-[#e7dbcb] rounded-xl shadow-md space-y-6">
        <!-- Descripción -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">📝 Descripción</h3>
            <p class="text-gray-700 text-sm leading-relaxed">{{ $recipe->description }}</p>
        </div>

        <!-- Pasos -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">👨‍🍳 Pasos</h3>
            <p class="text-gray-700 text-sm leading-relaxed">{{ $recipe->steps }}</p>
        </div>

        <!-- Ingredientes -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">🥄 Ingredientes</h3>
            <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                @foreach($recipe->ingredients as $ing)
                    <li>
                        {{ $ing->pivot->quantity }} {{ $ing->pivot->unit }} – {{ $ing->name }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-wrap gap-3 pt-4 border-t">
            <a href="{{ route('recipes.edit', $recipe) }}"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-500 transition">
                ✏️ Editar
            </a>

            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta receta?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 transition">
                    🗑️ Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Volver al listado -->
    <div class="mt-6 p-4">
        <a href="{{ route('recipes.index') }}"
          class="inline-flex items-center px-4 py-2 bg-[#463f1a] text-white text-sm font-medium rounded-lg hover:bg-[#60492c] transition">
            ← Volver al listado de recetas
        </a>
    </div>

</x-app-layout>