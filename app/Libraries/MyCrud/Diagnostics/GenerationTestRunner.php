<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use Config\MyCrud;
use Throwable;

final class GenerationTestRunner
{
    private const ARCHITECTURES = ['basic', 'standard', 'full'];

    /**
     * Esegue una generazione reale sulla tabella indicata.
     * I file vengono scritti nel percorso configurato.
     */
    public function run(string $table, bool $force = true): DiagnosticReport
    {
        $report = new DiagnosticReport();

        foreach (self::ARCHITECTURES as $architecture) {
            try {
                $config = (new ConfigBuilder())->buildFromTable($table);
                $config = $this->applyArchitecture($config, $architecture);

                $result = (new CrudGeneratorService())->generate($config, $force);

                $report->add(new DiagnosticResult(
                    'Generazione ' . $architecture,
                    DiagnosticResult::PASS,
                    'CRUD generato correttamente.',
                    ['result' => $result]
                ));
            } catch (Throwable $exception) {
                $report->add(new DiagnosticResult(
                    'Generazione ' . $architecture,
                    DiagnosticResult::FAIL,
                    $exception->getMessage(),
                    [
                        'exception' => $exception::class,
                        'file'      => $exception->getFile(),
                        'line'      => $exception->getLine(),
                    ]
                ));
            }
        }

        /** @var MyCrud $myCrud */
        $myCrud = config('MyCrud');
        $report->addMany(
            (new GeneratedFileDiagnostics())->inspect($myCrud->generatedPath)
        );

        return $report;
    }

    /** @param array<string, mixed> $config */
    private function applyArchitecture(array $config, string $architecture): array
    {
        $softAvailable = !empty($config['softDelete']['available']);
        $config['architecture'] = $architecture;

        $config['features'] = match ($architecture) {
            'basic' => [
                'entity'        => false,
                'service'       => false,
                'api'           => false,
                'datatable'     => true,
                'relations'     => true,
                'softDeletes'   => false,
                'timestamps'    => false,
                'exportButtons' => true,
            ],
            'full' => [
                'entity'        => true,
                'service'       => true,
                'api'           => true,
                'datatable'     => true,
                'relations'     => true,
                'softDeletes'   => $softAvailable,
                'timestamps'    => true,
                'exportButtons' => true,
            ],
            default => [
                'entity'        => true,
                'service'       => true,
                'api'           => false,
                'datatable'     => true,
                'relations'     => true,
                'softDeletes'   => false,
                'timestamps'    => true,
                'exportButtons' => true,
            ],
        };

        return $config;
    }
}
