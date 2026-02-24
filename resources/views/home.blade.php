<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portails de connexion - LEONI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(145deg, #f0f5ff 0%, #e6f0ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px -10px rgba(0, 40, 100, 0.2);
            width: 420px;
            padding: 32px;
        }

        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .header h1 {
            color: #0b2b4f;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .header p {
            color: #5e6f88;
            font-size: 14px;
            margin-top: 6px;
        }

        .portail-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .portail-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            background: #f9fcff;
            border: 1.5px solid #e9f0fa;
            border-radius: 18px;
            transition: all 0.2s ease;
        }

        .portail-item:hover {
            border-color: #2b7fff;
            background: #f5faff;
            transform: scale(1.01);
        }

        .info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .icon {
            width: 42px;
            height: 42px;
            background: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 6px 12px -6px rgba(0, 80, 200, 0.2);
            border: 1px solid #e2edff;
        }

        .text h3 {
            color: #122b44;
            font-size: 16px;
            font-weight: 600;
        }

        .text small {
            color: #6f7d95;
            font-size: 13px;
            display: block;
            margin-top: 3px;
        }

        /* Style amélioré pour les boutons */
        .btn-portail {
            background: #2b7fff;
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(43, 127, 255, 0.3);
            text-decoration: none;
            display: inline-block;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border: 2px solid transparent;
        }

        .btn-portail:hover {
            background: #1a6be0;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(43, 127, 255, 0.4);
        }

        .btn-portail:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(43, 127, 255, 0.3);
        }

        /* Suppression du style button par défaut dans les liens */
        a {
            text-decoration: none;
        }

        .footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: #8b9ab5;
            border-top: 1.5px dashed #dbe6f5;
            padding-top: 20px;
        }

        .badge {
            background: #eef4ff;
            color: #2b7fff;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 10px;
        }

        /* Animation subtile au chargement */
        .portail-item {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .portail-item:nth-child(1) { animation-delay: 0.1s; }
        .portail-item:nth-child(2) { animation-delay: 0.2s; }
        .portail-item:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Focus visible pour l'accessibilité */
        .btn-portail:focus-visible {
            outline: 3px solid rgba(43, 127, 255, 0.4);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>🔐 Portails d'accès</h1>
            <p>LEONI Bouznika · Sélectionnez votre profil</p>
        </div>

        <div class="portail-list">
            <!-- Supervision -->
            <div class="portail-item">
                <div class="info">
                    <div class="icon">📋</div>
                    <div class="text">
                        <h3>Supervision</h3>
                        <small>Gestion et contrôle</small>
                    </div>
                </div>
                <a href="/login/supervision" class="btn-portail">Accéder</a>
            </div>

            <!-- Shift Leader -->
            <div class="portail-item">
                <div class="info">
                    <div class="icon">👥</div>
                    <div class="text">
                        <h3>Shift Leader</h3>
                        <small>Management d'équipe</small>
                    </div>
                </div>
                <a href="/login/shift_leader" class="btn-portail">Accéder</a>
            </div>

            <!-- Méthodes -->
            <div class="portail-item">
                <div class="info">
                    <div class="icon">📊</div>
                    <div class="text">
                        <h3>Méthodes</h3>
                        <small>Optimisation processus</small>
                    </div>
                </div>
                <a href="/login/methodes" class="btn-portail">Accéder</a>
            </div>
        </div>

        <div class="footer">
            ⚡ Connexion sécurisée · environnement professionnel
            
            
        </div>
    </div>
</body>
</html>