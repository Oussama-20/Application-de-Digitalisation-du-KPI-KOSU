<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Référence</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .header h1 {
            color: #1a2639;
            font-size: 24px;
            font-weight: 600;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-back {
            background: #6c757d;
            color: white;
        }
        
        .btn-back:hover {
            background: #5a6268;
        }
        
        .btn-primary {
            background: #4361ee;
            color: white;
            padding: 12px 24px;
            font-size: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: #3046b3;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #1a2639;
            font-weight: 500;
            font-size: 14px;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #4361ee;
        }
        
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin: 30px 0 20px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #4361ee;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 13px;
        }
        
        .required::after {
            content: " *";
            color: #dc3545;
        }
        
        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 8px;
        }

        .obligatoire {
            background: #dc3545;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            margin-left: 8px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ Modifier Référence</h1>
            <a href="{{ route('references.index') }}" class="btn btn-back">
                ← Retour
            </a>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; color: #dc3545; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <strong>⚠️ Veuillez corriger les erreurs :</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('references.update', $reference) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Référence et Coefficient -->
            <div class="row">
                <div class="form-group">
                    <label class="required">Référence <span class="obligatoire">Obligatoire</span></label>
                    <input type="text" 
                           name="reference" 
                           value="{{ old('reference', $reference->reference) }}" 
                           placeholder="Ex: REF-A100"
                           required>
                    @error('reference')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required">Coefficient <span class="obligatoire">Obligatoire</span></label>
                    <input type="number" 
                           name="coefficient" 
                           value="{{ old('coefficient', $reference->coefficient) }}"
                           step="0.01" 
                           min="0" 
                           placeholder="Ex: 1.5"
                           required>
                    @error('coefficient')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- OST et KOSU Objectif -->
            <div class="row">
                <div class="form-group">
                    <label class="required">OST <span class="obligatoire">Obligatoire</span></label>
                    <input type="number" 
                           name="ost" 
                           value="{{ old('ost', $reference->ost) }}"
                           step="0.01" 
                           min="0" 
                           placeholder="Ex: 2.5"
                           required>
                    @error('ost')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required">KOSU Objectif <span class="obligatoire">Obligatoire</span></label>
                    <input type="number" 
                           name="kosu_objectif" 
                           value="{{ old('kosu_objectif', $reference->kosu_objectif) }}"
                           step="0.01" 
                           min="0" 
                           placeholder="Ex: 1.2"
                           required>
                    @error('kosu_objectif')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Pourcentages -->
            <div class="section-title">📊 Pourcentages (Tous obligatoires)</div>
            
            <div class="row-3">
                <div class="form-group">
                    <label class="required">+15% <span class="obligatoire">Obligatoire</span></label>
                    <input type="number" 
                           name="pourcentage_15" 
                           value="{{ old('pourcentage_15', $reference->pourcentage_15) }}"
                           step="0.01" 
                           min="0" 
                           placeholder="0.00"
                           required>
                    @error('pourcentage_15')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required">+25% <span class="obligatoire">Obligatoire</span></label>
                    <input type="number" 
                           name="pourcentage_25" 
                           value="{{ old('pourcentage_25', $reference->pourcentage_25) }}"
                           step="0.01" 
                           min="0" 
                           placeholder="0.00"
                           required>
                    @error('pourcentage_25')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required">+35% <span class="obligatoire">Obligatoire</span></label>
                    <input type="number" 
                           name="pourcentage_35" 
                           value="{{ old('pourcentage_35', $reference->pourcentage_35) }}"
                           step="0.01" 
                           min="0" 
                           placeholder="0.00"
                           required>
                    @error('pourcentage_35')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Créé par (hidden) -->
            <input type="hidden" name="created_by" value="ME001">

            <div style="text-align: right; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    💾 Mettre à jour
                </button>
            </div>
        </form>

        <div class="footer">
            LEONI_BOUZNIKA
        </div>
    </div>
</body>
</html>