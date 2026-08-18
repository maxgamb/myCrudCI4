<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Diagnostics;

use App\DTO\Dashboard\DashboardData;
use App\DTO\Dashboard\DashboardWidget;
use App\DTO\Dashboard\Kpi;
use App\DTO\Dashboard\RecentRecord;
use App\DTO\Dashboard\SeriesPoint;
use App\Services\DashboardService;
use Throwable;

/**
 * Verifies the generated Dashboard contract at staging and published runtime boundaries.
 */
final class DashboardRegressionRunner
{
    /** @var list<string> */
    private const FILES = [
        'DTO/Dashboard/Kpi.php',
        'DTO/Dashboard/SeriesPoint.php',
        'DTO/Dashboard/RecentRecord.php',
        'DTO/Dashboard/DashboardWidget.php',
        'DTO/Dashboard/DashboardData.php',
        'Libraries/Dashboard/DashboardQuery.php',
        'Services/DashboardService.php',
        'Controllers/DashboardController.php',
        'Views/dashboard/index.php',
        'Routes/dashboard.php',
    ];

    public function run(): DiagnosticReport
    {
        $report = new DiagnosticReport();
        $staging = APPPATH . 'Generated' . DIRECTORY_SEPARATOR;

        $missing = [];
        foreach (self::FILES as $relative) {
            $path = $staging . str_replace('/', DIRECTORY_SEPARATOR, $relative);
            if (!is_file($path)) {
                $missing[] = $relative;
            }
        }

        if ($missing !== []) {
            $report->add(new DiagnosticResult(
                'Dashboard staging files',
                DiagnosticResult::FAIL,
                'Generated Dashboard is incomplete: ' . implode(', ', $missing)
            ));

            return $report;
        }

        $report->add(new DiagnosticResult(
            'Dashboard staging files',
            DiagnosticResult::PASS,
            count(self::FILES) . ' generated files found.'
        ));

        $service = $this->read($staging . 'Services' . DIRECTORY_SEPARATOR . 'DashboardService.php');
        $controller = $this->read($staging . 'Controllers' . DIRECTORY_SEPARATOR . 'DashboardController.php');
        $view = $this->read($staging . 'Views' . DIRECTORY_SEPARATOR . 'dashboard' . DIRECTORY_SEPARATOR . 'index.php');

        $this->check(
            $report,
            'Dashboard service config boundary',
            !str_contains($service, '$widget->get(') && !str_contains($service, '$widget->type'),
            'DashboardService reads embedded widget configuration as arrays.'
        );

        $this->check(
            $report,
            'Dashboard DTO return contract',
            str_contains($service, '): DashboardData') && str_contains($service, 'new DashboardWidget('),
            'DashboardService returns DashboardData and composes DashboardWidget DTOs.'
        );

        $this->check(
            $report,
            'Dashboard controller object boundary',
            str_contains($controller, "'title' => \$dashboard->title")
                && !str_contains($controller, '$dashboard[')
                && !str_contains($controller, '->toArray()'),
            'DashboardController passes DashboardData unchanged to the View.'
        );

        $this->check(
            $report,
            'Dashboard view object boundary',
            str_contains($view, '$dashboard->widgets')
                && str_contains($view, '$widget->type')
                && !str_contains($view, "\$widget['type']"),
            'Dashboard View consumes DashboardData/DashboardWidget as objects.'
        );

        $recentDtosStayTyped = str_contains($service, 'RecentRecord::collection(')
            && str_contains($service, "'records' => \$records")
            && !str_contains($service, 'static fn (RecentRecord $record): array => $record->toArray()')
            && !str_contains($service, 'array_map(static fn (RecentRecord')
            && !str_contains($service, "'records' => array_map(");

        $this->check(
            $report,
            'Dashboard recent-record DTO boundary',
            $recentDtosStayTyped,
            'Recent records remain RecentRecord DTOs through the View boundary.'
        );


        $hasRecentConfig = str_contains($service, "'type' => 'recent'");
        $hasConcreteRecentModel = preg_match('/\$model\s*=\s*new\s+[A-Za-z_][A-Za-z0-9_]*Model\s*\(\s*\)\s*;/', $service) === 1;
        $this->check(
            $report,
            'Dashboard static Model wiring',
            !$hasRecentConfig || (
                $hasConcreteRecentModel
                && !str_contains($service, '$modelClass')
                && !str_contains($service, 'new $modelClass')
                && !str_contains($service, 'class_exists(')
            ),
            'Recent widgets use concrete generated Models wired at generation-time.'
        );

        $publishedMissing = [];
        foreach (self::FILES as $relative) {
            $path = APPPATH . str_replace('/', DIRECTORY_SEPARATOR, $relative);
            if (!is_file($path)) {
                $publishedMissing[] = $relative;
            }
        }

        if ($publishedMissing !== []) {
            $report->add(new DiagnosticResult(
                'Dashboard runtime smoke test',
                DiagnosticResult::SKIP,
                'Dashboard is generated but not fully published. Publish the Dashboard from the Dashboard Builder before the runtime smoke test.'
            ));

            return $report;
        }

        try {
            $dashboard = (new DashboardService())->build();

            if (!$dashboard instanceof DashboardData) {
                throw new \RuntimeException('DashboardService::build() did not return DashboardData.');
            }

            foreach ($dashboard->widgets as $index => $widget) {
                if (!$widget instanceof DashboardWidget) {
                    throw new \RuntimeException('Widget #' . $index . ' is not DashboardWidget.');
                }

                if ($widget->type === 'kpi') {
                    $data = $widget->get('data');
                    if (!$data instanceof Kpi) {
                        throw new \RuntimeException('KPI widget #' . $index . ' does not contain Kpi DTO.');
                    }
                }

                if ($widget->type === 'chart') {
                    foreach ((array) $widget->get('points', []) as $pointIndex => $point) {
                        if (!$point instanceof SeriesPoint) {
                            throw new \RuntimeException('Chart widget #' . $index . ' point #' . $pointIndex . ' is not SeriesPoint.');
                        }
                    }
                }

                if ($widget->type === 'recent') {
                    foreach ((array) $widget->get('records', []) as $recordIndex => $record) {
                        if (!$record instanceof RecentRecord) {
                            throw new \RuntimeException('Recent widget #' . $index . ' record #' . $recordIndex . ' is not RecentRecord.');
                        }
                    }
                }
            }

            $report->add(new DiagnosticResult(
                'Dashboard runtime smoke test',
                DiagnosticResult::PASS,
                'DashboardService::build() returned DashboardData with ' . count($dashboard->widgets) . ' typed widgets.'
            ));
        } catch (Throwable $e) {
            $report->add(new DiagnosticResult(
                'Dashboard runtime smoke test',
                DiagnosticResult::FAIL,
                get_class($e) . ': ' . $e->getMessage()
            ));
        }

        return $report;
    }

    private function read(string $path): string
    {
        $content = file_get_contents($path);
        return is_string($content) ? $content : '';
    }

    private function check(
        DiagnosticReport $report,
        string $name,
        bool $condition,
        string $successMessage
    ): void {
        $report->add(new DiagnosticResult(
            $name,
            $condition ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $condition ? $successMessage : 'Generated Dashboard contract is inconsistent.'
        ));
    }
}
