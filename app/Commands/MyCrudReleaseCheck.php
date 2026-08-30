<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;
use Throwable;

/**
 * Runs the release-candidate readiness matrix by composing existing myCrudCI4
 * Spark commands and focused PHPUnit contract tests.
 */
final class MyCrudReleaseCheck extends BaseCommand
{
    protected $group = 'myCrudCI4';
    protected $name = 'mycrud:release-check';
    protected $description = 'Runs the RC readiness matrix across one or more real tables.';
    protected $usage = 'mycrud:release-check <table> [table ...]';

    protected $arguments = [
        'table' => 'One or more real tables used by the RC readiness matrix.',
    ];

    public function run(array $params)
    {
        $tables = array_values(array_unique(array_filter(array_map(
            static fn ($value): string => trim((string) $value),
            $params
        ), static fn (string $value): bool => $value !== '')));

        if ($tables === []) {
            CLI::error('Specify at least one real table.');
            CLI::write('Example: php spark mycrud:release-check users orders products', 'yellow');

            return EXIT_ERROR;
        }

        CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION, 'cyan');
        CLI::write('Release candidate readiness check', 'yellow');
        CLI::write('Tables: ' . implode(', ', $tables), 'light_gray');
        CLI::newLine();

        /** @var list<array{scope:string,gate:string,status:string,detail:string}> $results */
        $results = [];

        foreach ($tables as $table) {
            $this->runGate($results, $table, 'CRUD / relations', [PHP_BINARY, ROOTPATH . 'spark', 'mycrud:test-all', $table]);
            $this->runGate($results, $table, 'Generated tests', [PHP_BINARY, ROOTPATH . 'spark', 'mycrud:test-generated', $table]);
            $this->runGate($results, $table, 'API / OpenAPI', [PHP_BINARY, ROOTPATH . 'spark', 'mycrud:check-api', $table]);
            $this->runGate($results, $table, 'Query layer', [PHP_BINARY, ROOTPATH . 'spark', 'mycrud:check-query-layer', $table]);
        }

        $this->runGate($results, 'project', 'Dashboard', [PHP_BINARY, ROOTPATH . 'spark', 'mycrud:test-dashboard']);

        $phpunit = $this->phpUnitExecutable();
        if ($phpunit === null) {
            $results[] = [
                'scope' => 'project',
                'gate' => 'Shield contracts',
                'status' => 'FAIL',
                'detail' => 'PHPUnit not found in vendor/bin/.',
            ];
            $results[] = [
                'scope' => 'project',
                'gate' => 'CLI documentation',
                'status' => 'FAIL',
                'detail' => 'PHPUnit not found in vendor/bin/.',
            ];
            $results[] = [
                'scope' => 'project',
                'gate' => 'Architecture / Builder guards',
                'status' => 'FAIL',
                'detail' => 'PHPUnit not found in vendor/bin/.',
            ];
        } else {
            $this->runGate($results, 'project', 'Shield contracts', [
                $phpunit,
                '--no-coverage',
                ROOTPATH . 'tests/MyCrud/ShieldCrudApiSeparationTest.php',
                ROOTPATH . 'tests/MyCrud/BuilderShieldVisibilityTest.php',
            ]);
            $this->runGate($results, 'project', 'CLI documentation', [
                $phpunit,
                '--no-coverage',
                ROOTPATH . 'tests/MyCrud/CliDocumentationCoverageTest.php',
            ]);
            $this->runGate($results, 'project', 'Architecture / Builder guards', [
                $phpunit,
                '--no-coverage',
                ROOTPATH . 'tests/MyCrud/DashboardBaselineGuardTest.php',
                ROOTPATH . 'tests/MyCrud/DashboardConfigBoundaryTest.php',
                ROOTPATH . 'tests/MyCrud/BuilderIntentFirstUxTest.php',
                ROOTPATH . 'tests/MyCrud/BuilderParentTablesStickyUxTest.php',
                ROOTPATH . 'tests/MyCrud/PublishManagedArtifactsTest.php',
                ROOTPATH . 'tests/MyCrud/GeneratedUiConfigurabilityTest.php',
            ]);
        }

        CLI::newLine();
        CLI::write('RC readiness summary', 'yellow');
        CLI::newLine();

        $failures = 0;
        foreach ($results as $result) {
            $passed = $result['status'] === 'PASS';
            if (!$passed) {
                ++$failures;
            }
            CLI::write(
                sprintf(
                    '%s %-10s | %-29s | %s',
                    $passed ? '✓' : '✗',
                    $result['scope'],
                    $result['gate'],
                    $result['status']
                ),
                $passed ? 'green' : 'red'
            );
            if (!$passed && $result['detail'] !== '') {
                CLI::write('  ' . $result['detail'], 'red');
            }
        }

        CLI::newLine();
        if ($failures === 0) {
            CLI::write('READY FOR RC1', 'green');
            return EXIT_SUCCESS;
        }

        CLI::error('NOT READY FOR RC1 — failed gates: ' . $failures);
        return EXIT_ERROR;
    }

    /**
     * @param list<array{scope:string,gate:string,status:string,detail:string}> $results
     * @param list<string> $command
     */
    private function runGate(array &$results, string $scope, string $gate, array $command): void
    {
        CLI::write(sprintf('[%s] %s', $scope, $gate), 'cyan');

        try {
            [$exitCode, $output] = $this->runProcess($command);
            $passed = $exitCode === 0;
            $results[] = [
                'scope' => $scope,
                'gate' => $gate,
                'status' => $passed ? 'PASS' : 'FAIL',
                'detail' => $passed ? '' : $this->failureSummary($output),
            ];

            CLI::write($passed ? '  ✓ PASS' : '  ✗ FAIL', $passed ? 'green' : 'red');
            if (!$passed && $output !== '') {
                CLI::write($this->indent($output), 'light_gray');
            }
        } catch (Throwable $e) {
            $results[] = [
                'scope' => $scope,
                'gate' => $gate,
                'status' => 'FAIL',
                'detail' => $e->getMessage(),
            ];
            CLI::write('  ✗ FAIL: ' . $e->getMessage(), 'red');
        }

        CLI::newLine();
    }

    /** @param list<string> $command @return array{0:int,1:string} */
    private function runProcess(array $command): array
    {
        $descriptorSpec = [
            0 => ['file', 'php://stdin', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open(
            $command,
            $descriptorSpec,
            $pipes,
            ROOTPATH,
            null,
            ['bypass_shell' => true]
        );

        if (!is_resource($process)) {
            throw new RuntimeException('Unable to start gate process.');
        }

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        return [$exitCode, trim((string) $stdout . ($stderr !== '' ? PHP_EOL . $stderr : ''))];
    }

    private function phpUnitExecutable(): ?string
    {
        $base = rtrim(ROOTPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR . 'vendor'
            . DIRECTORY_SEPARATOR . 'bin'
            . DIRECTORY_SEPARATOR;

        $candidates = PHP_OS_FAMILY === 'Windows'
            ? [$base . 'phpunit.bat', $base . 'phpunit']
            : [$base . 'phpunit'];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private function indent(string $output): string
    {
        return '    ' . str_replace(PHP_EOL, PHP_EOL . '    ', trim($output));
    }

    private function failureSummary(string $output): string
    {
        $lines = preg_split('/\R/', trim($output)) ?: [];

        // mycrud:test-all reports individual failed diagnostics with the ✗
        // symbol before printing the aggregate PASS/WARN/FAIL line. Surface
        // those names first so the RC summary remains actionable.
        $diagnosticFailures = [];
        foreach ($lines as $line) {
            $line = trim((string) $line);
            if (str_starts_with($line, '✗ ')) {
                $diagnosticFailures[] = substr($line, strlen('✗ '));
                if (count($diagnosticFailures) >= 3) {
                    break;
                }
            }
        }
        if ($diagnosticFailures !== []) {
            return implode(' | ', $diagnosticFailures);
        }

        foreach ($lines as $line) {
            $line = trim((string) $line);
            if (preg_match('/^(Error|Failure|ParseError|Fatal error|PHP Fatal error|[0-9]+\))[: ]/i', $line) === 1) {
                return $line;
            }
            if (str_starts_with($line, 'Verifica fallita:') || str_starts_with($line, 'Verifica API fallita:')) {
                return $line;
            }
        }

        return $this->lastMeaningfulLine($output);
    }

    private function lastMeaningfulLine(string $output): string
    {
        $lines = preg_split('/\R/', trim($output)) ?: [];
        for ($i = count($lines) - 1; $i >= 0; --$i) {
            $line = trim((string) $lines[$i]);
            if ($line !== '') {
                return $line;
            }
        }

        return 'Gate returned a non-zero exit code.';
    }
}
