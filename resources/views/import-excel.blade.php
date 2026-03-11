<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Fichier Excel - Méthodes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f4f7fb;
            padding: 30px 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px -10px rgba(0,20,50,0.15);
            padding: 40px;
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
            color: #0b1a33;
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header h1 span {
            background: linear-gradient(145deg, #2463eb, #1a4fc4);
            color: white;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 40px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 40px;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-back {
            background: #f0f4fe;
            color: #2463eb;
            border: 1px solid #d9e4ff;
        }
        
        .btn-back:hover {
            background: #2463eb;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(36,99,235,0.3);
        }
        
        .btn-primary {
            background: #2463eb;
            color: white;
            padding: 14px 30px;
            font-size: 16px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-primary:hover {
            background: #1a4fc4;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(36,99,235,0.4);
        }
        
        .btn-success {
            background: #1c8b5c;
            color: white;
            padding: 12px 25px;
            border-radius: 40px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn-success:hover {
            background: #146b46;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(28,139,92,0.3);
        }
        
        .upload-area {
            background: #f9fcff;
            border: 2px dashed #cbd5e1;
            border-radius: 20px;
            padding: 40px 20px;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .upload-area:hover {
            border-color: #2463eb;
            background: #f0f7ff;
        }
        
        .upload-area.dragover {
            border-color: #2463eb;
            background: #e3f0ff;
            transform: scale(1.02);
        }
        
        .upload-icon {
            width: 70px;
            height: 70px;
            background: #eef4ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .upload-icon svg {
            width: 35px;
            height: 35px;
            stroke: #2463eb;
        }
        
        .file-info {
            background: #eef4ff;
            border-radius: 40px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #2463eb;
            font-weight: 500;
        }
        
        .file-info .remove-file {
            color: #dc3545;
            cursor: pointer;
            margin-left: 10px;
            font-weight: bold;
        }
        
        .file-info .remove-file:hover {
            text-decoration: underline;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            overflow-x: auto;
            display: block;
            max-height: 500px;
            overflow-y: auto;
        }
        
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background: #2463eb;
            color: white;
            padding: 12px 8px;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .data-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #e9ecef;
            font-size: 12px;
            white-space: nowrap;
        }
        
        .data-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .action-bar {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin: 20px 0;
        }
        
        .error {
            color: #dc3545;
            padding: 15px;
            background: #ffe8e8;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .success {
            color: #1c8b5c;
            padding: 15px;
            background: #e1f7ec;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .loading {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        
        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid #eef4ff;
            border-top: 3px solid #2463eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .badge-info {
            background: #eef4ff;
            color: #2463eb;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-left: 10px;
        }

        .null-value {
            color: #999;
            font-style: italic;
            background: #f5f5f5;
        }

        .error-message {
            color: #dc3545;
            background: #ffe8e8;
            border: 1px solid #ffb3b3;
            padding: 15px;
            border-radius: 12px;
            margin: 10px 0;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .error-message.show {
            display: flex;
        }

        .error-message svg {
            width: 24px;
            height: 24px;
            stroke: #dc3545;
        }

        .file-type-badge {
            background: #eef4ff;
            color: #2463eb;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                📁 Import Fichier Excel
                <span>Méthodes</span>
            </h1>
            <a href="{{ route('dashboard.methodes') }}" class="btn btn-back">
                ← Retour
            </a>
        </div>

        <!-- Message d'erreur personnalisé pour mauvais type de fichier -->
        <div class="error-message" id="fileTypeError">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>❌ Type de fichier non valide !</strong><br>
                Veuillez sélectionner uniquement des fichiers Excel (.xlsx ou .xls)
            </div>
        </div>

        @if(session('success'))
            <div class="success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Formulaire d'upload -->
        <form action="{{ route('import.excel.preview') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            
            <div class="upload-area" id="uploadArea">
                <input type="file" 
                       name="fichier_excel" 
                       id="fileInput" 
                       accept=".xlsx,.xls" 
                       style="display: none;" 
                       required>
                
                <div class="upload-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </div>
                
                <h3>Cliquez ou glissez-déposez votre fichier Excel</h3>
                <p>Formats acceptés : <strong class="file-type-badge">.xlsx</strong> <strong class="file-type-badge">.xls</strong> (Max 10 Mo)</p>
                
                <div id="fileInfo" style="display: none;">
                    <div class="file-info">
                        <span>📄 <span id="fileName"></span></span>
                        <span id="fileSize"></span>
                        <span id="fileExtension" style="background: #2463eb; color: white; padding: 2px 8px; border-radius: 12px;"></span>
                        <span class="remove-file" onclick="removeFile()">✕ Supprimer</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary" id="previewBtn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Aperçu des données
            </button>
        </form>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <span>Traitement en cours...</span>
        </div>

        <!-- Aperçu des données -->
        @if(session('preview_data') && session('show_preview'))
            <div style="margin-top: 40px;">
                <h2 style="margin-bottom: 20px;">
                    📊 Aperçu ({{ count(session('preview_data')) }} lignes)
                    <span class="badge-info">{{ session('file_name') }}</span>
                </h2>
                
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                @foreach(session('preview_headers') as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('preview_data') as $row)
                                <tr>
                                    @foreach($row as $cell)
                                        <td class="{{ $cell === null || $cell === '' ? 'null-value' : '' }}">
                                            {{ $cell === null || $cell === '' ? 'NULL' : $cell }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="action-bar">
                    <form action="{{ route('import.excel.confirm') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-success" onclick="return confirm('Confirmer l\'import en base ?')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Confirmer l'import
                        </button>
                    </form>
                    <a href="{{ route('import.excel.form') }}" class="btn-back">Nouvel import</a>
                </div>
            </div>
        @endif

        <!-- Résultat après import -->
        @if(session('import_success') && session('imported_data') && session('imported_data')->count() > 0)
            <div style="margin-top: 40px;">
                <h2 style="margin-bottom: 20px;">
                    ✅ Import réussi ({{ session('imported_count') }} lignes)
                </h2>
                
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Réf RNLT</th>
                                <th>Réf SIGIP</th>
                                <th>Tps Ass min</th>
                                <th>Tps Ass H</th>
                                <th>Eff E1</th>
                                <th>Eff KOSU</th>
                                <th>Tps présence</th>
                                <th>Nbr h prod</th>
                                <th>Cad/Equipe</th>
                                <th>Cad/H</th>
                                <th>T.CYCLE m</th>
                                <th>T.CYCLE s</th>
                                <th>COEF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('imported_data') as $imp)
                            <tr>
                                <td>{{ $imp->id }}</td>
                                <td class="{{ $imp->reference_rnlt ? '' : 'null-value' }}">{{ $imp->reference_rnlt ?? 'NULL' }}</td>
                                <td class="{{ $imp->reference_sigip ? '' : 'null-value' }}">{{ $imp->reference_sigip ?? 'NULL' }}</td>
                                <td class="{{ $imp->temps_ass_min ? '' : 'null-value' }}">{{ $imp->temps_ass_min ?? 'NULL' }}</td>
                                <td class="{{ $imp->temps_ass_h ? '' : 'null-value' }}">{{ $imp->temps_ass_h ?? 'NULL' }}</td>
                                <td class="{{ $imp->effectif_e1 ? '' : 'null-value' }}">{{ $imp->effectif_e1 ?? 'NULL' }}</td>
                                <td class="{{ $imp->effectif_kosu ? '' : 'null-value' }}">{{ $imp->effectif_kosu ?? 'NULL' }}</td>
                                <td class="{{ $imp->temps_presence ? '' : 'null-value' }}">{{ $imp->temps_presence ?? 'NULL' }}</td>
                                <td class="{{ $imp->nbr_heures_produire ? '' : 'null-value' }}">{{ $imp->nbr_heures_produire ?? 'NULL' }}</td>
                                <td class="{{ $imp->cad_equipe ? '' : 'null-value' }}">{{ $imp->cad_equipe ?? 'NULL' }}</td>
                                <td class="{{ $imp->cad_h ? '' : 'null-value' }}">{{ $imp->cad_h ?? 'NULL' }}</td>
                                <td class="{{ $imp->t_cycle_m ? '' : 'null-value' }}">{{ $imp->t_cycle_m ?? 'NULL' }}</td>
                                <td class="{{ $imp->t_cycle_s ? '' : 'null-value' }}">{{ $imp->t_cycle_s ?? 'NULL' }}</td>
                                <td class="{{ $imp->coef ? '' : 'null-value' }}">{{ $imp->coef ?? 'NULL' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="action-bar">
                    <a href="{{ route('import.excel.form') }}" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Nouvel import
                    </a>
                </div>
            </div>

            @php
                session()->forget(['import_success', 'imported_data', 'imported_count', 'preview_data', 'preview_headers', 'show_preview']);
            @endphp
        @endif
    </div>

    <script>
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileExtension = document.getElementById('fileExtension');
        const previewBtn = document.getElementById('previewBtn');
        const loading = document.getElementById('loading');
        const importForm = document.getElementById('importForm');
        const fileTypeError = document.getElementById('fileTypeError');

        // Extensions autorisées
        const allowedExtensions = ['xlsx', 'xls'];

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                if (validateFileType(file)) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileInfo(file);
                }
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                if (validateFileType(file)) {
                    updateFileInfo(file);
                } else {
                    // Réinitialiser l'input si le fichier n'est pas valide
                    fileInput.value = '';
                }
            }
        });

        function validateFileType(file) {
            const fileName = file.name;
            const fileExt = fileName.split('.').pop().toLowerCase();
            
            if (!allowedExtensions.includes(fileExt)) {
                // Afficher le message d'erreur
                fileTypeError.classList.add('show');
                
                // Cacher les infos du fichier
                fileInfo.style.display = 'none';
                
                // Faire défiler jusqu'au message d'erreur
                fileTypeError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Désactiver le bouton preview
                previewBtn.disabled = true;
                
                return false;
            } else {
                // Cacher le message d'erreur si le fichier est valide
                fileTypeError.classList.remove('show');
                previewBtn.disabled = false;
                return true;
            }
        }

        function updateFileInfo(file) {
            const size = (file.size / 1024).toFixed(2);
            const fileExt = file.name.split('.').pop().toUpperCase();
            
            fileName.textContent = file.name;
            fileSize.textContent = `(${size} Ko)`;
            fileExtension.textContent = fileExt;
            fileInfo.style.display = 'block';
            
            // Cacher le message d'erreur
            fileTypeError.classList.remove('show');
            previewBtn.disabled = false;
        }

        window.removeFile = function() {
            fileInput.value = '';
            fileInfo.style.display = 'none';
            fileTypeError.classList.remove('show');
            previewBtn.disabled = false;
        };

        importForm.addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Veuillez sélectionner un fichier');
                return;
            }
            
            const file = fileInput.files[0];
            const fileExt = file.name.split('.').pop().toLowerCase();
            
            if (!allowedExtensions.includes(fileExt)) {
                e.preventDefault();
                fileTypeError.classList.add('show');
                fileTypeError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            
            previewBtn.disabled = true;
            loading.style.display = 'flex';
        });
    </script>
</body>
</html>