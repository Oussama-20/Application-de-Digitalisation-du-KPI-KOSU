<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ $role }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        body {
            background: #f4f7fb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1300px;
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px -10px rgba(0,20,50,0.15);
            padding: 2rem 2rem 2.5rem;
        }

        /* En-tête */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .title-section h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #0b1a33;
            letter-spacing: -0.02em;
        }

        .title-section h1 span {
            background: linear-gradient(145deg, #2463eb, #1a4fc4);
            color: white;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.25rem 1rem;
            border-radius: 40px;
            margin-left: 0.75rem;
            vertical-align: middle;
        }

        .welcome-text {
            color: #4a5b73;
            font-size: 0.95rem;
            margin-top: 0.3rem;
        }

        .logout-form button {
            background: none;
            border: 1px solid #dde3ec;
            color: #4a5b73;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.6rem 1.5rem;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logout-form button:hover {
            background: #f0f4fe;
            border-color: #2463eb;
            color: #2463eb;
        }

        /* Grille des cards stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem 1.2rem;
            border-radius: 24px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            border: 1px solid #edf2f9;
            transition: transform 0.15s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(36,99,235,0.08);
            border-color: #d9e4ff;
        }

        .stat-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #6f7d95;
            margin-bottom: 0.75rem;
        }

        .stat-value {
            font-size: 2.8rem;
            font-weight: 700;
            color: #0b1a33;
            line-height: 1.2;
        }

        .stat-footer {
            font-size: 0.8rem;
            color: #6f7d95;
            margin-top: 0.6rem;
            border-top: 1px dashed #e5eef9;
            padding-top: 0.6rem;
        }

        /* couleurs nuancées par carte */
        .stat-card:nth-child(1) .stat-value { color: #2e3b4e; }        /* total */
        .stat-card:nth-child(2) .stat-value { color: #1c8b5c; }        /* bons */
        .stat-card:nth-child(3) .stat-value { color: #d48a2c; }        /* attention */
        .stat-card:nth-child(4) .stat-value { color: #c73b3b; }        /* critiques */

        /* section shifts récents */
        .recent-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
        }

        .recent-header h2 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #0b1a33;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .recent-header h2 span {
            background: #eef3fc;
            color: #2463eb;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 40px;
        }

        .badge-light {
            background: #eef3fc;
            color: #2463eb;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* tableau simple / liste */
        .shifts-table {
            width: 100%;
            border-collapse: collapse;
            background: #f9fcff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #eaf1fb;
        }

        .shifts-table th {
            text-align: left;
            padding: 1rem 1.2rem;
            background: #f1f7fd;
            color: #2e405b;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .shifts-table td {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid #e5eef9;
            color: #1f2c40;
            font-size: 0.95rem;
        }

        .shifts-table tr:last-child td {
            border-bottom: none;
        }

        .shifts-table tbody tr:hover td {
            background-color: #f1f7fe;
        }

        /* status badges */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
        }

        .status-bon {
            background: #e1f7ec;
            color: #1c8b5c;
        }

        .status-attention {
            background: #fff0db;
            color: #d48a2c;
        }

        .status-critique {
            background: #ffe8e8;
            color: #c73b3b;
        }

        /* styles pour les colonnes */
        .shift-ref {
            font-family: monospace;
            font-weight: 500;
            background: #edf3fa;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            display: inline-block;
        }

        .shift-kosu {
            font-family: monospace;
            font-weight: 600;
            color: #2463eb;
            background: #eef4ff;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            display: inline-block;
        }

        .shift-date {
            font-weight: 500;
            color: #0b1a33;
        }

        .shift-ligne {
            font-weight: 500;
        }

        /* responsive */
        @media (max-width: 1000px) {
            .stats-grid { gap: 1rem; }
        }

        @media (max-width: 800px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-container { padding: 1.5rem; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .shifts-table th, .shifts-table td { padding: 0.9rem; }
            .shifts-table th:nth-child(4), .shifts-table td:nth-child(4),
            .shifts-table th:nth-child(5), .shifts-table td:nth-child(5) {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- header -->
    <div class="dashboard-header">
        <div class="title-section">
            <h1>
                Dashboard <span>{{ ucfirst($role) }}</span>
            </h1>
            <p class="welcome-text">Bienvenue, vous êtes connecté comme <strong>{{ $role }}</strong></p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </div>

    <!-- 4 cards statistiques -->
    <div class="stats-grid">
        <!-- total shifts -->
        <div class="stat-card">
            <div class="stat-title">📋 Total Shifts</div>
            <div class="stat-value">158</div>
            <div class="stat-footer">+12% vs mois dernier</div>
        </div>
        <!-- shifts bons -->
        <div class="stat-card">
            <div class="stat-title">✅ Shifts Bons</div>
            <div class="stat-value">94</div>
            <div class="stat-footer">59.5% des shifts</div>
        </div>
        <!-- shifts attention -->
        <div class="stat-card">
            <div class="stat-title">⚠️ Shifts Attention</div>
            <div class="stat-value">41</div>
            <div class="stat-footer">25.9% du total</div>
        </div>
        <!-- shifts critiques -->
        <div class="stat-card">
            <div class="stat-title">🔴 Shifts Critiques</div>
            <div class="stat-value">23</div>
            <div class="stat-footer">14.6% à traiter</div>
        </div>
    </div>

    <!-- Shifts récents avec tableau -->
    <div class="recent-header">
        <h2>
            Shifts récents
            <span>5 derniers</span>
        </h2>
        <div class="badge-light">Mis à jour en temps réel</div>
    </div>

    <table class="shifts-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Shift</th>
                <th>Ligne</th>
                <th>Référence</th>
                <th>KOSU</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <!-- ligne 1 -->
            <tr>
                <td><span class="shift-date">2025-03-17</span></td>
                <td>Nuit (22h-06h)</td>
                <td class="shift-ligne">Ligne A3</td>
                <td><span class="shift-ref">REF-7845</span></td>
                <td><span class="shift-kosu">KOSU-7845</span></td>
                <td><span class="status-badge status-bon">Bon</span></td>
            </tr>
            <!-- ligne 2 -->
            <tr>
                <td><span class="shift-date">2025-03-17</span></td>
                <td>Jour (06h-14h)</td>
                <td class="shift-ligne">Ligne B2</td>
                <td><span class="shift-ref">REF-6521</span></td>
                <td><span class="shift-kosu">KOSU-6521</span></td>
                <td><span class="status-badge status-attention">Attention</span></td>
            </tr>
            <!-- ligne 3 -->
            <tr>
                <td><span class="shift-date">2025-03-16</span></td>
                <td>Après-midi (14h-22h)</td>
                <td class="shift-ligne">Ligne C1</td>
                <td><span class="shift-ref">REF-9134</span></td>
                <td><span class="shift-kosu">KOSU-9134</span></td>
                <td><span class="status-badge status-critique">Critique</span></td>
            </tr>
            <!-- ligne 4 -->
            <tr>
                <td><span class="shift-date">2025-03-16</span></td>
                <td>Nuit (22h-06h)</td>
                <td class="shift-ligne">Ligne A3</td>
                <td><span class="shift-ref">REF-4219</span></td>
                <td><span class="shift-kosu">KOSU-4219</span></td>
                <td><span class="status-badge status-bon">Bon</span></td>
            </tr>
            <!-- ligne 5 -->
            <tr>
                <td><span class="shift-date">2025-03-15</span></td>
                <td>Jour (06h-14h)</td>
                <td class="shift-ligne">Ligne D4</td>
                <td><span class="shift-ref">REF-5523</span></td>
                <td><span class="shift-kosu">KOSU-5523</span></td>
                <td><span class="status-badge status-attention">Attention</span></td>
            </tr>
        </tbody>
    </table>

    <!-- petite note design -->
    <div style="margin-top: 1.8rem; text-align: right; font-size: 0.75rem; color: #abbacf;">
        ⚡ vue d'ensemble • dernière activité il y a 2 minutes
    </div>
</div>
</body>
</html>