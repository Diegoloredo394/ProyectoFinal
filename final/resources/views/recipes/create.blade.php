<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">Crear Receta</h2>
  </x-slot>

  <div class="p-4 bg-white rounded shadow">
    <form action="{{ route('recipes.store') }}" method="POST" class="space-y-4">
      @csrf

      {{-- Nombre --}}
      <div>
        <label class="block font-medium text-gray-700">Nombre</label>
        <input
          type="text"
          name="name"
          value="{{ old('name') }}"
          class="mt-1 block w-full border-gray-300 rounded"
          required
        >
        @error('name')<span class="text-red-600">{{ $message }}</span>@enderror
      </div>

      {{-- Descripción --}}
      <div>
        <label class="block font-medium text-gray-700">Descripción</label>
        <textarea
          name="description"
          rows="3"
          class="mt-1 block w-full border-gray-300 rounded"
        >{{ old('description') }}</textarea>
      </div>

      {{-- Pasos --}}
      <div>
        <label class="block font-medium text-gray-700">Pasos</label>
        <textarea
          name="steps"
          rows="5"
          class="mt-1 block w-full border-gray-300 rounded"
        >{{ old('steps') }}</textarea>
      </div>

      {{-- Ingredientes --}}
      <h4 class="font-semibold text-gray-800">Ingredientes</h4>
      <div id="ingredients">
        <div class="ingredient-group flex items-center space-x-2">
          <input
            type="text"
            name="ingredients[0][name]"
            list="ingredients-list"
            oninput="fetchSuggestions(this.value)"
            placeholder="Ingrediente"
            class="border-gray-300 rounded px-2 py-1"
            required
          >
          <input
            type="number"
            name="ingredients[0][quantity]"
            placeholder="Cant."
            class="border-gray-300 rounded px-2 py-1"
            required
          >
          <input
            type="text"
            name="ingredients[0][unit]"
            placeholder="Unidad"
            class="border-gray-300 rounded px-2 py-1"
            required
          >
          <button
            type="button"
            onclick="removeIngredient(this)"
            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-500"
          >Eliminar</button>
        </div>
      </div>

      {{-- Datalist para sugerencias --}}
      <datalist id="ingredients-list"></datalist>

      {{-- Botones --}}
      <button
        type="button"
        onclick="addIngredient()"
        class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500"
      >Agregar ingrediente</button>

      <div class="text-right">
        <button
          type="submit"
          class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-500"
        >Guardar Receta</button>
      </div>
    </form>
  </div>

  <div class="p-4">
    <a href="{{ route('recipes.index') }}" class="text-gray-700 hover:underline">
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
