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
  
        <div class="text-right">
          <button type="submit"
                  class="px-6 py-2 bg-temu-900 text-white rounded hover:bg-temu-800">
            Guardar Receta
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
  </x-app-layout>