<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Historique des Shifts</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Date</th>
                <th class="border p-2">Ligne</th>
                <th class="border p-2">Team Speaker</th>
                <th class="border p-2">Superviseur</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shifts as $shift)
            <tr>
                <td class="border p-2">{{ $shift->date }}</td>
                <td class="border p-2">{{ $shift->line }}</td>
                <td class="border p-2">{{ $shift->team_speaker }}</td>
                <td class="border p-2">{{ $shift->supervisor }}</td>
                <td class="border p-2">
                    <a href="{{ route('shifts.show', $shift) }}" class="text-blue-600">Voir détails</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $shifts->links() }} {{-- pagination --}}
    </div>
</div>
</body>
</html>