<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">Crear Receta</h2>
  </x-slot>

  <div class="m-6 p-6 bg-white rounded-xl shadow-md space-y-6">
    <form action="{{ route('recipes.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Nombre -->
        <div>
            <label class="block text-sm font-medium text-gray-800 mb-1">🍽️ Nombre</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                required
            >
            @error('name')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Descripción -->
        <div>
            <label class="block text-sm font-medium text-gray-800 mb-1">📝 Descripción</label>
            <textarea
                name="description"
                rows="3"
                class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >{{ old('description') }}</textarea>
        </div>

        <!-- Pasos -->
        <div>
            <label class="block text-sm font-medium text-gray-800 mb-1">👨‍🍳 Pasos</label>
            <textarea
                name="steps"
                rows="5"
                class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >{{ old('steps') }}</textarea>
        </div>

        <!-- Ingredientes -->
        <div>
            <h4 class="text-md font-semibold text-gray-800 mb-2">🥄 Ingredientes</h4>
            <div id="ingredients" class="space-y-3">
                <div class="ingredient-group flex flex-wrap items-center gap-2">
                    <input
                        type="text"
                        name="ingredients[0][name]"
                        list="ingredients-list"
                        oninput="fetchSuggestions(this.value)"
                        placeholder="Ingrediente"
                        class="flex-1 min-w-[150px] border border-gray-300 rounded-lg px-3 py-1.5"
                        required
                    >
                    <input
                        type="number"
                        name="ingredients[0][quantity]"
                        placeholder="Cant."
                        class="w-24 border border-gray-300 rounded-lg px-3 py-1.5"
                        required
                    >
                    <input
                        type="text"
                        name="ingredients[0][unit]"
                        placeholder="Unidad"
                        class="w-28 border border-gray-300 rounded-lg px-3 py-1.5"
                        required
                    >
                    <button
                        type="button"
                        onclick="removeIngredient(this)"
                        class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-500 text-sm"
                    >
                        🗑️ Eliminar
                    </button>
                </div>
            </div>

            <!-- Botón para agregar ingrediente -->
            <button
                type="button"
                onclick="addIngredient()"
                class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 text-sm"
            >
                ➕ Agregar ingrediente
            </button>

            <datalist id="ingredients-list"></datalist>
        </div>

        <!-- Botón de guardar -->
        <div class="text-right">
            <button
                type="submit"
                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition"
            >
                💾 Guardar Receta
            </button>
        </div>
    </form>
</div>

<!-- Volver al listado -->
<div class="p-4">
    <a href="{{ route('recipes.index') }}"
       class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600 hover:underline transition">
        ← Volver al listado
    </a>
</div>


  {{-- JavaScript de autocompletado dinámico --}}
  <script>
    let ingredientIndex = 1;

    function fetchSuggestions(query) {
      if (query.length < 2) return;
      fetch(`{{ route('ingredients.search') }}?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(names => {
          const dl = document.getElementById('ingredients-list');
          dl.innerHTML = '';
          names.forEach(name => {
            const opt = document.createElement('option');
            opt.value = name;
            dl.appendChild(opt);
          });
        })
        .catch(() => console.warn('Error al obtener sugerencias'));
    }

    function addIngredient() {
      const container = document.getElementById('ingredients');
      const div = document.createElement('div');
      div.className = 'ingredient-group flex items-center space-x-2 mt-2';
      div.innerHTML = `
        <input
          type="text"
          name="ingredients[${ingredientIndex}][name]"
          list="ingredients-list"
          oninput="fetchSuggestions(this.value)"
          placeholder="Ingrediente"
          class="border-gray-300 rounded px-2 py-1"
          required
        >
        <input
          type="number"
          name="ingredients[${ingredientIndex}][quantity]"
          placeholder="Cant."
          class="border-gray-300 rounded px-2 py-1"
          required
        >
        <input
          type="text"
          name="ingredients[${ingredientIndex}][unit]"
          placeholder="Unidad"
          class="border-gray-300 rounded px-2 py-1"
          required
        >
        <button
          type="button"
          onclick="removeIngredient(this)"
          class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500"
        >Eliminar</button>
      `;
      container.appendChild(div);
      ingredientIndex++;
    }

    function removeIngredient(btn) {
      btn.closest('.ingredient-group')?.remove();
    }
  </script>
</x-app-layout>
