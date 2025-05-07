<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Plan {{ $plan->id }} PDF</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .heading { background: #f3f4f6; padding: 8px; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
  </style>
</head>
<body>
  <h2>Plan Semanal: {{ $plan->name }}</h2>
  <p>Usuario: {{ $plan->user->name }} ({{ $plan->user->email }})</p>
  <p>Desde {{ $plan->start_date }} hasta {{ $plan->end_date }}</p>

  <table>
    <tr class="heading">
      <th>Día</th>
      <th>Recetas</th>
    </tr>
    @foreach(['Mon'=>'Lunes','Tue'=>'Martes','Wed'=>'Miércoles','Thu'=>'Jueves','Fri'=>'Viernes','Sat'=>'Sábado','Sun'=>'Domingo'] as $code=>$day)
      @php
        $dayRecipes = $plan->recipes->filter(fn($r) => $r->pivot->day_of_week === $code);
      @endphp
      <tr>
        <td>{{ $day }}</td>
        <td>
          @if($dayRecipes->isEmpty())
            —
          @else
            <ul style="padding-left: 16px; margin:0;">
              @foreach($dayRecipes as $r)
                <li>{{ $r->name }}</li>
              @endforeach
            </ul>
          @endif
        </td>
      </tr>
    @endforeach
  </table>

  <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>