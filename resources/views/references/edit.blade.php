<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Référence</title>
    <style>
        /* Mêmes styles que la vue create */
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
            padding: 12px;
            font-size: 15px;
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
        
        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .button-group button, .button-group a {
            flex: 1;
            text-align: center;
        }
        
        .required {
            color: #dc3545;
            font-size: 13px;
            margin-left: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 13px;
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

        <form action="{{ route('references.update', $reference) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="reference">
                    Référence <span class="required">*</span>
                </label>
                <input type="text" 
                       id="reference" 
                       name="reference" 
                       value="{{ old('reference', $reference->reference) }}" 
                       placeholder="Ex: REF-A100"
                       required>
                @error('reference')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nom (optionnel)</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $reference->name) }}" 
                       placeholder="Ex: Réference test">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="coefficient">
                    Coefficient <span class="required">*</span>
                </label>
                <input type="number" 
                       id="coefficient" 
                       name="coefficient" 
                       value="{{ old('coefficient', $reference->coefficient) }}" 
                       step="0.1" 
                       min="0" 
                       max="9999.99"
                       placeholder="Ex: 1.5"
                       required>
                @error('coefficient')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description (optionnelle)</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          placeholder="Description de la référence...">{{ old('description', $reference->description) }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    💾 Mettre à jour
                </button>
                <a href="{{ route('references.index') }}" class="btn btn-back">
                    ✖ Annuler
                </a>
            </div>
        </form>

        <div class="footer">
            Made with Emergent
        </div>
    </div>
</body>
</html>