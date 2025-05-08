<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">Editar Receta</h2>
    </x-slot>
  
    <div class="p-4 bg-white rounded shadow">
      <form action="{{ route('recipes.update', $recipe) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
  
        <div>
          <label class="block font-medium text-gray-700">Nombre</label>
          <input type="text" name="name" value="{{ old('name', $recipe->name) }}"
                 class="mt-1 block w-full border-gray-300 rounded" required>
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
  
        <h4 class="font-semibold">Ingredientes</h4>
        <div id="ingredients">
          @foreach($recipe->ingredients as $index => $ing)
            <div class="ingredient-group mt-2">
              <input type="text" name="ingredients[{{ $index }}][name]" value="{{ old("ingredients.$index.name", $ing->name) }}"
                     placeholder="Nombre del ingrediente" class="border rounded px-2 py-1">
              <input type="number" name="ingredients[{{ $index }}][quantity]" value="{{ old("ingredients.$index.quantity", $ing->pivot->quantity) }}"
                     placeholder="Cantidad" class="border rounded px-2 py-1">
              <input type="text" name="ingredients[{{ $index }}][unit]" value="{{ old("ingredients.$index.unit", $ing->pivot->unit) }}"
                     placeholder="Unidad (g, ml, u...)" class="border rounded px-2 py-1">
            </div>
          @endforeach
        </div>
        <button type="button" onclick="addIngredient()" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Agregar otro ingrediente</button>
  
        <div class="text-right">
          <button type="submit"
                  class="px-6 py-2 bg-green-900 text-white rounded hover:bg-green-800">
            Actualizar Receta
          </button>
        </div>
      </form>
    </div>
  
    <div class="p-4">
      <a href="{{ route('recipes.index') }}"
         class="text-gray-700 hover:underline">
        Volver al listado de recetas
      </a>
    </div>
  
    <script>
      let ingredientIndex = {{ $recipe->ingredients->count() }};
      function addIngredient() {
        const container = document.getElementById('ingredients');
        const newGroup = document.createElement('div');
        newGroup.classList.add('ingredient-group', 'mt-2');
        newGroup.innerHTML = `
          <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="Nombre del ingrediente" class="border rounded px-2 py-1">
          <input type="number" name="ingredients[${ingredientIndex}][quantity]" placeholder="Cantidad" class="border rounded px-2 py-1">
          <input type="text" name="ingredients[${ingredientIndex}][unit]" placeholder="Unidad (g, ml, u...)" class="border rounded px-2 py-1">
        `;
        container.appendChild(newGroup);
        ingredientIndex++;
      }
    </script>
  </x-app-layout>
  