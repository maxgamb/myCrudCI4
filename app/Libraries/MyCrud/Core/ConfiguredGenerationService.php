<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use Throwable;

/** Batch-generates all CRUDs that have persistent configuration. */
final class ConfiguredGenerationService
{
    public function __construct(
        private readonly ?CrudConfigurationService $configuration = null,
        private readonly ?CrudGeneratorService $generator = null,
    ) {
    }

    /**
     * @param list<string>|null $tables null = tutte le configurazioni disponibili
     * @return array<string,mixed>
     */
    public function generateAll(?array $tables = null, bool $force = false): array
    {
        $configuration = $this->configuration ?? new CrudConfigurationService();
        $generator = $this->generator ?? new CrudGeneratorService();
        $tables ??= $configuration->configuredTables();

        $report = [
            'version' => (string) config('MyCrud')->version,
            'startedAt' => date(DATE_ATOM),
            'force' => $force,
            'tables' => [],
            'summary' => [
                'selected' => count($tables),
                'ok' => 0,
                'failed' => 0,
                'schemaDrift' => 0,
            ],
        ];

        foreach ($tables as $table) {
            try {
                $resolved = $configuration->resolve((string) $table, true);
                if (!$resolved['saved']) {
                    throw new \RuntimeException('Persistent configuration not found.');
                }

                $result = $generator->generate($resolved['config'], $force);
                $drift = !empty($resolved['schemaDrift']);

                if ($drift) {
                    $report['summary']['schemaDrift']++;
                }

                $report['summary']['ok']++;
                $report['tables'][(string) $table] = [
                    'status' => 'ok',
                    'architecture' => (string) ($result['architecture'] ?? ''),
                    'schemaDrift' => $drift,
                    'savedVersion' => $resolved['savedVersion'],
                ];
            } catch (Throwable $e) {
                $report['summary']['failed']++;
                $report['tables'][(string) $table] = [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ];
            }
        }

        $report['finishedAt'] = date(DATE_ATOM);

        return $report;
    }
}
