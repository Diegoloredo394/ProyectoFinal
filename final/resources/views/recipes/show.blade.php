<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">{{ $recipe->name }}</h2>
    </x-slot>
  
    <div class="p-4 space-y-6 bg-white rounded shadow">
      <div>
        <h3 class="font-semibold">Descripción</h3>
        <p class="text-gray-700">{{ $recipe->description }}</p>
      </div>
  
      <div>
        <h3 class="font-semibold">Pasos</h3>
        <p class="text-gray-700">{{ $recipe->steps }}</p>
      </div>
  
      <div>
        <h3 class="font-semibold">Ingredientes</h3>
        <ul class="list-disc pl-5">
          @foreach($recipe->ingredients as $ing)
            <li>
              {{ $ing->pivot->quantity }} {{ $ing->pivot->unit }} – {{ $ing->name }}
            </li>
          @endforeach
        </ul>
      </div>
  
      <div class="flex space-x-2">
        <a href="{{ route('recipes.edit', $recipe) }}"
           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Editar
        </a>
  
        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
              onsubmit="return confirm('¿Eliminar esta receta?')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Eliminar
          </button>
        </form>
      </div>
    </div>
  
    <!-- Volver al listado -->
    <div class="p-4">
      <a href="{{ route('recipes.index') }}"
         class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
        Volver al listado de recetas
      </a>
    </div>
  </x-app-layout>