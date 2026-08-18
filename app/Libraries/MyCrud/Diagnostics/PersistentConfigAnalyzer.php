<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use Throwable;

/** Diagnostics for a table's persistent configuration. */
final class PersistentConfigAnalyzer
{
    /** @return list<DiagnosticResult> */
    public function analyze(string $table): array
    {
        try {
            $resolved = (new CrudConfigurationService())->resolve($table, true);

            if (!$resolved['saved']) {
                return [new DiagnosticResult(
                    'Persistent configuration',
                    DiagnosticResult::WARN,
                    'Non presente. Verrà creata alla prima generazione 2.8.'
                )];
            }

            $results = [new DiagnosticResult(
                'Persistent configuration',
                DiagnosticResult::PASS,
                'Presente' . ($resolved['savedVersion'] ? ' (generatore ' . $resolved['savedVersion'] . ')' : '') . '.',
                ['path' => $resolved['configPath']]
            )];

            $results[] = new DiagnosticResult(
                'Schema drift',
                !empty($resolved['schemaDrift']) ? DiagnosticResult::WARN : DiagnosticResult::PASS,
                !empty($resolved['schemaDrift'])
                    ? 'Lo DB schema è cambiato rispetto allo snapshot salvato.'
                    : 'Schema coerente con lo snapshot persistente.'
            );

            return $results;
        } catch (Throwable $e) {
            return [new DiagnosticResult(
                'Persistent configuration',
                DiagnosticResult::FAIL,
                $e->getMessage()
            )];
        }
    }
}
