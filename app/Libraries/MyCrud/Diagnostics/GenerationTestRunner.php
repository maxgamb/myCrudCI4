<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use Config\MyCrud;
use Throwable;

final class GenerationTestRunner
{
    /** Esegue una generazione reale usando l’architettura predefinita. */
    public function run(string $table, bool $force = true): DiagnosticReport
    {
        $report = new DiagnosticReport();

        try {
            $config = (new ConfigBuilder())->buildFromTable($table);
            $result = (new CrudGeneratorService())->generate($config, $force);

            $report->add(new DiagnosticResult(
                'Generazione ' . ucfirst((string) ($config['architecture'] ?? 'basic')),
                DiagnosticResult::PASS,
                'CRUD generato correttamente.',
                ['result' => $result]
            ));
        } catch (Throwable $exception) {
            $report->add(new DiagnosticResult(
                'Generazione CRUD',
                DiagnosticResult::FAIL,
                $exception->getMessage(),
                [
                    'exception' => $exception::class,
                    'file'      => $exception->getFile(),
                    'line'      => $exception->getLine(),
                ]
            ));
        }

        /** @var MyCrud $myCrud */
        $myCrud = config('MyCrud');
        $report->addMany(
            (new GeneratedFileDiagnostics())->inspect($myCrud->generatedStagingPath())
        );

        return $report;
    }
}
