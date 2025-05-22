<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-white">Editar Plan Semanal</h2>
  </x-slot>

  <div class="p-6 m-6 bg-white rounded-xl shadow-md space-y-6">
    <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">Editar Plan de Alimentación</h2>

    <form action="{{ route('plans.update', $plan) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Selector de usuario -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Asignar a:</label>
            <select name="user_id"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach(\App\Models\User::where('role','member')->get() as $user)
                    <option value="{{ $user->id }}"
                        {{ old('user_id', $plan->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Fechas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha inicio</label>
                <input type="date" name="start_date"
                       value="{{ old('start_date', $plan->start_date) }}"
                       class="text-black mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('start_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha fin</label>
                <input type="date" name="end_date"
                       value="{{ old('end_date', $plan->end_date) }}"
                       class="text-black mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('end_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Asignación de recetas por día -->
        @php
            $days = [
                'Mon' => 'Lunes', 'Tue' => 'Martes', 'Wed' => 'Miércoles',
                'Thu' => 'Jueves', 'Fri' => 'Viernes', 'Sat' => 'Sábado', 'Sun' => 'Domingo'
            ];
        @endphp

        <div class="space-y-6">
            @foreach($days as $code => $day)
                @php
                    $assigned = $plan->recipes
                        ->filter(fn($r) => $r->pivot->day_of_week === $code)
                        ->pluck('id')->toArray();
                @endphp
                <div class="p-4 bg-gray-50 rounded border">
                    <h3 class="text-lg font-semibold text-indigo-700 mb-3">{{ $day }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($recipes as $recipe)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox"
                                       name="recipes[{{ $code }}][]"
                                       value="{{ $recipe->id }}"
                                       {{ in_array($recipe->id, old("recipes.$code", $assigned)) ? 'checked' : '' }}
                                       class="form-checkbox h-4 w-4 text-blue-600">
                                <span class="text-gray-700">{{ $recipe->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Botón -->
        <div class="text-right">
            <button type="submit"
                    class="px-6 py-2 bg-[#463f1a] text-white rounded-lg hover:bg-[#60492C] transition">
                Actualizar Plan
            </button>
        </div>
    </form>
</div>

<!-- Enlace de regreso -->
<div class="mt-6 px-6">
    <a href="{{ route('plans.index') }}"
       class="my-3 text-gray-700 hover:text-blue-600 hover:underline transition">
        ← Volver al listado de planes
    </a>
</div>

</x-app-layout>
