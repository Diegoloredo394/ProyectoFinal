<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-temu-dark">Nuevo Plan Semanal</h2>
    </x-slot>
  
    <div class="p-4 bg-white rounded shadow space-y-6">
      <form action="{{ route('plans.store') }}" method="POST">
        @csrf
  
        <!-- Selección de usuario (solo para admin) -->
        <div>
          <label for="user_id" class="block font-medium text-gray-700">Para el usuario:</label>
          <select name="user_id" id="user_id"
                  class="mt-1 block w-full border-gray-300 rounded">
            @foreach(\App\Models\User::where('role','member')->get() as $user)
              <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
          </select>
        </div>
  
        <!-- Fechas de inicio y fin -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="start_date" class="block font-medium text-gray-700">Fecha inicio:</label>
            <input type="date" name="start_date" id="start_date"
                   class="mt-1 block w-full border-gray-300 rounded"
                   value="{{ old('start_date', now()->toDateString()) }}">
          </div>
          <div>
            <label for="end_date" class="block font-medium text-gray-700">Fecha fin:</label>
            <input type="date" name="end_date" id="end_date"
                   class="mt-1 block w-full border-gray-300 rounded"
                   value="{{ old('end_date', now()->addDays(6)->toDateString()) }}">
          </div>
        </div>
  
        <!-- Selección de recetas por día -->
        <div class="space-y-4">
          @foreach(['Mon'=>'Lunes','Tue'=>'Martes','Wed'=>'Miércoles','Thu'=>'Jueves','Fri'=>'Viernes','Sat'=>'Sábado','Sun'=>'Domingo'] as $code=>$day)
            <div>
              <h3 class="font-semibold text-gray-800">{{ $day }}</h3>
              <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach($recipes as $recipe)
                  <label class="inline-flex items-center space-x-2">
                    <input 
                      type="checkbox" 
                      name="recipes[{{ $code }}][]" 
                      value="{{ $recipe->id }}" 
                      class="form-checkbox h-4 w-4 text-temu-900">
                    <span class="text-gray-700">{{ $recipe->name }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
  
        <!-- Botón de guardar -->
        <div class="pt-4 text-right">
          <button type="submit"
                  class="px-6 py-2 bg-temu-900 text-white rounded hover:bg-temu-800">
            Guardar Plan
          </button>
        </div>
      </form>
    </div>
  </x-app-layout>