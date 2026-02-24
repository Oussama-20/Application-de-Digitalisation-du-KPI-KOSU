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
            margin-bottom: 8px;
        }

        .role-badge {
            background: #eef4ff;
            color: #2b7fff;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
        }

        .icon-large {
            width: 70px;
            height: 70px;
            background: #f9fcff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            border: 1px solid #e2edff;
            box-shadow: 0 6px 12px -6px rgba(0, 80, 200, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #122b44;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: #f9fcff;
            border: 1.5px solid #e9f0fa;
            border-radius: 18px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #2b7fff;
            background: white;
        }

        .form-input::placeholder {
            color: #8b9ab5;
        }

        .btn {
            width: 100%;
            background: #2b7fff;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 40px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 6px 14px -6px #2b7fff;
            margin-top: 10px;
        }

        .btn:hover {
            background: #1a6be0;
        }

        .error-box {
            background: #fff2f2;
            border: 1.5px solid #ffc9c9;
            color: #d14545;
            padding: 14px 18px;
            border-radius: 18px;
            margin: 20px 0 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-box::before {
            content: "⚠️";
            font-size: 16px;
        }

        .footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: #8b9ab5;
            border-top: 1.5px dashed #dbe6f5;
            padding-top: 20px;
        }

        .back-link {
            text-align: center;
            margin-top: 16px;
        }

        .back-link a {
            color: #5e6f88;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-link a:hover {
            color: #2b7fff;
        }

        .back-link a::before {
            content: "←";
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="icon-large">
                @switch($role)
                    @case('methodes')
                        📊
                        @break
                    @case('shift_leader')
                        👥
                        @break
                    @case('supervision')
                        📋
                        @break
                    @default
                        👤
                @endswitch
            </div>
            
            <h1>Connexion</h1>
            <span class="role-badge">Profil {{ ucfirst($role) }}</span>
        </div>

        <form method="POST" action="{{ route('login.perform',$role) }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" 
                       name="email" 
                       class="form-input" 
                       placeholder="leoni@email.com" 
                       value="{{ old('email') }}"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <input type="password" 
                       name="password" 
                       class="form-input" 
                       placeholder="••••••••"
                       required>
            </div>
            <div class="form-check">
    <input type="checkbox" name="remember" id="remember" class="switch-input">
    <label for="remember" class="switch-label">
        <span class="switch-custom"></span>
        <span>Se souvenir de moi</span>
    </label>
</div>
            <button type="submit" class="btn">Se connecter</button>
        </form>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="back-link">
    <a href="/">Retour Acceuil</a>
</div>

        <div class="footer">
            ⚡ Connexion sécurisée · environnement professionnel
        </div>
    </div>
</body>
</html>