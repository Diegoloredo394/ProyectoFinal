<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">
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

    <div class="grid grid-cols-2 gap-4">
      @foreach($plans as $plan)
        <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
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
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
          Nuevo Plan
        </a>
      </div>
    @endif
  </div>
</x-app-layout>
