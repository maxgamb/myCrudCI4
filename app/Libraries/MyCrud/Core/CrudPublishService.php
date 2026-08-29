<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Diagnostics\GenerationDiffService;
use RuntimeException;

/**
 * Publishes files for a specific CRUD from staging into the operational app/ space
 * nello staging app/Generated/.
 *
 * Generated remains intact: publish performs atomic copies, not rename/move operations.
 * The expected file list comes from the same configuration/schema used by
 * generatore, così `publish <table>` non trascina CRUD di altre tabelle.
 */
final class CrudPublishService
{
    /**
     * @return array{
     *   table:string,
     *   dryRun:bool,
     *   force:bool,
     *   files:array<string,array<string,mixed>>,
     *   summary:array<string,int>
     * }
     */
    public function publish(string $table, bool $force = false, bool $dryRun = false): array
    {
        $table = trim($table);
        if ($table === '') {
            throw new RuntimeException('Missing table name.');
        }

        // Il diff "generated" produce l'elenco esatto dei file che la
        // the current CRUD configuration must have in staging.
        $expected = (new GenerationDiffService())->compare($table, 'generated');

        $stagingRoot = rtrim(APPPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'Generated'
            . DIRECTORY_SEPARATOR;

        $rows = [];
        $summary = [
            'created' => 0,
            'overwritten' => 0,
            'unchanged' => 0,
            'skipped' => 0,
            'missing' => 0,
            'would_create' => 0,
            'would_overwrite' => 0,
            'removed' => 0,
            'would_remove' => 0,
        ];

        foreach (array_keys((array) ($expected['files'] ?? [])) as $relative) {
            $relative = $this->normalizeRelativePath((string) $relative);
            $source = $stagingRoot . str_replace('/', DIRECTORY_SEPARATOR, $relative);
            $target = $this->operationalPath($relative);

            if (!is_file($source)) {
                $rows[$relative] = [
                    'status' => 'missing',
                    'source' => $source,
                    'target' => $target,
                    'reason' => 'staging_file_missing',
                ];
                $summary['missing']++;
                continue;
            }

            $targetExists = is_file($target);
            $autoOverwriteManagedArtifact = $this->isManagedGeneratedArtifact($relative);
            $same = $targetExists
                && hash_file('sha256', $source) === hash_file('sha256', $target);

            if ($same) {
                $rows[$relative] = [
                    'status' => 'unchanged',
                    'source' => $source,
                    'target' => $target,
                    'reason' => '',
                ];
                $summary['unchanged']++;
                continue;
            }

            // Generated PHPUnit contracts and MCP runtime artifacts must stay aligned
            // with staging. They are generator-owned contracts, so SAFE publish refreshes
            // them even without --force. Other application files keep SAFE behavior.
            if ($targetExists && !$force && !$autoOverwriteManagedArtifact) {
                $rows[$relative] = [
                    'status' => 'skipped',
                    'source' => $source,
                    'target' => $target,
                    'reason' => 'target_exists_use_force',
                ];
                $summary['skipped']++;
                continue;
            }

            if ($dryRun) {
                $status = $targetExists ? 'would_overwrite' : 'would_create';
                $rows[$relative] = [
                    'status' => $status,
                    'source' => $source,
                    'target' => $target,
                    'reason' => '',
                ];
                $summary[$status]++;
                continue;
            }

            $this->atomicCopy($source, $target);
            $status = $targetExists ? 'overwritten' : 'created';

            $rows[$relative] = [
                'status' => $status,
                'source' => $source,
                'target' => $target,
                'reason' => '',
            ];
            $summary[$status]++;
        }

        $expectedRelativePaths = array_keys((array) ($expected['files'] ?? []));

        $this->synchronizeStaleMcpArtifacts(
            $table,
            $expectedRelativePaths,
            $dryRun,
            $rows,
            $summary
        );

        $this->synchronizeStaleViewPartials(
            $table,
            $expectedRelativePaths,
            $force,
            $dryRun,
            $rows,
            $summary
        );

        ksort($rows, SORT_STRING);

        return [
            'table' => $table,
            'dryRun' => $dryRun,
            'force' => $force,
            'files' => $rows,
            'summary' => $summary,
        ];
    }

    private function isManagedGeneratedArtifact(string $relative): bool
    {
        $relative = str_replace('\\', '/', $relative);

        return str_starts_with($relative, 'Tests/')
            || str_starts_with($relative, 'Mcp/');
    }

    /**
     * Removes operational MCP artifacts owned by this CRUD when the current
     * generation no longer expects them. This prevents disabled capabilities
     * (for example read/relations) from remaining discoverable through stale
     * published tool classes or manifests.
     *
     * @param list<string> $expectedRelativePaths
     * @param array<string,array<string,mixed>> $rows
     * @param array<string,int> $summary
     */
    private function synchronizeStaleMcpArtifacts(
        string $table,
        array $expectedRelativePaths,
        bool $dryRun,
        array &$rows,
        array &$summary
    ): void {
        $expected = array_fill_keys(array_map(
            fn (string $path): string => $this->normalizeRelativePath($path),
            $expectedRelativePaths
        ), true);

        foreach ($this->managedMcpArtifactsForTable($table) as $relative) {
            if (isset($expected[$relative])) {
                continue;
            }

            $target = $this->operationalPath($relative);
            if (!is_file($target)) {
                continue;
            }

            if ($dryRun) {
                $rows[$relative] = [
                    'status' => 'would_remove',
                    'source' => '',
                    'target' => $target,
                    'reason' => 'stale_managed_mcp_artifact',
                ];
                $summary['would_remove']++;
                continue;
            }

            if (!unlink($target)) {
                throw new RuntimeException('Unable to remove stale MCP artifact: ' . $target);
            }

            $rows[$relative] = [
                'status' => 'removed',
                'source' => '',
                'target' => $target,
                'reason' => 'stale_managed_mcp_artifact',
            ];
            $summary['removed']++;
        }
    }

    /**
     * Removes stale dynamic View partials owned by this CRUD.
     *
     * Only generator-owned filename families are managed; unknown/custom
     * View files are deliberately preserved.
     *
     * @param list<string> $expectedRelativePaths
     * @param array<string,array<string,mixed>> $rows
     * @param array<string,int> $summary
     */
    private function synchronizeStaleViewPartials(
        string $table,
        array $expectedRelativePaths,
        bool $force,
        bool $dryRun,
        array &$rows,
        array &$summary
    ): void {
        $expected = array_fill_keys(array_map(
            fn (string $path): string => $this->normalizeRelativePath($path),
            $expectedRelativePaths
        ), true);

        $directory = rtrim(APPPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'Views'
            . DIRECTORY_SEPARATOR
            . $table;

        if (!is_dir($directory)) {
            return;
        }

        $patterns = [
            '_children_*.php',
            '_many_many__*.php',
            '_many_form_*.php',
            '_related_create_*.php',
        ];

        foreach ($patterns as $pattern) {
            $matches = glob($directory . DIRECTORY_SEPARATOR . $pattern);
            if ($matches === false) {
                continue;
            }

            foreach ($matches as $target) {
                if (!is_file($target)) {
                    continue;
                }

                $relative = $this->normalizeRelativePath(
                    'Views/' . $table . '/' . basename($target)
                );

                if (isset($expected[$relative])) {
                    continue;
                }

                // Operational View partials may have been customized after publish.
                // SAFE publish preserves them; explicit --force authorizes removal.
                if (!$force) {
                    continue;
                }

                if ($dryRun) {
                    $rows[$relative] = [
                        'status' => 'would_remove',
                        'source' => '',
                        'target' => $target,
                        'reason' => 'stale_generated_view_partial',
                    ];
                    $summary['would_remove']++;
                    continue;
                }

                if (!unlink($target)) {
                    throw new RuntimeException(
                        'Unable to remove stale generated View partial: ' . $target
                    );
                }

                $rows[$relative] = [
                    'status' => 'removed',
                    'source' => '',
                    'target' => $target,
                    'reason' => 'stale_generated_view_partial',
                ];
                $summary['removed']++;
            }
        }
    }

    /** @return list<string> */
    private function managedMcpArtifactsForTable(string $table): array
    {
        $resource = $this->studly($table);

        return [
            'Mcp/Manifests/' . $table . '.json',
            'Mcp/Tools/' . $resource . 'Tools.php',
            'Mcp/Tools/' . $resource . 'RelationTools.php',
            'Mcp/Resources/' . $resource . 'McpResource.php',

            // MCP PHPUnit contracts are generator-owned artifacts too.
            // When MCP is disabled for a CRUD, TestScaffoldGenerator stops
            // generating them, so publish must remove any previously
            // published copies from ROOTPATH/tests/.
            'Tests/Generated/MyCrud/' . $resource . '/' . $resource . 'McpFoundationContractTest.php',
            'Tests/Generated/MyCrud/' . $resource . '/' . $resource . 'McpResourceSecurityContractTest.php',
        ];
    }

    private function studly(string $value): string
    {
        $parts = preg_split('/[^a-zA-Z0-9]+/', $value) ?: [$value];
        $result = implode('', array_map(
            static fn (string $part): string => ucfirst(strtolower($part)),
            $parts
        ));

        return $result !== '' ? $result : 'Crud';
    }

    private function operationalPath(string $relative): string
    {
        $relative = str_replace('\\', '/', $relative);

        // I test non sono codice applicativo: dopo lo staging Generated/Tests/
        // vengono pubblicati nel tree PHPUnit standard ROOTPATH/tests/.
        if (str_starts_with($relative, 'Tests/')) {
            $testRelative = substr($relative, strlen('Tests/'));

            return rtrim(ROOTPATH, DIRECTORY_SEPARATOR)
                . DIRECTORY_SEPARATOR
                . 'tests'
                . DIRECTORY_SEPARATOR
                . str_replace('/', DIRECTORY_SEPARATOR, $testRelative);
        }

        return APPPATH . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }

    private function normalizeRelativePath(string $relative): string
    {
        $relative = str_replace('\\', '/', trim($relative));
        $relative = ltrim($relative, '/');

        if (
            $relative === ''
            || str_contains($relative, "\0")
            || preg_match('#(^|/)\.\.?(/|$)#', $relative) === 1
        ) {
            throw new RuntimeException('Percorso publish non valido: ' . $relative);
        }

        return $relative;
    }

    private function atomicCopy(string $source, string $target): void
    {
        $directory = dirname($target);
        if (
            !is_dir($directory)
            && !mkdir($directory, 0755, true)
            && !is_dir($directory)
        ) {
            throw new RuntimeException('Impossibile creare la directory: ' . $directory);
        }

        $tmp = $target . '.mycrud-publish-' . bin2hex(random_bytes(4));

        if (!copy($source, $tmp)) {
            @unlink($tmp);
            throw new RuntimeException('Impossibile copiare il file: ' . $source);
        }

        if (!rename($tmp, $target)) {
            @unlink($tmp);
            throw new RuntimeException('Impossibile pubblicare il file: ' . $target);
        }
    }
}