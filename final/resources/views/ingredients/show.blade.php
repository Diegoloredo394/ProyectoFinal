<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">{{ $ingredient->name }}</h2>
    </x-slot>
  
    <div class="p-4 space-y-6 bg-white rounded shadow">
      <div>
        <h3 class="font-semibold">Unidad de medida</h3>
        <p class="text-gray-700">{{ $ingredient->unit ?? 'No especificada' }}</p>
      </div>
  
      <div>
        <h3 class="font-semibold">Calorías por unidad</h3>
        <p class="text-gray-700">
          {{ $ingredient->calories !== null ? $ingredient->calories . ' kcal' : 'No disponible' }}
        </p>
      </div>
  
      @if($ingredient->image_url)
        <div>
          <h3 class="font-semibold">Imagen</h3>
          <img src="{{ $ingredient->image_url }}" alt="{{ $ingredient->name }}"
               class="w-48 h-auto rounded">
        </div>
      @endif
  
      <div>
        <h3 class="font-semibold">Recetas que usan este ingrediente</h3>
        <ul class="list-disc pl-5">
          @forelse($ingredient->recipes as $recipe)
            <li>
              <a href="{{ route('recipes.show', $recipe) }}"
                 class="text-temu-900 hover:underline">
                {{ $recipe->name }}
              </a>
              ({{ $recipe->pivot->quantity }} {{ $recipe->pivot->unit }})
            </li>
          @empty
            <li class="text-gray-600">Ninguna receta asociada.</li>
          @endforelse
        </ul>
      </div>
  
      <div class="flex space-x-2">
        <a href="{{ route('ingredients.edit', $ingredient) }}"
           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Editar
        </a>
  
        <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST"
              onsubmit="return confirm('¿Eliminar este ingrediente?')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Eliminar
          </button>
        </form>
      </div>
    </div>
  
    <!-- Botón de volver al listado -->
    <div class="p-4">
      <a href="{{ route('ingredients.index') }}"
         class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
        Volver al listado de ingredientes
      </a>
    </div>
  </x-app-layout>