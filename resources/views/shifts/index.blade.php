<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Shifts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-6">
        <!-- En-tête simple -->
           <a href="{{ route('shifts.create') }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Retour à la liste
            </a>
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Historique des Shifts</h1>
            <p class="text-gray-600 text-sm mt-1">Liste complète des shifts enregistrés</p>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table simple et propre -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Ligne</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Team Speaker</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Superviseur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($shifts as $shift)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $shift->date }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $shift->line }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $shift->team_speaker }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $shift->supervisor }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('shifts.show', $shift) }}" 
                               class="text-blue-600 hover:text-blue-800 hover:underline">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination simple -->
        <div class="mt-4">
            {{ $shifts->links() }}
        </div>
    </div>
</body>
</html>