<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Plan {{ $plan->id }} PDF</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    table { width:100%; border-collapse:collapse; margin-top:16px; }
    th, td { border:1px solid #ddd; padding:6px; }
    th { background:#f3f4f6; }
  </style>
</head>
<body>
  <h2>Plan Semanal: {{ $plan->name }}</h2>
  <p>Usuario: {{ $plan->user->name }} ({{ $plan->user->email }})</p>
  <p>Período: {{ $plan->start_date }} – {{ $plan->end_date }}</p>

  <table>
    <tr>
      <th>Día</th>
      <th>Recetas</th>
    </tr>
    @foreach(['Mon'=>'Lunes','Tue'=>'Martes','Wed'=>'Miércoles',
              'Thu'=>'Jueves','Fri'=>'Viernes','Sat'=>'Sábado','Sun'=>'Domingo'] as $code => $day)
      @php
        $dr = $plan->recipes->filter(fn($r)=> $r->pivot->day_of_week === $code);
      @endphp
      <tr>
        <td>{{ $day }}</td>
        <td>
          @if($dr->isEmpty())
            —
          @else
            <ul>
              @foreach($dr as $r)
                <li>{{ $r->name }}</li>
              @endforeach
            </ul>
          @endif
        </td>
      </tr>
    @endforeach
  </table>

  <p style="margin-top:20px;">Generado: {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
