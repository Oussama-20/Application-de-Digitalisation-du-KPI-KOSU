<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - {{ ucfirst($role) }}</title>
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
            position: relative;
        }

        /* Éléments décoratifs légers inspirés de l'accueil */
        body::before {
            content: '';
            position: fixed;
            width: 300px;
            height: 300px;
            background: rgba(43, 127, 255, 0.03);
            border-radius: 50%;
            top: -150px;
            right: -100px;
        }

        body::after {
            content: '';
            position: fixed;
            width: 250px;
            height: 250px;
            background: rgba(43, 127, 255, 0.03);
            border-radius: 50%;
            bottom: -100px;
            left: -80px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            max-height: 90vh; /* Limite la hauteur à 90% de l'écran */
            overflow-y: auto; /* Scroll uniquement si nécessaire */
            box-shadow: 0 20px 40px -10px rgba(0, 40, 100, 0.2);
            position: relative;
            z-index: 10;
            animation: fadeIn 0.5s ease;
            
            /* Cache la scrollbar par défaut mais garde la fonctionnalité */
            scrollbar-width: thin;
            scrollbar-color: #2b7fff #e9f0fa;
        }

        /* Style de la scrollbar pour Chrome/Safari */
        .card::-webkit-scrollbar {
            width: 6px;
        }

        .card::-webkit-scrollbar-track {
            background: #e9f0fa;
            border-radius: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .card::-webkit-scrollbar-thumb {
            background: #2b7fff;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card::-webkit-scrollbar-thumb:hover {
            background: #1a6be0;
        }

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

        .header {
            text-align: center;
            margin-bottom: 32px;
            /* Le header reste collé en haut même avec scroll */
            position: sticky;
            top: 0;
            background: white;
            padding-top: 5px;
            z-index: 5;
        }

        /* Ajout d'un petit ombrage quand on scrolle */
        .header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(to bottom, white, transparent);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card.scrolling .header::after {
            opacity: 1;
        }

        .icon-large {
            width: 80px;
            height: 80px;
            background: #f5faff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 40px;
            border: 1px solid #e2edff;
            box-shadow: 0 10px 20px -8px rgba(43, 127, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .icon-large:hover {
            transform: scale(1.02);
        }

        h1 {
            color: #0b2b4f;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .role-badge {
            background: #eef4ff;
            color: #2b7fff;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.95rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid rgba(43, 127, 255, 0.2);
            animation: gentlePulse 3s infinite ease-in-out;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e3a5f;
            font-size: 0.95rem;
            padding-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 16px 18px;
            background: #f9fcff;
            border: 1.5px solid #e9f0fa;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.2s ease;
            color: #122b44;
        }

        .form-input:focus {
            outline: none;
            border-color: #2b7fff;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(43, 127, 255, 0.1);
        }

        .form-input::placeholder {
            color: #9aabbf;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 28px 0;
            position: relative;
            z-index: 2;
        }

        .form-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #2b7fff;
            border-radius: 4px;
            border: 2px solid #d0ddee;
            cursor: pointer;
        }

        .form-check label {
            color: #2c4c73;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: #2b7fff;
            border: none;
            border-radius: 40px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(43, 127, 255, 0.3);
            text-transform: uppercase;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .btn:hover {
            background: #1a6be0;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(43, 127, 255, 0.4);
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(43, 127, 255, 0.3);
        }

        .error-box {
            background: #fff5f5;
            border: 1.5px solid #ffcdd2;
            border-radius: 16px;
            padding: 16px 20px;
            color: #c62828;
            font-weight: 500;
            margin: 15px 0 20px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
        }

        .error-box::before {
            content: '⚠️';
            font-size: 1.2rem;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1.5px dashed #dbe6f5;
            position: relative;
            z-index: 2;
        }

        .back-link a {
            color: #5e6f88;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link a:hover {
            color: #2b7fff;
        }

        @keyframes gentlePulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }

        /* Variation légère selon le rôle (uniquement sur l'icône) */
        @switch($role)
            @case('methodes')
                .icon-large { background: linear-gradient(145deg, #f5faff, #e8f2ff); }
                @break
            @case('shift_leader')
                .icon-large { background: linear-gradient(145deg, #f5faff, #eaf3ff); }
                @break
            @case('superviseur')
                .icon-large { background: linear-gradient(145deg, #f5faff, #ecf4ff); }
                @break
        @endswitch

        /* Focus visible accessibilité */
        .btn:focus-visible,
        .form-input:focus-visible {
            outline: 3px solid rgba(43, 127, 255, 0.4);
            outline-offset: 2px;
        }

        /* Ajustement pour très petits écrans */
        @media (max-height: 700px) {
            .card {
                padding: 25px;
            }
            
            .icon-large {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .form-group {
                margin-bottom: 16px;
            }
            
            .form-input {
                padding: 14px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="card" id="loginCard">
        <div class="header">
            <div class="icon-large">
                @switch($role)
                    @case('methodes') 📊 @break
                    @case('shift_leader') 👥 @break
                    @case('superviseur') 📋 @break
                    @default 👤
                @endswitch
            </div>
            <h1>Connexion</h1>
            <span class="role-badge">Profil {{ ucfirst($role) }}</span>
        </div>

        <form method="POST" action="{{ route('login.perform',$role) }}">
            @csrf
            <div class="form-group">
                <label>📧 Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="exemple@leoni.com" required>
            </div>

            <div class="form-group">
                <label>🔒 Mot de passe</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn">Se connecter</button>
        </form>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="back-link">
            <a href="/">← Retour à l'accueil</a>
        </div>
    </div>

    <script>
        // Détecter le scroll pour ajouter un effet visuel
        const card = document.getElementById('loginCard');
        card.addEventListener('scroll', function() {
            if (this.scrollTop > 10) {
                this.classList.add('scrolling');
            } else {
                this.classList.remove('scrolling');
            }
        });
    </script>
</body>
</html>