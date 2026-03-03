<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Shift</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-6">
        <!-- En-tête avec navigation -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('shifts.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Retour à la liste
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-800">Shift du {{ $shift->date }} - Ligne {{ $shift->line }}</h1>
                </div>
                <div class="text-sm text-gray-600">
                    <span class="mr-4"><span class="font-medium">Team Speaker:</span> {{ $shift->team_speaker }}</span>
                    <span><span class="font-medium">Superviseur:</span> {{ $shift->supervisor }}</span>
                </div>
            </div>
        </div>

        <!-- Tableau des détails -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Heure</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Planifiés</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Présents</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Temps Net</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Référence</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Coeff.</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Objectif</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Bonnes</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Mauvaises</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">KOSU réel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Commentaires</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($shift->details as $detail)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->hour }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->planned_operators }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->present_operators }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->net_time }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->reference }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->coefficient }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->objective_quantity }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->good_quantity }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->bad_quantity }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $detail->kosu_real }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 max-w-xs">
                            {{ $detail->comments ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pied de page avec totaux -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Total opérateurs présents</p>
                <p class="text-xl font-semibold text-gray-800">{{ $shift->details->sum('present_operators') }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Total production bonne</p>
                <p class="text-xl font-semibold text-gray-800">{{ $shift->details->sum('good_quantity') }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Taux de qualité</p>
                @php
                    $totalGood = $shift->details->sum('good_quantity');
                    $totalBad = $shift->details->sum('bad_quantity');
                    $qualityRate = ($totalGood + $totalBad) > 0 ? round(($totalGood / ($totalGood + $totalBad)) * 100, 1) : 0;
                @endphp
                <p class="text-xl font-semibold {{ $qualityRate >= 95 ? 'text-green-600' : ($qualityRate >= 80 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $qualityRate }}%
                </p>
            </div>
        </div>
    </div>
</body>
</html>