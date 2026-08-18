<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;
use Throwable;

/**
 * Runs the published scaffold tests for a specific CRUD.
 *
 * I test attesi vivono in:
 *   ROOTPATH/tests/Generated/MyCrud/<TableStudly>/
 *
 * Il comando usa il PHPUnit installato nel progetto (`vendor/bin/phpunit`)
 * without going through a shell, so the table name is not interpolated
 * in una command string.
 */
final class MyCrudTestGenerated extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:test-generated';
    protected $description = 'Runs published scaffold tests for a single CRUD.';
    protected $usage       = 'mycrud:test-generated <table> [--list] [--stop-on-failure]';

    protected $arguments = [
        'table' => 'Table/CRUD name whose generated tests should be run.',
    ];

    protected $options = [
        '--list'            => 'Lists found test files without executing them.',
        '--stop-on-failure' => 'Passa --stop-on-failure a PHPUnit.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specify the table.');
            CLI::write('Example: php spark mycrud:test-generated film', 'yellow');

            return EXIT_ERROR;
        }

        try {
            $resource = $this->studly($table);
            $testDirectory = rtrim(ROOTPATH, DIRECTORY_SEPARATOR)
                . DIRECTORY_SEPARATOR
                . 'tests'
                . DIRECTORY_SEPARATOR
                . 'Generated'
                . DIRECTORY_SEPARATOR
                . 'MyCrud'
                . DIRECTORY_SEPARATOR
                . $resource;

            CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION, 'cyan');
            CLI::write('Generated tests: ' . $table);
            CLI::write('Directory: ' . $this->displayPath($testDirectory));
            CLI::newLine();

            if (!is_dir($testDirectory)) {
                CLI::error('Test scaffold not found for ' . $table . '.');
                CLI::write(
                    'Run first: php spark mycrud:generate ' . $table
                    . ' --force && php spark mycrud:publish ' . $table,
                    'yellow'
                );

                return EXIT_ERROR;
            }

            $testFiles = $this->testFiles($testDirectory);
            if ($testFiles === []) {
                CLI::error('La directory esiste ma non contiene file *Test.php.');

                return EXIT_ERROR;
            }

            CLI::write('Test trovati: ' . count($testFiles), 'cyan');

            foreach ($testFiles as $file) {
                CLI::write('  - ' . basename($file), 'light_gray');
            }

            if ((bool) CLI::getOption('list')) {
                CLI::newLine();
                CLI::write('List only: no tests executed.', 'cyan');

                return EXIT_SUCCESS;
            }

            $phpunit = $this->phpUnitExecutable();
            if ($phpunit === null) {
                CLI::error('PHPUnit not found in vendor/bin/.');
                CLI::write(
                    'Installa le dipendenze di sviluppo del progetto prima di eseguire i test.',
                    'yellow'
                );

                return EXIT_ERROR;
            }

            // Questi scaffold verificano contratti/struttura, non producono
            // report di code coverage. --no-coverage evita che un phpunit.xml
            // con coverage configurata richieda Xdebug/PCOV e trasformi un
            // run con tutti i test PASS in exit code 1.
            $command = [$phpunit, '--no-coverage', $testDirectory];

            if ((bool) CLI::getOption('stop-on-failure')) {
                $command[] = '--stop-on-failure';
            }

            CLI::newLine();
            CLI::write('PHPUnit: ' . $this->displayPath($phpunit), 'cyan');
            CLI::write('Esecuzione...', 'yellow');
            CLI::newLine();

            $exitCode = $this->runProcess($command);

            CLI::newLine();
            if ($exitCode === 0) {
                CLI::write('✓ Generated tests passed.', 'green');

                return EXIT_SUCCESS;
            }

            CLI::error('Generated tests failed. PHPUnit exit code: ' . $exitCode);

            return EXIT_ERROR;
        } catch (Throwable $e) {
            CLI::error($e->getMessage());

            return EXIT_ERROR;
        }
    }

    /** @return list<string> */
    private function testFiles(string $directory): array
    {
        $files = glob(
            rtrim($directory, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . '*Test.php'
        ) ?: [];

        $files = array_values(array_filter(
            $files,
            static fn (string $path): bool => is_file($path)
        ));

        sort($files, SORT_STRING);

        return $files;
    }

    private function phpUnitExecutable(): ?string
    {
        $base = rtrim(ROOTPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'vendor'
            . DIRECTORY_SEPARATOR
            . 'bin'
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

    /**
     * Runs PHPUnit without a shell and forwards stdout/stderr to the terminal.
     *
     * @param list<string> $command
     */
    private function runProcess(array $command): int
    {
        $descriptorSpec = [
            0 => ['file', 'php://stdin', 'r'],
            1 => ['file', 'php://stdout', 'w'],
            2 => ['file', 'php://stderr', 'w'],
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
            throw new RuntimeException('Unable to start PHPUnit.');
        }

        return proc_close($process);
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

    private function displayPath(string $path): string
    {
        $normalized = str_replace('\\', '/', $path);
        $root = rtrim(str_replace('\\', '/', ROOTPATH), '/') . '/';

        return str_starts_with($normalized, $root)
            ? substr($normalized, strlen($root))
            : $normalized;
    }
}
