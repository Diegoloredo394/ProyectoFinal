<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-white">Nuevo Plan Semanal</h2>
  </x-slot>

  <div class="m-6 max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md">
  <h2 class="text-xl font-semibold text-gray-800 mb-4">Crear Nuevo Plan</h2>

  <form action="{{ route('plans.store') }}" method="POST" class="space-y-6">
    @csrf

    <!-- Selector de usuario -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Asignar a</label>
      <select name="user_id" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @foreach(\App\Models\User::where('role','member')->get() as $user)
          <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->email }})
          </option>
        @endforeach
      </select>
      @error('user_id')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Fechas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Fecha de inicio</label>
        <input type="date" name="start_date" value="{{ old('start_date', now()->toDateString()) }}"
               class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('start_date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Fecha de fin</label>
        <input type="date" name="end_date" value="{{ old('end_date', now()->addDays(6)->toDateString()) }}"
               class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('end_date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>
    </div>

    <!-- Recetas por día -->
    @php
      $days = ['Mon'=>'Lunes','Tue'=>'Martes','Wed'=>'Miércoles','Thu'=>'Jueves','Fri'=>'Viernes','Sat'=>'Sábado','Sun'=>'Domingo'];
    @endphp

    @foreach($days as $code => $day)
      <div>
        <h3 class="font-semibold text-gray-800 mb-2">{{ $day }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
          @foreach($recipes as $recipe)
            <label class="flex items-center space-x-2">
              <input type="checkbox"
                     name="recipes[{{ $code }}][]"
                     value="{{ $recipe->id }}"
                     class="form-checkbox h-4 w-4 text-blue-600">
              <span class="text-gray-700">{{ $recipe->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
    @endforeach

    <!-- Botón de envío -->
    <div class="flex justify-end">
      <button type="submit"
              class="bg-[#463f1a] hover:bg-[#60492C] text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
        Guardar Plan
      </button>
    </div>
  </form>
</div>

<!-- Enlace de regreso -->
<div class="mt-6 text-center">
  <a href="{{ route('plans.index') }}" class="text-white-600 hover:underline">
    ← Volver al listado de planes
  </a>
</div>

</x-app-layout>