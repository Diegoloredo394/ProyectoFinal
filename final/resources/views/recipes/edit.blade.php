<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">Editar Receta</h2>
  </x-slot>

  <div class="p-4 bg-white rounded shadow">
    <form action="{{ route('recipes.update', $recipe) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')

      <div>
        <label class="block font-medium text-gray-700">Nombre</label>
        <input type="text" name="name"
               value="{{ old('name', $recipe->name) }}"
               class="mt-1 block w-full border-gray-300 rounded" required>
        @error('name')<span class="text-red-600">{{ $message }}</span>@enderror
      </div>

      <div>
        <label class="block font-medium text-gray-700">Descripción</label>
        <textarea name="description" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded">{{ old('description', $recipe->description) }}</textarea>
      </div>

      <div>
        <label class="block font-medium text-gray-700">Pasos</label>
        <textarea name="steps" rows="5"
                  class="mt-1 block w-full border-gray-300 rounded">{{ old('steps', $recipe->steps) }}</textarea>
      </div>

      <h4 class="font-semibold text-gray-800">Ingredientes</h4>
      <div id="ingredients">
        @foreach($recipe->ingredients as $i => $ing)
          <div class="ingredient-group flex items-center space-x-2 mt-2">
            <input type="text" name="ingredients[{{ $i }}][name]" 
                   value="{{ old("ingredients.$i.name", $ing->name) }}"
                   class="border-gray-300 rounded px-2 py-1" required>
            <input type="number" name="ingredients[{{ $i }}][quantity]" 
                   value="{{ old("ingredients.$i.quantity", $ing->pivot->quantity) }}"
                   class="border-gray-300 rounded px-2 py-1" required>
            <input type="text" name="ingredients[{{ $i }}][unit]" 
                   value="{{ old("ingredients.$i.unit", $ing->pivot->unit) }}"
                   class="border-gray-300 rounded px-2 py-1" required>
            <button type="button" onclick="removeIngredient(this)"
                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500">
              Eliminar
            </button>
          </div>
        @endforeach
      </div>

      <button type="button" onclick="addIngredient()"
              class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
        Agregar ingrediente
      </button>

      <div class="text-right">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
          Actualizar Receta
        </button>
      </div>
    </form>
  </div>

  <div class="p-4">
    <a href="{{ route('recipes.index') }}"
       class="text-gray-700 hover:underline">
      ← Volver al listado
    </a>
  </div>

  <script>
    let ingredientIndex = {{ $recipe->ingredients->count() }};
    function addIngredient() {
      
      const container = document.getElementById('ingredients');
      const div = document.createElement('div');
      div.className = 'ingredient-group flex items-center space-x-2 mt-2';
      div.innerHTML = `
        <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="Ingrediente"
               class="border-gray-300 rounded px-2 py-1" required>
        <input type="number" name="ingredients[${ingredientIndex}][quantity]" placeholder="Cant."
               class="border-gray-300 rounded px-2 py-1" required>
        <input type="text" name="ingredients[${ingredientIndex}][unit]" placeholder="Unidad"
               class="border-gray-300 rounded px-2 py-1" required>
        <button type="button" onclick="removeIngredient(this)"
                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500">
          Eliminar
        </button>
      `;
      container.appendChild(div);
      ingredientIndex++;
     }
    function removeIngredient(btn) { 
      btn.closest('.ingredient-group')?.remove();
     }
  </script>
</x-app-layout>
