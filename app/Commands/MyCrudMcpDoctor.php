<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

final class MyCrudMcpDoctor extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:mcp-doctor';
    protected $description = 'Checks MCP configuration, manifest, and the official PHP SDK.';
    protected $usage       = 'mycrud:mcp-doctor [table]';

    protected $arguments = [
        'table' => 'Table opzionale da controllare.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));

        CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION . ' — MCP Doctor', 'cyan');
        CLI::write('Target protocol: 2026-07-28');
        CLI::newLine();

        $sdkServer = class_exists(\Mcp\Server::class);
        $sdkStdio = class_exists(\Mcp\Server\Transport\StdioTransport::class);

        $this->row('mcp/sdk Server', $sdkServer, $sdkServer ? 'available' : 'not installed');
        $this->row('STDIO transport', $sdkStdio, $sdkStdio ? 'available' : 'non available');

        if (!$sdkServer) {
            CLI::write('Installazione opzionale runtime: composer require mcp/sdk', 'yellow');
        }

        try {
            $repository = new CrudConfigRepository();

            if ($table !== '') {
                return $this->checkTable($repository, $table, $sdkServer && $sdkStdio);
            }

            $configured = $repository->tables();
            $enabled = [];
            foreach ($configured as $configuredTable) {
                $config = $repository->load($configuredTable);
                if (!empty($config['mcp']['enabled'])) {
                    $enabled[] = $configuredTable;
                }
            }

            CLI::newLine();
            CLI::write('Tables MCP abilitate: ' . count($enabled), 'cyan');
            foreach ($enabled as $enabledTable) {
                CLI::write('  - ' . $enabledTable);
            }

            return EXIT_SUCCESS;
        } catch (Throwable $e) {
            CLI::error($e->getMessage());

            return EXIT_ERROR;
        }
    }

    private function checkTable(CrudConfigRepository $repository, string $table, bool $sdkReady): int
    {
        $config = $repository->load($table);
        if ($config === null) {
            CLI::error('Persistent configuration not found: ' . $table);

            return EXIT_ERROR;
        }

        $enabled = !empty($config['mcp']['enabled']);
        $this->row('MCP ' . $table, $enabled, $enabled ? 'abilitato' : 'disabilitato');

        if ($enabled) {
            CLI::write('Security boundary: local_process (STDIO)', 'cyan');
            CLI::write('REST/Shield inherited: no', 'cyan');
            CLI::write('Remote transport: disabled', 'cyan');
        }

        if (!$enabled) {
            return EXIT_SUCCESS;
        }

        $manifest = APPPATH . 'Mcp/Manifests/' . $table . '.json';
        $manifestExists = is_file($manifest);
        $this->row(
            'Manifest pubblicato',
            $manifestExists,
            $manifestExists ? str_replace(ROOTPATH, '', $manifest) : 'non trovato'
        );

        $resource = $this->studly($table);
        $toolFile = APPPATH . 'Mcp/Tools/' . $resource . 'Tools.php';
        $toolExists = is_file($toolFile);
        $this->row(
            'Tool MCP pubblicati',
            $toolExists,
            $toolExists ? str_replace(ROOTPATH, '', $toolFile) : 'non trovati'
        );

        $relationToolsExpected = !empty($config['mcp']['capabilities']['relations']);
        if ($relationToolsExpected) {
            $relationToolFile = APPPATH . 'Mcp/Tools/' . $resource . 'RelationTools.php';
            $relationToolExists = is_file($relationToolFile);
            $this->row(
                'Tool relations MCP',
                $relationToolExists,
                $relationToolExists
                    ? str_replace(ROOTPATH, '', $relationToolFile)
                    : 'non trovati'
            );
        } else {
            $relationToolExists = true;
        }

        if ($toolExists) {
            CLI::write(
                'Start: php spark mycrud:mcp-serve ' . $table . ' --no-header',
                'cyan'
            );
        }

        if (!$sdkReady) {
            CLI::write(
                'Il manifest può essere generato senza SDK; il runtime MCP richiederà mcp/sdk.',
                'yellow'
            );
        }

        return ($manifestExists && $toolExists && $relationToolExists)
            ? EXIT_SUCCESS
            : EXIT_ERROR;
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

    private function row(string $name, bool $ok, string $message): void
    {
        CLI::write(($ok ? '✓ ' : '! ') . $name . ': ' . $message, $ok ? 'green' : 'yellow');
    }
}
