<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Shift du {{ $shift->date }} - Ligne {{ $shift->line }}</h1>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Heure</th>
                <th class="border p-2">Planifiés</th>
                <th class="border p-2">Présents</th>
                <th class="border p-2">Temps Net</th>
                <th class="border p-2">Référence</th>
                <th class="border p-2">Coeff.</th>
                <th class="border p-2">Objectif</th>
                <th class="border p-2">Bonnes</th>
                <th class="border p-2">Mauvaises</th>
                <th class="border p-2">KOSU réel</th>
                <th class="border p-2">Commentaires</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shift->details as $detail)
            <tr>
                <td class="border p-2">{{ $detail->hour }}</td>
                <td class="border p-2">{{ $detail->planned_operators }}</td>
                <td class="border p-2">{{ $detail->present_operators }}</td>
                <td class="border p-2">{{ $detail->net_time }}</td>
                <td class="border p-2">{{ $detail->reference }}</td>
                <td class="border p-2">{{ $detail->coefficient }}</td>
                <td class="border p-2">{{ $detail->objective_quantity }}</td>
                <td class="border p-2">{{ $detail->good_quantity }}</td>
                <td class="border p-2">{{ $detail->bad_quantity }}</td>
                <td class="border p-2">{{ $detail->kosu_real }}</td>
                <td class="border p-2">{{ $detail->comments }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>