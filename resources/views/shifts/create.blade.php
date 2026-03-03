<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Shift</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .graphic-pastille {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            color: white;
            font-size: 12px;
        }
        .graphic-vert { background-color: #28a745; }
        .graphic-jaune { background-color: #ffc107; color: #212529; }
        .graphic-orange { background-color: #fd7e14; }
        .graphic-rouge { background-color: #dc3545; }
        .graphic-fonce { background-color: #8b0000; }
        .graphic-gris { background-color: #6c757d; }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="container mx-auto p-4 bg-white rounded shadow">
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
                <div>
                    <button type="button" id="addRow" class="bg-blue-500 text-white px-4 py-2 rounded">+ Ajouter une ligne</button>
                    <button type="button" id="clearDraft" class="bg-red-500 text-white px-4 py-2 rounded ml-2">Effacer le brouillon</button>
                </div>
            </div>

            <div class="overflow-x-auto">
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
                            <th class="border p-2">GRAPHIQUE<br><small>Obj +15% +25% +35%</small></th>
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
                            <td class="border p-2" id="globalKosuDisplay">-</td>
                            <td class="border p-2" colspan="3">
                                Taux Défauts: <span id="defectRate">0%</span> | 
                                Production Totale: <span id="totalProduction">0</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="13" class="border p-2 text-center">
                                <span id="lineCount">0 ligne(s)</span> · 
                                <span id="completeCount">0 complète(s)</span> · 
                                KOSU Global: <span id="globalKosuValue">-</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Enregistrer le shift</button>
                
                {{-- Bouton de retour au dashboard selon le rôle --}}
                @auth
                    @php
                        $dashboardRoute = match(auth()->user()->role) {
                            'shift_leader' => 'dashboard.shift',
                            'superviseur' => 'dashboard.superviseur',
                            'methodes'    => 'dashboard.methodes',
                            default       => 'home'
                        };
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Retour au tableau de bord
                    </a>
                @endauth

                <a href="{{ route('shifts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Liste des Shifts</a>
            </div>
        </form>
    </div>

    <script>
        // Données des références depuis le serveur (depuis la table references)
        const references = @json($references);

        // Anciennes données du formulaire (après erreur de validation)
        const oldDetails = @json(old('details', []));

        // Nouvelles lignes flashées après enregistrement réussi
        const newRows = @json(session('new_rows', []));

        // Variables globales
        let maxIndex = 0;
        const STORAGE_KEY = 'shift_draft';
        const EXPIRY_HOURS = 24; // 24 heures

        // ---------- Fonctions de sauvegarde locale ----------
        function saveDraft() {
            const rows = [];
            document.querySelectorAll('#tableBody tr').forEach(tr => {
                const rowData = {
                    hour: tr.querySelector('.hour-input')?.value || '',
                    planned_operators: tr.querySelector('.planned-input')?.value || '0',
                    present_operators: tr.querySelector('.present-input')?.value || '0',
                    net_time: tr.querySelector('.net-input')?.value || '0',
                    reference: tr.querySelector('.ref-select')?.value || '',
                    coefficient: tr.querySelector('.coeff-input')?.value || '1',
                    objective_quantity: tr.querySelector('.obj-input')?.value || '0',
                    good_quantity: tr.querySelector('.good-input')?.value || '0',
                    bad_quantity: tr.querySelector('.bad-input')?.value || '0',
                    comments: tr.querySelector('.comment-input')?.value || ''
                };
                rows.push(rowData);
            });
            const draft = {
                timestamp: Date.now(),
                rows: rows
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(draft));
        }

        function loadDraft() {
            const draftJson = localStorage.getItem(STORAGE_KEY);
            if (!draftJson) return false;
            try {
                const draft = JSON.parse(draftJson);
                const age = Date.now() - draft.timestamp;
                if (age > EXPIRY_HOURS * 60 * 60 * 1000) {
                    localStorage.removeItem(STORAGE_KEY);
                    return false;
                }
                // Vider le tableau
                document.getElementById('tableBody').innerHTML = '';
                // Ajouter chaque ligne
                draft.rows.forEach((rowData, index) => {
                    rowData.index = index;
                    addRow(rowData);
                });
                return true;
            } catch (e) {
                return false;
            }
        }

        // ---------- Fonctions principales ----------
        function addRow(data = {}) {
            const tbody = document.getElementById('tableBody');
            const tr = document.createElement('tr');
            
            const index = data.index !== undefined ? data.index : ++maxIndex;
            tr.dataset.index = index;
            maxIndex = Math.max(maxIndex, index);
            const currentIndex = index;

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

            // RÉFÉRENCE - Liste déroulante avec les données de la table references
            const refCell = document.createElement('td');
            refCell.className = 'border p-2';
            let selectHtml = `<select name="details[${currentIndex}][reference]" class="w-full border rounded p-1 ref-select">`;
            selectHtml += `<option value="">-- Sélectionner une référence --</option>`;
            
            // Boucle sur les références depuis la base de données
            references.forEach(ref => {
                const selected = data.reference === ref.reference ? 'selected' : '';
                selectHtml += `<option value="${ref.reference}" data-coeff="${ref.coefficient}" ${selected}>`;
                selectHtml += `${ref.reference} - Coef: ${ref.coefficient}`;
                if (ref.name) {
                    selectHtml += ` (${ref.name})`;
                }
                selectHtml += `</option>`;
            });
            
            selectHtml += `</select>`;
            refCell.innerHTML = selectHtml;
            tr.appendChild(refCell);

            // Coefficient (auto-rempli quand on sélectionne une référence)
            const coeffCell = document.createElement('td');
            coeffCell.className = 'border p-2';
            coeffCell.innerHTML = `<input type="number" step="0.01" name="details[${currentIndex}][coefficient]" value="${data.coefficient || 1}" min="0" class="w-full border rounded p-1 coeff-input" readonly>`;
            tr.appendChild(coeffCell);

            // Quantité objectif
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

            // KOSU réel (affichage)
            const kosuCell = document.createElement('td');
            kosuCell.className = 'border p-2 kosu-display';
            kosuCell.innerText = data.kosu_real ? data.kosu_real.toFixed(2) : '-';
            tr.appendChild(kosuCell);

            // Graphique
            const graphicCell = document.createElement('td');
            graphicCell.className = 'border p-2 text-center graphic-cell';
            const pastille = document.createElement('span');
            pastille.className = 'graphic-pastille graphic-gris';
            pastille.innerText = '-';
            graphicCell.appendChild(pastille);
            tr.appendChild(graphicCell);

            // Commentaires
            const commentCell = document.createElement('td');
            commentCell.className = 'border p-2';
            commentCell.innerHTML = `<input type="text" name="details[${currentIndex}][comments]" value="${data.comments || ''}" class="w-full border rounded p-1 comment-input">`;
            tr.appendChild(commentCell);

            // Action (supprimer)
            const actionCell = document.createElement('td');
            actionCell.className = 'border p-2 text-center';
            actionCell.innerHTML = `<button type="button" class="text-red-600 delete-row">Supprimer</button>`;
            tr.appendChild(actionCell);

            tbody.appendChild(tr);
            
            attachRowListeners(tr);
            updateKosuForRow(tr);
            updateGraphicForRow(tr);
            saveDraft(); // Sauvegarde après ajout
        }

        function attachRowListeners(tr) {
            const refSelect = tr.querySelector('.ref-select');
            const coeffInput = tr.querySelector('.coeff-input');
            
            // Quand on change la référence, le coefficient se remplit automatiquement
            if (refSelect && coeffInput) {
                refSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const coeff = selected.dataset.coeff;
                    if (coeff) {
                        coeffInput.value = coeff;
                    } else {
                        coeffInput.value = 1;
                    }
                    updateKosuForRow(tr);
                    updateGraphicForRow(tr);
                    updateCumuls();
                    saveDraft();
                });
            }

            const inputs = tr.querySelectorAll('.planned-input, .present-input, .net-input, .good-input, .bad-input, .obj-input, .comment-input');
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    updateKosuForRow(tr);
                    updateGraphicForRow(tr);
                    updateCumuls();
                    saveDraft();
                });
                input.addEventListener('change', () => {
                    updateKosuForRow(tr);
                    updateGraphicForRow(tr);
                    updateCumuls();
                    saveDraft();
                });
            });

            const deleteBtn = tr.querySelector('.delete-row');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    if (confirm('Supprimer cette ligne ?')) {
                        tr.remove();
                        updateCumuls();
                        saveDraft();
                    }
                });
            }
        }

        function updateKosuForRow(tr) {
            const present = parseFloat(tr.querySelector('.present-input')?.value) || 0;
            const net = parseFloat(tr.querySelector('.net-input')?.value) || 0;
            const good = parseFloat(tr.querySelector('.good-input')?.value) || 0;
            const coeff = parseFloat(tr.querySelector('.coeff-input')?.value) || 1;
            const kosuDisplay = tr.querySelector('.kosu-display');

            if (good > 0 && coeff > 0 && present > 0 && net > 0) {
                const kosu = (present * net) / (good * coeff);
                kosuDisplay.innerText = kosu.toFixed(2);
            } else {
                kosuDisplay.innerText = '-';
            }
        }

        function updateGraphicForRow(tr) {
            const planned = parseFloat(tr.querySelector('.planned-input')?.value) || 0;
            const present = parseFloat(tr.querySelector('.present-input')?.value) || 0;
            const net = parseFloat(tr.querySelector('.net-input')?.value) || 0;
            const obj = parseFloat(tr.querySelector('.obj-input')?.value) || 0;
            const good = parseFloat(tr.querySelector('.good-input')?.value) || 0;
            const coeff = parseFloat(tr.querySelector('.coeff-input')?.value) || 1;
            
            const pastille = tr.querySelector('.graphic-pastille');
            if (!pastille) return;

            // KOSU objectif théorique (basé sur les planifiés)
            let kosuObj = null;
            if (planned > 0 && net > 0 && obj > 0 && coeff > 0) {
                kosuObj = (planned * net) / (obj * coeff);
            }

            // KOSU réel
            let kosuReal = null;
            if (good > 0 && coeff > 0 && present > 0 && net > 0) {
                kosuReal = (present * net) / (good * coeff);
            }

            if (kosuObj !== null && kosuReal !== null && kosuObj > 0) {
                const ecart = ((kosuReal - kosuObj) / kosuObj) * 100;
                let cssClass, label;
                if (ecart > 35) {
                    cssClass = 'graphic-fonce';
                    label = '>35%';
                } else if (ecart > 25) {
                    cssClass = 'graphic-rouge';
                    label = '+25%';
                } else if (ecart > 15) {
                    cssClass = 'graphic-orange';
                    label = '+15%';
                } else if (ecart > 0) {
                    cssClass = 'graphic-jaune';
                    label = '0-15%';
                } else {
                    cssClass = 'graphic-vert';
                    label = '≤Obj';
                }
                pastille.className = `graphic-pastille ${cssClass}`;
                pastille.innerText = label;
            } else {
                pastille.className = 'graphic-pastille graphic-gris';
                pastille.innerText = '-';
            }
        }

        function updateCumuls() {
            let sumPlanned = 0, sumPresent = 0, sumNet = 0, sumObj = 0, sumGood = 0, sumBad = 0;
            let sumNumGlobal = 0, sumDenGlobal = 0;
            let completeCount = 0, rowCount = 0;

            document.querySelectorAll('#tableBody tr').forEach(tr => {
                rowCount++;
                const planned = parseFloat(tr.querySelector('.planned-input')?.value) || 0;
                const present = parseFloat(tr.querySelector('.present-input')?.value) || 0;
                const net = parseFloat(tr.querySelector('.net-input')?.value) || 0;
                const obj = parseFloat(tr.querySelector('.obj-input')?.value) || 0;
                const good = parseFloat(tr.querySelector('.good-input')?.value) || 0;
                const bad = parseFloat(tr.querySelector('.bad-input')?.value) || 0;
                const coeff = parseFloat(tr.querySelector('.coeff-input')?.value) || 1;
                const refSelect = tr.querySelector('.ref-select');
                const refOk = refSelect && refSelect.value !== '';

                sumPlanned += planned;
                sumPresent += present;
                sumNet += net;
                sumObj += obj;
                sumGood += good;
                sumBad += bad;

                sumNumGlobal += present * net;
                sumDenGlobal += good * coeff;

                if (refOk && good > 0 && present > 0 && net > 0) {
                    completeCount++;
                }
            });

            document.getElementById('sumPlanned').innerText = sumPlanned;
            document.getElementById('sumPresent').innerText = sumPresent.toFixed(1);
            document.getElementById('sumNetTime').innerText = sumNet.toFixed(2);
            document.getElementById('sumObj').innerText = sumObj;
            document.getElementById('sumGood').innerText = sumGood;
            document.getElementById('sumBad').innerText = sumBad;

            const totalProd = sumGood + sumBad;
            const defectRate = totalProd > 0 ? ((sumBad / totalProd) * 100).toFixed(2) : 0;
            document.getElementById('totalProduction').innerText = totalProd;
            document.getElementById('defectRate').innerText = defectRate + '%';

            let globalKosu = null;
            if (sumDenGlobal > 0) {
                globalKosu = (sumNumGlobal / sumDenGlobal).toFixed(2);
            }
            document.getElementById('globalKosuDisplay').innerText = globalKosu || '-';
            document.getElementById('globalKosuValue').innerText = globalKosu || '-';

            document.getElementById('lineCount').innerText = rowCount + ' ligne(s)';
            document.getElementById('completeCount').innerText = completeCount + ' complète(s)';
        }

        // ---------- Initialisation ----------
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';
            maxIndex = -1;

            // Priorité : oldDetails (après erreur)
            if (oldDetails.length > 0) {
                oldDetails.forEach((detail, idx) => {
                    detail.index = idx;
                    addRow(detail);
                });
            } 
            // Ensuite : newRows (après succès) -> on efface le localStorage
            else if (newRows.length > 0) {
                newRows.forEach((row, idx) => {
                    row.index = idx;
                    addRow(row);
                });
                localStorage.removeItem(STORAGE_KEY);
            } 
            // Sinon : charger depuis localStorage si valide
            else {
                const loaded = loadDraft();
                if (!loaded) {
                    // Aucune donnée, ligne par défaut
                    addRow({ index: 0 });
                }
            }

            updateCumuls();
        });

        // Bouton d'ajout de ligne
        document.getElementById('addRow').addEventListener('click', function() {
            addRow({});
            updateCumuls();
        });

        // Bouton d'effacement du brouillon
        document.getElementById('clearDraft').addEventListener('click', function() {
            if (confirm('Voulez-vous effacer toutes les données non enregistrées ?')) {
                localStorage.removeItem(STORAGE_KEY);
                document.getElementById('tableBody').innerHTML = '';
                maxIndex = -1;
                addRow({ index: 0 });
                updateCumuls();
                saveDraft();
            }
        });

        // Sauvegarde avant de quitter la page
        window.addEventListener('beforeunload', function() {
            saveDraft();
        });
    </script>
    

</body>
</html>