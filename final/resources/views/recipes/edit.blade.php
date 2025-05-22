<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">Editar Receta</h2>
  </x-slot>

  <div class="m-6 p-6 bg-white rounded-xl shadow-md space-y-6">
    <form action="{{ route('recipes.update', $recipe) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')

      <div>
        <label class="block text-sm font-medium text-gray-800 mb-1">🍽️ Nombre</label>
        <input type="text"
               name="name"
               value="{{ old('name', $recipe->name) }}"
               class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
               required>
        @error('name')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-800 mb-1">📝 Descripción</label>
        <textarea name="description"
                  rows="3"
                  class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $recipe->description) }}</textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-800 mb-1">👨‍🍳 Pasos</label>
        <textarea name="steps"
                  rows="5"
                  class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('steps', $recipe->steps) }}</textarea>
      </div>

      <h4 class="text-md font-semibold text-gray-800 mb-2">🥄 Ingredientes</h4>
      <div id="ingredients" class="space-y-3">
        @foreach($recipe->ingredients as $i => $ing)
          <div class="ingredient-group flex flex-wrap items-center gap-2">
            <input type="text"
                   name="ingredients[{{ $i }}][name]"
                   value="{{ old("ingredients.$i.name", $ing->name) }}"
                   placeholder="Ingrediente"
                   list="ingredients-list"
                   oninput="fetchSuggestions(this.value)"
                   class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-3 py-1.5"
                   required>
            <input type="number"
                   name="ingredients[{{ $i }}][quantity]"
                   value="{{ old("ingredients.$i.quantity", $ing->pivot->quantity) }}"
                   placeholder="Cant."
                   class="border-gray-300 rounded px-2 py-1"
                   required>
            <input type="text"
                   name="ingredients[{{ $i }}][unit]"
                   value="{{ old("ingredients.$i.unit", $ing->pivot->unit) }}"
                   placeholder="Unidad"
                   class="border-gray-300 rounded px-2 py-1"
                   required>
            <button type="button" onclick="removeIngredient(this)"
                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500">
              Eliminar
            </button>
          </div>
        @endforeach
      </div>

      <button
                type="button"
                onclick="addIngredient()"
                class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 text-sm"
            >
                ➕ Agregar ingrediente
            </button>

      <div class="text-right">
        <button type="submit"
                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition">
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

  {{-- Datalist global para sugerencias --}}
  <datalist id="ingredients-list"></datalist>

  <script>
    // Comenzamos con el número de ingredientes actuales
    let ingredientIndex = {{ $recipe->ingredients->count() }};

    // Autocompleta usando Spoonacular
  async function fetchSuggestions(q) {
    const list = document.getElementById('ingredients-list');
    // limpia anteriores
    list.innerHTML = '';
    if (!q) return;
    try {
      const res = await axios.get('{{ url('ingredients/search') }}', {
        params: { q }
      });
      res.data.forEach(name => {
        const opt = document.createElement('option');
        opt.value = name;
        list.appendChild(opt);
      });
    } catch (e) {
      console.error('Error al llamar a ingredients.search', e);
    }
  }

    // Añade un nuevo grupo de inputs
    function addIngredient() {
      const container = document.getElementById('ingredients');
      const div = document.createElement('div');
      div.className = 'ingredient-group flex items-center space-x-2 mt-2';
      div.innerHTML = `
        <input type="text"
               name="ingredients[${ingredientIndex}][name]"
               placeholder="Ingrediente"
               list="ingredients-list"
               oninput="fetchSuggestions(this.value)"
               class="border-gray-300 rounded px-2 py-1"
               required>
        <input type="number"
               name="ingredients[${ingredientIndex}][quantity]"
               placeholder="Cant."
               class="border-gray-300 rounded px-2 py-1"
               required>
        <input type="text"
               name="ingredients[${ingredientIndex}][unit]"
               placeholder="Unidad"
               class="border-gray-300 rounded px-2 py-1"
               required>
        <button type="button" onclick="removeIngredient(this)"
                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500">
          Eliminar
        </button>
      `;
      container.appendChild(div);
      ingredientIndex++;
    }

    // Elimina un grupo de inputs
    function removeIngredient(btn) {
      btn.closest('.ingredient-group')?.remove();
    }
  </script>
</x-app-layout>
