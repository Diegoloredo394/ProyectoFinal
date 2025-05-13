<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">Crear Receta</h2>
    </x-slot>
  
    <div class="p-4 bg-white rounded shadow">
      <form action="{{ route('recipes.store') }}" method="POST" class="space-y-4">
        @csrf
  
        <div>
          <label class="block font-medium text-gray-700">Nombre</label>
          <input type="text" name="name"
                 value="{{ old('name') }}"
                 class="mt-1 block w-full border-gray-300 rounded" required>
        </div>
  
        <div>
          <label class="block font-medium text-gray-700">Descripción</label>
          <textarea name="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded">{{ old('description') }}</textarea>
        </div>
  
        <div>
          <label class="block font-medium text-gray-700">Pasos</label>
          <textarea name="steps" rows="5"
                    class="mt-1 block w-full border-gray-300 rounded">{{ old('steps') }}</textarea>
        </div>

        <h4>Ingredientes</h4>
        <div id="ingredients">
          <div class="ingredient-group">
            <input type="text" name="ingredients[0][name]" placeholder="Nombre del ingrediente" class="border rounded px-2 py-1">
            <input type="number" name="ingredients[0][quantity]" placeholder="Cantidad" class="border rounded px-2 py-1">
            <input type="text" name="ingredients[0][unit]" placeholder="Unidad (g, ml, u...)" class="border rounded px-2 py-1">
            <button type="button" onclick="removeIngredient(this)" class="px-2 py-1 bg-red-500 text-white rounded">Eliminar</button>
          </div>
        </div>
        <button type="button" onclick="addIngredient()" class="mt-2 px-4 py-2 bg-green-500 text-white rounded">Agregar otro ingrediente</button>
  
        <div class="text-right">
          <button type="submit"
                  class="px-6 py-2 bg-green-900 text-white rounded hover:bg-green-800">
            Guardar Receta
          </button>
        </div>

        <script>
          let ingredientIndex = 1;
          function addIngredient() {
            const container = document.getElementById('ingredients');
            const newGroup = document.createElement('div');
            newGroup.classList.add('ingredient-group', 'mt-2');
            newGroup.innerHTML = `
              <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="Nombre del ingrediente" class="border rounded px-2 py-1">
              <input type="number" name="ingredients[${ingredientIndex}][quantity]" placeholder="Cantidad" class="border rounded px-2 py-1">
              <input type="text" name="ingredients[${ingredientIndex}][unit]" placeholder="Unidad (g, ml, u...)" class="border rounded px-2 py-1">
              <button type="button" onclick="removeIngredient(this)" class="px-2 py-1 bg-red-500 text-white rounded">Eliminar</button>
            `;
            container.appendChild(newGroup);
            ingredientIndex++;
          }

          function removeIngredient(button) {
            const group = button.closest('.ingredient-group');
            if (group) {
              group.remove();
            }
          }
        </script>
      </form>
    </div>
  
    <div class="p-4">
      <a href="{{ route('recipes.index') }}"
         class="text-gray-700 hover:underline">
        Volver al listado de recetas
      </a>
    </div>
  </x-app-layout>