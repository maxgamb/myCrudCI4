<?php

declare(strict_types=1);

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\ConfiguredGenerationService;
use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\Core\ProjectDashboardService;
use App\Libraries\MyCrud\Diagnostics\DiagnosticReport;
use App\Libraries\MyCrud\Diagnostics\GenerationDiffService;
use App\Libraries\MyCrud\Diagnostics\IndexAnalyzer;
use App\Libraries\MyCrud\Diagnostics\PersistentConfigAnalyzer;
use Throwable;

/**
 * Project dashboard.
 *
 * Generation actions continue to write exclusively to staging
 * app/Generated/. The Dashboard never writes directly to app/.
 */
final class ProjectController extends BaseController
{
    public function index(): string
    {
        return view('mycrud/project_dashboard', [
            'title' => 'Project Dashboard',
            'project' => (new ProjectDashboardService())->build(),
        ]);
    }

    public function generate(string $table)
    {
        try {
            $configuration = new CrudConfigurationService();
            $resolved = $configuration->resolve($table, true);

            if (!$resolved['saved']) {
                return redirect()
                    ->to(site_url('mycrud/builder/configure/' . $table))
                    ->with('error', 'Configure and save the CRUD first: ' . $table . '.');
            }

            $result = (new CrudGeneratorService())->generate($resolved['config'], true);

            return redirect()
                ->to(site_url('mycrud'))
                ->with(
                    'message',
                    sprintf(
                        'CRUD %s [%s] generated in app/Generated/.',
                        $table,
                        (string) ($result['architecture'] ?? '')
                    )
                );
        } catch (Throwable $e) {
            return redirect()
                ->to(site_url('mycrud'))
                ->with('error', $e->getMessage());
        }
    }

    public function generateAll()
    {
        $report = (new ConfiguredGenerationService())->generateAll(null, true);

        $message = sprintf(
            'Generation complete: OK %d | FAIL %d | SCHEMA DRIFT %d.',
            (int) ($report['summary']['ok'] ?? 0),
            (int) ($report['summary']['failed'] ?? 0),
            (int) ($report['summary']['schemaDrift'] ?? 0)
        );

        return redirect()
            ->to(site_url('mycrud'))
            ->with(
                ((int) ($report['summary']['failed'] ?? 0)) > 0 ? 'error' : 'message',
                $message
            );
    }

    public function diff(string $table): string
    {
        try {
            return view('mycrud/project_diff', [
                'title' => 'Diff ' . $table,
                'report' => (new GenerationDiffService())->compare($table, 'app'),
            ]);
        } catch (Throwable $e) {
            return view('mycrud/project_diff', [
                'title' => 'Diff ' . $table,
                'report' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function doctor(string $table): string
    {
        $report = new DiagnosticReport();
        $report->addMany((new PersistentConfigAnalyzer())->analyze($table));
        $report->addMany((new IndexAnalyzer())->analyze($table));

        return view('mycrud/project_doctor', [
            'title' => 'Doctor ' . $table,
            'table' => $table,
            'report' => $report,
        ]);
    }
}
