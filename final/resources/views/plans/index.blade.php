<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-white">
      @if(auth()->user()->role === 'admin')
        Todos los Planes Semanales
      @else
        Mis Planes Semanales
      @endif
    </h2>
  </x-slot>

  <div class="p-4 space-y-4">
    @if(session('success'))
      <div class="p-2 bg-green-100 border border-green-300 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($plans as $plan)
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-200 p-5 transform transition duration-300 hover:scale-105 hover:shadow-lg">
          <h3 class="font-bold text-gray-800">{{ $plan->name }}</h3>
          <p class="text-sm text-gray-600">
            {{ $plan->start_date }} – {{ $plan->end_date }}
          </p>
          <div class="mt-2 space-x-2">
            <a href="{{ route('plans.show', $plan) }}"
               class="text-blue-600 hover:underline">
              Ver
            </a>
            <a href="{{ route('plans.pdf', $plan) }}"
               class="text-blue-600 hover:underline">
              PDF
            </a>

            @if(auth()->user()->role === 'admin')
              <a href="{{ route('plans.edit', $plan) }}"
                 class="text-green-600 hover:underline">
                Editar
              </a>

              <form method="POST"
                    action="{{ route('plans.destroy', $plan) }}"
                    class="inline"
                    onsubmit="return confirm('¿Eliminar este plan?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:underline">
                  Eliminar
                </button>
              </form>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    @if(auth()->user()->role==='admin')
      <div class="mt-6 text-right">
        <a href="{{ route('plans.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-[#60492C] text-white text-sm font-semibold rounded-lg shadow hover:bg-[#463F1A] transition duration-200">
          Nuevo Plan
        </a>
      </div>
    @endif
  </div>
</x-app-layout>
