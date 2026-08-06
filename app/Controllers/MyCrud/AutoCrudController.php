<?php

declare(strict_types=1);

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\GlobalGenerationService;
use App\Libraries\MyCrud\Schema\TableFilter;
use Config\Database;
use RuntimeException;
use Throwable;

/**
 * Gestisce la generazione automatica globale dei CRUD.
 */
final class AutoCrudController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    /**
     * Mostra la selezione delle tabelle e dell'architettura.
     */
    public function index()
    {
        return view('mycrud/quick', [
            'title'  => 'Generazione automatica globale',
            'tables' => TableFilter::validTables(Database::connect()),
        ]);
    }

    /**
     * Esegue oppure simula la generazione delle tabelle selezionate.
     */
    public function generateAll()
    {
        $architecture = strtolower(trim((string) ($this->request->getPost('architecture') ?? config('MyCrud')->defaultArchitecture)));
        if (!in_array($architecture, ['basic', 'standard', 'full'], true)) {
            return redirect()->back()->withInput()->with('error', 'Architettura non valida.');
        }

        $availableTables = TableFilter::validTables(Database::connect());
        $selectedTables = array_values(array_intersect(
            $availableTables,
            array_map('strval', (array) $this->request->getPost('tables'))
        ));

        if ($selectedTables === []) {
            return redirect()->back()->withInput()
                ->with('error', 'Seleziona almeno una tabella.');
        }

        $force = $this->request->getPost('force') === '1';
        $dryRun = $this->request->getPost('dry_run') === '1';

        try {
            $report = (new GlobalGenerationService())->run(
                $selectedTables,
                $architecture,
                $force,
                $dryRun
            );

            $reportFile = $this->saveReport($report);

            return view('mycrud/quick_result', [
                'title'      => $dryRun ? 'Simulazione generazione globale' : 'Risultato generazione globale',
                'report'     => $report,
                'reportFile' => $reportFile,
            ]);
        } catch (Throwable $e) {
            log_message('error', '[myCrudGpt quick] {message} in {file}:{line}', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Scarica un report JSON generato dalla Quick globale.
     */
    public function report(string $file)
    {
        if (preg_match('/^mycrud_quick_[a-zA-Z0-9_-]+\.json$/', $file) !== 1) {
            throw new RuntimeException('Nome report non valido.');
        }

        $path = WRITEPATH . 'mycrud/reports/' . $file;

        if (!is_file($path)) {
            throw new RuntimeException('Report non trovato.');
        }

        return $this->response->download($path, null);
    }

    /**
     * Salva il report per consentirne il download.
     */
    private function saveReport(array $report): string
    {
        $directory = WRITEPATH . 'mycrud/reports';

        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('Impossibile creare la directory dei report.');
        }

        $file = 'mycrud_quick_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.json';
        $json = json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($json === false || file_put_contents($directory . '/' . $file, $json, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile salvare il report JSON.');
        }

        return $file;
    }
}
