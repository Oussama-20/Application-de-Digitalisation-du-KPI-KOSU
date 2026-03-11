<?php
// app/Http/Controllers/ExcelImportController.php

namespace App\Http\Controllers;

use App\Models\ExcelImport;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class ExcelImportController extends Controller
{
    public function index()
    {
        $imports = ExcelImport::latest()->take(50)->get();
        return view('import-excel', compact('imports'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'fichier_excel' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        try {
            $file = $request->file('fichier_excel');
            
            // Charger le fichier Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Ignorer les 3 premières lignes (titre et lignes vides)
            $headers = array_map('trim', $rows[3] ?? []);
            
            // Récupérer les données à partir de la ligne 5
            $data = [];
            for ($i = 4; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (!empty(array_filter($row))) {
                    $data[] = $row;
                }
            }

            session([
                'preview_headers' => $headers,
                'preview_data' => $data,
                'file_name' => $file->getClientOriginalName(),
                'show_preview' => true
            ]);

            return redirect()->route('import.excel.form')
                ->with('success', '✅ Fichier chargé : ' . count($data) . ' lignes trouvées.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function confirm(Request $request)
    {
        try {
            $headers = session('preview_headers');
            $data = session('preview_data');
            $fileName = session('file_name');

            if (!$data || !$headers) {
                return redirect()->route('import.excel.form')
                    ->with('error', 'Aucune donnée à importer.');
            }

            $imported = 0;
            $errors = 0;
            $importedIds = [];

            foreach ($data as $rowIndex => $row) {
                try {
                    // Créer un tableau associatif avec les index
                    $rowData = [];
                    foreach ($headers as $colIndex => $header) {
                        $cleanHeader = trim($header);
                        $value = $row[$colIndex] ?? null;
                        $rowData[$cleanHeader] = $value;
                    }

                    // Mapper les colonnes (avec les noms EXACTS du fichier)
                    $import = ExcelImport::create([
                        'reference_rnlt' => $rowData['reference RNLT'] ?? null,
                        'reference_sigip' => $rowData['reference SIGIP'] ?? null,
                        'temps_ass_min' => $this->parseNumber($rowData['Temps Ass        ( min )'] ?? null),
                        'temps_ass_h' => $this->parseNumber($rowData['Temps Ass         (H )'] ?? null),
                        'efficience_e1' => $this->parseNumber($rowData['Efficience E1'] ?? null),
                        'effectif_e1' => $this->parseNumber($rowData['Effectif  E1'] ?? null),
                        'effectif_kosu' => $this->parseNumber($rowData['Effectif KOSU'] ?? null),
                        'temps_presence' => $this->parseNumber($rowData['Temps de présence'] ?? null),
                        'nbr_heures_produire' => $this->parseNumber($rowData['nbr des heures à produire'] ?? null),
                        'cad_equipe' => $this->parseNumber($rowData['Cad/Equipe'] ?? null),
                        'cad_h' => $this->parseNumber($rowData['Cad/H'] ?? null),
                        't_cycle_m' => $this->parseNumber($rowData['T.CYCLE (m)'] ?? null),
                        't_cycle_s' => $this->parseNumber($rowData['T.CYCLE (S)'] ?? null),
                        'coef' => $this->parseNumber($rowData['COEF'] ?? null),
                        'nom_fichier' => $fileName,
                        'date_import' => now()
                    ]);

                    $imported++;
                    $importedIds[] = $import->id;

                } catch (\Exception $e) {
                    $errors++;
                }
            }

            $importedData = ExcelImport::whereIn('id', $importedIds)->get();

            session()->forget(['preview_headers', 'preview_data', 'file_name', 'show_preview']);
            
            session([
                'import_success' => true,
                'imported_count' => $imported,
                'imported_data' => $importedData
            ]);

            $message = "✅ Import terminé : $imported lignes ajoutées.";
            if ($errors > 0) {
                $message .= " ⚠️ $errors erreurs.";
            }

            return redirect()->route('import.excel.form')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('import.excel.form')
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    private function parseNumber($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }
        
        // Si c'est déjà un nombre
        if (is_numeric($value)) {
            return (float) $value;
        }
        
        // Remplacer la virgule par un point
        $value = str_replace(',', '.', $value);
        
        return (float) $value;
    }
}