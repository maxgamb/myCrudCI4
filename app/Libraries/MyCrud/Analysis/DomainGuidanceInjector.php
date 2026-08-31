<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Analysis;

use RuntimeException;

/**
 * Enforces schema-aware Domain development comments on generated PHP layers.
 *
 * Generation fails if a created/overwritten generated layer cannot receive
 * real schema-aware guidance. No generic fallback is emitted.
 */
final class DomainGuidanceInjector
{
    public const MARKER = 'MYCRUD DOMAIN DEVELOPMENT EXAMPLE';

    public function __construct(private readonly ?DomainGuidanceBuilder $builder = null)
    {
    }

    /**
     * @param array<string,mixed> $config
     * @param array<string,mixed> $files
     * @return array{checked:int,injected:int,alreadyPresent:int,skipped:int}
     */
    public function inject(array $config, array $files): array
    {
        $table = trim((string) ($config['table'] ?? ''));
        if ($table === '') {
            throw new RuntimeException('Domain guidance requires a configured table.');
        }

        $guidance = ($this->builder ?? new DomainGuidanceBuilder())->forTable($table);
        if ($guidance === []) {
            throw new RuntimeException(
                'Schema-aware Domain guidance unavailable for generated resource: ' . $table
            );
        }

        $stats = [
            'checked' => 0,
            'injected' => 0,
            'alreadyPresent' => 0,
            'skipped' => 0,
        ];

        foreach ([
            'entity' => 'entity',
            'model' => 'model',
            'service' => 'service',
            'controller' => 'controller',
        ] as $fileKey => $layer) {
            $entry = $files[$fileKey] ?? null;
            if ($entry === null) {
                continue;
            }

            $this->injectEntry($table, $layer, $entry, $guidance, $stats);
        }

        $api = $files['api'] ?? null;
        if (is_array($api) && isset($api['controller'])) {
            $this->injectEntry(
                $table,
                'apiController',
                $api['controller'],
                $guidance,
                $stats
            );
        }

        return $stats;
    }

    /**
     * @param mixed $entry
     * @param array<string,string> $guidance
     * @param array{checked:int,injected:int,alreadyPresent:int,skipped:int} $stats
     */
    private function injectEntry(
        string $table,
        string $layer,
        mixed $entry,
        array $guidance,
        array &$stats
    ): void {
        if (!is_array($entry)) {
            throw new RuntimeException(
                'Invalid generated file result for Domain guidance: ' . $table . ' / ' . $layer
            );
        }

        $status = strtolower(trim((string) ($entry['status'] ?? '')));
        if ($status === 'skipped') {
            $stats['skipped']++;
            return;
        }

        $path = trim((string) ($entry['path'] ?? ''));
        if ($path === '' || !is_file($path)) {
            throw new RuntimeException(
                'Generated ' . $layer . ' file unavailable for Domain guidance: ' . ($path ?: '[missing path]')
            );
        }

        $stats['checked']++;

        $source = file_get_contents($path);
        if ($source === false) {
            throw new RuntimeException('Unable to read generated PHP file: ' . $path);
        }

        if (str_contains($source, self::MARKER)) {
            $stats['alreadyPresent']++;
            return;
        }

        $comment = trim((string) ($guidance[$layer] ?? ''));
        if ($comment === '') {
            throw new RuntimeException(
                'Schema-aware Domain guidance missing for ' . $table . ' / ' . $layer
            );
        }

        $this->injectIntoClass($path, $comment);

        $verified = file_get_contents($path);
        if ($verified === false || !str_contains($verified, self::MARKER)) {
            throw new RuntimeException(
                'Domain guidance verification failed after writing: ' . $path
            );
        }

        if (!str_contains($verified, 'Resource: ' . $table)) {
            throw new RuntimeException(
                'Domain guidance is not resource-specific after writing: ' . $path
            );
        }

        $stats['injected']++;
    }

    private function injectIntoClass(string $path, string $comment): void
    {
        $source = file_get_contents($path);
        if ($source === false) {
            throw new RuntimeException('Unable to read generated PHP file: ' . $path);
        }

        if (str_contains($source, self::MARKER)) {
            return;
        }

        $indented = preg_replace('/^/m', '    ', rtrim($comment)) ?? rtrim($comment);

        $updated = preg_replace_callback(
            '/(?m)^(?<decl>\s*(?:final\s+)?class\s+[A-Za-z_][A-Za-z0-9_]*[^{]*\{\R)/',
            static fn(array $m): string => $m['decl'] . $indented . "\n\n",
            $source,
            1,
            $count
        );

        if ($updated === null || $count !== 1) {
            throw new RuntimeException(
                'Unable to locate generated class body for Domain guidance: ' . $path
            );
        }

        if (file_put_contents($path, $updated, LOCK_EX) === false) {
            throw new RuntimeException('Unable to update generated PHP file: ' . $path);
        }
    }
}
