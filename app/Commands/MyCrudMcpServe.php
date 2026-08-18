<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Mcp\Server;
use Mcp\Server\Transport\StdioTransport;
use RuntimeException;
use Throwable;

/**
 * Run il server MCP STDIO di una singola table.
 *
 * IMPORTANTE:
 * usare sempre `--no-header` per evitare che il banner Spark corrompa
 * il protocollo JSON-RPC su STDOUT.
 */
final class MyCrudMcpServe extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:mcp-serve';
    protected $description = 'Run il server MCP STDIO read-only di un CRUD pubblicato.';
    protected $usage       = 'mycrud:mcp-serve <table> --no-header';

    protected $arguments = [
        'table' => 'Table MCP da esporre.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specify the table.');

            return EXIT_ERROR;
        }

        try {
            if (!class_exists(Server::class) || !class_exists(StdioTransport::class)) {
                throw new RuntimeException(
                    'MCP runtime unavailable. Install: composer require mcp/sdk'
                );
            }

            $repository = new CrudConfigRepository();
            $config = $repository->load($table);
            if ($config === null) {
                throw new RuntimeException('Persistent configuration not found: ' . $table);
            }

            if (empty($config['mcp']['enabled'])) {
                throw new RuntimeException('MCP non è abilitato per: ' . $table);
            }

            $resource = $this->studly($table);
            $toolFile = APPPATH . 'Mcp/Tools/' . $resource . 'Tools.php';
            if (!is_file($toolFile)) {
                throw new RuntimeException(
                    'Tool MCP pubblicati non trovati. Eseguire generate + publish per ' . $table . '.'
                );
            }

            $serverName = trim((string) ($config['mcp']['serverName'] ?? 'myCrudCI4'));
            if ($serverName === '') {
                $serverName = 'myCrudCI4';
            }

            $server = Server::builder()
                ->setServerInfo($serverName . ' - ' . $table, MyCrudVersion::VERSION)
                ->setInstructions(
                    'Read-only myCrudCI4 tools for table ' . $table
                    . '. Use list tools for paginated discovery and get tools for record detail.'
                )
                ->setDiscovery(
                    basePath: APPPATH . 'Mcp/Tools',
                    scanDirs: ['.'],
                    excludeDirs: [],
                    namePatterns: [
                        $resource . 'Tools.php',
                        $resource . 'RelationTools.php',
                    ]
                )
                ->build();

            $server->run(new StdioTransport());

            return EXIT_SUCCESS;
        } catch (Throwable $e) {
            // Error path only. A healthy MCP STDIO session must have no
            // application output before protocol frames.
            CLI::error($e->getMessage());

            return EXIT_ERROR;
        }
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
}
