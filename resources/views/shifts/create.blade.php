<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Nouveau Shift - Ligne {{ old('line', 'L1') }}</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('shifts.store') }}" id="shiftForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium">Date</label>
                <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Team Speaker</label>
                <input type="text" name="team_speaker" value="{{ old('team_speaker') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Superviseur</label>
                <input type="text" name="supervisor" value="{{ old('supervisor') }}" class="w-full border rounded p-2">
            </div>
          <div>
    <label class="block text-sm font-medium">Ligne</label>
    <select name="line" class="w-full border rounded p-2" required>
        @for ($i = 1; $i <= 7; $i++)
            <option value="L{{ $i }}" {{ old('line', 'L1') == 'L'.$i ? 'selected' : '' }}>
                L{{ $i }}
            </option>
        @endfor
    </select>
</div>
        </div>

        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Détails horaires</h2>
            <button type="button" id="addRow" class="bg-blue-500 text-white px-4 py-2 rounded">+ Ajouter une ligne</button>
        </div>

        <table class="w-full border-collapse border" id="detailsTable">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">HEURES</th>
                    <th class="border p-2">NB OP. PLANIFIÉS</th>
                    <th class="border p-2">NB OP. PRÉSENTS</th>
                    <th class="border p-2">TEMPS NET (H)</th>
                    <th class="border p-2">RÉFÉRENCE</th>
                    <th class="border p-2">COEFF.</th>
                    <th class="border p-2">QUANTITÉ OBJ.</th>
                    <th class="border p-2">QUANTITÉ BONNES</th>
                    <th class="border p-2">QUANTITÉ MAUVAISES</th>
                    <th class="border p-2">KOSU RÉEL</th>
                    <th class="border p-2">COMMENTAIRES</th>
                    <th class="border p-2">ACTION</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Les lignes seront ajoutées ici par JS -->
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 font-semibold">
                    <td class="border p-2">CUMUL</td>
                    <td class="border p-2" id="sumPlanned">0</td>
                    <td class="border p-2" id="sumPresent">0</td>
                    <td class="border p-2" id="sumNetTime">0</td>
                    <td class="border p-2"></td>
                    <td class="border p-2"></td>
                    <td class="border p-2" id="sumObj">0</td>
                    <td class="border p-2" id="sumGood">0</td>
                    <td class="border p-2" id="sumBad">0</td>
                    <td class="border p-2">-</td>
                    <td class="border p-2" colspan="2">
                        Taux Défauts: <span id="defectRate">0%</span> | Production Totale: <span id="totalProduction">0</span>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Enregistrer le shift</button>
            <a href="{{ route('shifts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Liste des Shifts</a>
            <a href="{{ route('shifts.show', 1) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Voir Shift #1</a>
        </div>
    </form>
</div>

<script>
    // Données des références depuis le serveur (pour auto-complétion et coeff)
    const references = @json($references); // [ { name, coefficient } ]

    let rowIndex = 0;

    // Récupérer les anciennes données du formulaire s'il y en a
    const oldDetails = @json(old('details', []));
    
    // Récupérer les données de la session flash pour les nouvelles lignes ajoutées
    const newRows = @json(session('new_rows', []));

    // Variable pour stocker l'index maximum utilisé
    let maxIndex = 0;

    function addRow(data = {}) {
        const tbody = document.getElementById('tableBody');
        const tr = document.createElement('tr');
        
        // Si data a un index, l'utiliser, sinon utiliser le prochain index disponible
        if (data.index !== undefined) {
            tr.dataset.index = data.index;
            if (data.index > maxIndex) maxIndex = data.index;
        } else {
            tr.dataset.index = maxIndex + 1;
            maxIndex++;
        }
        
        const currentIndex = tr.dataset.index;

        // Heure
        const hourCell = document.createElement('td');
        hourCell.className = 'border p-2';
        hourCell.innerHTML = `<input type="time" name="details[${currentIndex}][hour]" value="${data.hour || '08:00'}" class="w-full border rounded p-1 hour-input" required>`;
        tr.appendChild(hourCell);

        // Planifiés
        const plannedCell = document.createElement('td');
        plannedCell.className = 'border p-2';
        plannedCell.innerHTML = `<input type="number" name="details[${currentIndex}][planned_operators]" value="${data.planned_operators || 0}" min="0" class="w-full border rounded p-1 planned-input">`;
        tr.appendChild(plannedCell);

        // Présents
        const presentCell = document.createElement('td');
        presentCell.className = 'border p-2';
        presentCell.innerHTML = `<input type="number" name="details[${currentIndex}][present_operators]" value="${data.present_operators || 0}" min="0" class="w-full border rounded p-1 present-input">`;
        tr.appendChild(presentCell);

        // Temps net
        const netCell = document.createElement('td');
        netCell.className = 'border p-2';
        netCell.innerHTML = `<input type="number" step="0.01" name="details[${currentIndex}][net_time]" value="${data.net_time || 0}" min="0" class="w-full border rounded p-1 net-input">`;
        tr.appendChild(netCell);

        // Référence + select
        const refCell = document.createElement('td');
        refCell.className = 'border p-2';
        let selectHtml = `<select name="details[${currentIndex}][reference]" class="w-full border rounded p-1 ref-select">`;
        selectHtml += `<option value="">-- Sélectionner --</option>`;
        references.forEach(ref => {
            selectHtml += `<option value="${ref.name}" data-coeff="${ref.coefficient}" ${data.reference === ref.name ? 'selected' : ''}>${ref.name}</option>`;
        });
        selectHtml += `</select>`;
        refCell.innerHTML = selectHtml;
        tr.appendChild(refCell);

        // Coefficient (peut être modifié manuellement)
        const coeffCell = document.createElement('td');
        coeffCell.className = 'border p-2';
        coeffCell.innerHTML = `<input type="number" step="0.01" name="details[${currentIndex}][coefficient]" value="${data.coefficient || 1}" min="0" class="w-full border rounded p-1 coeff-input">`;
        tr.appendChild(coeffCell);

        // Objectif
        const objCell = document.createElement('td');
        objCell.className = 'border p-2';
        objCell.innerHTML = `<input type="number" name="details[${currentIndex}][objective_quantity]" value="${data.objective_quantity || 0}" min="0" class="w-full border rounded p-1 obj-input">`;
        tr.appendChild(objCell);

        // Bonnes
        const goodCell = document.createElement('td');
        goodCell.className = 'border p-2';
        goodCell.innerHTML = `<input type="number" name="details[${currentIndex}][good_quantity]" value="${data.good_quantity || 0}" min="0" class="w-full border rounded p-1 good-input">`;
        tr.appendChild(goodCell);

        // Mauvaises
        const badCell = document.createElement('td');
        badCell.className = 'border p-2';
        badCell.innerHTML = `<input type="number" name="details[${currentIndex}][bad_quantity]" value="${data.bad_quantity || 0}" min="0" class="w-full border rounded p-1 bad-input">`;
        tr.appendChild(badCell);

        // KOSU réel (affichage seulement)
        const kosuCell = document.createElement('td');
        kosuCell.className = 'border p-2 kosu-display';
        kosuCell.innerText = data.kosu_real ? data.kosu_real.toFixed(2) : '-';
        tr.appendChild(kosuCell);

        // Commentaires
        const commentCell = document.createElement('td');
        commentCell.className = 'border p-2';
        commentCell.innerHTML = `<input type="text" name="details[${currentIndex}][comments]" value="${data.comments || ''}" class="w-full border rounded p-1">`;
        tr.appendChild(commentCell);

        // Action (supprimer)
        const actionCell = document.createElement('td');
        actionCell.className = 'border p-2 text-center';
        actionCell.innerHTML = `<button type="button" class="text-red-600 delete-row">Supprimer</button>`;
        tr.appendChild(actionCell);

        tbody.appendChild(tr);
        
        // Ajouter les écouteurs d'événements pour cette ligne
        attachRowListeners(tr);
        
        // Mettre à jour le KOSU si on a des données
        if (data.good_quantity && data.coefficient && data.present_operators && data.net_time) {
            updateKosuForRow(tr);
        }
    }

    function attachRowListeners(tr) {
        // Quand on change la référence, mettre à jour le coefficient
        const refSelect = tr.querySelector('.ref-select');
        const coeffInput = tr.querySelector('.coeff-input');
        if (refSelect && coeffInput) {
            refSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const coeff = selectedOption.dataset.coeff;
                if (coeff) {
                    coeffInput.value = coeff;
                }
                updateKosuForRow(tr);
                updateCumuls();
            });
        }

        // Tous les champs qui influencent le KOSU
        const inputs = tr.querySelectorAll('.present-input, .net-input, .good-input, .bad-input, .coeff-input');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                updateKosuForRow(tr);
                updateCumuls();
            });
            input.addEventListener('change', () => {
                updateKosuForRow(tr);
                updateCumuls();
            });
        });

        // Bouton supprimer
        const deleteBtn = tr.querySelector('.delete-row');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                tr.remove();
                updateCumuls();
            });
        }
    }

    function updateKosuForRow(tr) {
        const present = parseFloat(tr.querySelector('.present-input')?.value) || 0;
        const net = parseFloat(tr.querySelector('.net-input')?.value) || 0;
        const good = parseFloat(tr.querySelector('.good-input')?.value) || 0;
        const coeff = parseFloat(tr.querySelector('.coeff-input')?.value) || 1;
        const kosuDisplay = tr.querySelector('.kosu-display');

        if (good > 0 && coeff > 0) {
            const kosu = (present * net) / (good * coeff);
            kosuDisplay.innerText = kosu.toFixed(2);
        } else {
            kosuDisplay.innerText = '-';
        }
    }

    function updateCumuls() {
        let sumPlanned = 0, sumPresent = 0, sumNet = 0, sumObj = 0, sumGood = 0, sumBad = 0;

        document.querySelectorAll('#tableBody tr').forEach(tr => {
            sumPlanned += parseFloat(tr.querySelector('.planned-input')?.value) || 0;
            sumPresent += parseFloat(tr.querySelector('.present-input')?.value) || 0;
            sumNet += parseFloat(tr.querySelector('.net-input')?.value) || 0;
            sumObj += parseFloat(tr.querySelector('.obj-input')?.value) || 0;
            sumGood += parseFloat(tr.querySelector('.good-input')?.value) || 0;
            sumBad += parseFloat(tr.querySelector('.bad-input')?.value) || 0;
        });

        document.getElementById('sumPlanned').innerText = sumPlanned;
        document.getElementById('sumPresent').innerText = sumPresent.toFixed(1);
        document.getElementById('sumNetTime').innerText = sumNet.toFixed(2);
        document.getElementById('sumObj').innerText = sumObj;
        document.getElementById('sumGood').innerText = sumGood;
        document.getElementById('sumBad').innerText = sumBad;

        const totalProd = sumGood;
        const defectRate = (sumGood + sumBad) > 0 ? ((sumBad / (sumGood + sumBad)) * 100).toFixed(2) : 0;
        document.getElementById('totalProduction').innerText = totalProd;
        document.getElementById('defectRate').innerText = defectRate + '%';
    }

    // Charger les lignes au démarrage
    document.addEventListener('DOMContentLoaded', function() {
        // Vider le tableau avant d'ajouter les lignes
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        
        // Calculer l'index maximum
        maxIndex = -1;
        
        // D'abord ajouter les anciennes données (old)
        if (oldDetails.length > 0) {
            oldDetails.forEach((detail, index) => {
                detail.index = index;
                addRow(detail);
                if (index > maxIndex) maxIndex = index;
            });
        }
        
        // Ensuite ajouter les nouvelles lignes de la session
        if (newRows.length > 0) {
            newRows.forEach((row, index) => {
                row.index = maxIndex + 1 + index;
                addRow(row);
            });
        }
        
        // Si aucune ligne n'existe, ajouter une ligne par défaut
        if (oldDetails.length === 0 && newRows.length === 0) {
            addRow({ index: 0 });
            maxIndex = 0;
        }
        
        updateCumuls();
    });

    document.getElementById('addRow').addEventListener('click', function() {
        // Quand on ajoute une nouvelle ligne, on incrémente maxIndex
        maxIndex++;
        addRow({ index: maxIndex });
    });
</script>
</body>
</html>