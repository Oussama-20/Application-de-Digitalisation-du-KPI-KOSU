<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Références</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f8f9fa;
            padding: 30px 20px;
        }
        
        .container {
            max-width: 1300px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 30px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #4361ee;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            background: #f0f4ff;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            background: #dbe4ff;
            transform: translateX(-5px);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .header h1 {
            color: #1a2639;
            font-size: 28px;
            font-weight: 600;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #4361ee;
            color: white;
        }
        
        .btn-primary:hover {
            background: #3046b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-edit {
            background: #3b82f6;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-delete:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: #4361ee;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 500;
            font-size: 14px;
            border: 1px solid #3046b3;
        }
        
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #e9ecef;
            color: #495057;
            font-size: 13px;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .reference-link {
            color: #4361ee;
            text-decoration: none;
            font-weight: 600;
        }
        
        .reference-link:hover {
            text-decoration: underline;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
        }
        
        .stats {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 13px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .badge {
            background: #e9ecef;
            color: #495057;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 25px;
        }

        .percentage-header {
            background: #2c3e50;
        }

        .date-cell {
            color: #2c3e50;
            font-weight: 500;
            background: #f0f7ff;
        }

        .today-badge {
            background: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            margin-left: 5px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bouton retour -->
        <a href="{{ route('dashboard.methodes') }}" class="back-link">
            ← Retour à la liste des méthodes
        </a>
        
        <div class="header">
            <h1>📋 GESTION DES REFERENCES</h1>
            <a href="{{ route('references.create') }}" class="btn btn-primary">
                + Nouvelle Référence
            </a>
        </div>
        
        <div class="badge">
            Gestion des références, coefficients, OST, KOSU Objectif et pourcentages
        </div>

        <div class="stats">
            <strong>{{ count($references) }}</strong> référence(s) trouvée(s)
        </div>

        <table>
            <thead>
                <tr>
                    <th>RÉFÉRENCE</th>
                    <th>COEFFICIENT</th>
                    <th>OST</th>
                    <th>KOSU OBJECTIF</th>
                    <th colspan="3">POURCENTAGES</th>
                    <th>DATE</th>
                    <th>CRÉÉ PAR</th>
                    <th>ACTIONS</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th>+15%</th>
                    <th>+25%</th>
                    <th>+35%</th>
                    <th colspan="3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($references as $ref)
                <tr>
                    <td>
                        <a href="{{ route('references.edit', $ref) }}" class="reference-link">
                            {{ $ref->reference }}
                        </a>
                    </td>
                    <td><strong>{{ number_format($ref->coefficient, 2) }}</strong></td>
                    <td>{{ $ref->ost ? number_format($ref->ost, 2) : '-' }}</td>
                    <td>{{ $ref->kosu_objectif ? number_format($ref->kosu_objectif, 2) : '-' }}</td>
                    <td>{{ $ref->pourcentage_15 ? number_format($ref->pourcentage_15, 2) : '-' }}</td>
                    <td>{{ $ref->pourcentage_25 ? number_format($ref->pourcentage_25, 2) : '-' }}</td>
                    <td>{{ $ref->pourcentage_35 ? number_format($ref->pourcentage_35, 2) : '-' }}</td>
                    
                    <!-- Date avec format jour/mois/année -->
                    <td class="date-cell">
                        {{ $ref->created_at->format('d/m/Y') }}
                        @if($ref->created_at->isToday())
                            <span class="today-badge">Aujourd'hui</span>
                        @endif
                    </td>
                    
                    <td>{{ $ref->created_by }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('references.edit', $ref) }}" class="btn-edit">
                                ✏️ Modifier
                            </a>
                            <form action="{{ route('references.destroy', $ref) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette référence ?')">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="empty-state">
                        🕒 Aucune référence trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            LEONI_BOUZNIKA
        </div>
    </div>
</body>
</html>