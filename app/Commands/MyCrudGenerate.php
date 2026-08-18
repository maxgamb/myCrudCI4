<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/**
 * Generates a single CRUD from the CLI.
 *
 * By default, uses the current DB schema plus the persistent configuration in
 * app/MyCrudConfig/<table>.php, which is the same configuration used by the Builder.
 */
final class MyCrudGenerate extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:generate';
    protected $description = 'Generates a CRUD from the DB schema and the Builder persistent configuration.';
    protected $usage       = 'mycrud:generate <table> [--architecture basic|standard|full] [--from-schema] [--save-config] [--force]';

    protected $arguments = [
        'table' => 'Table name.',
    ];

    protected $options = [
        '--architecture' => 'Override temporaneo: basic, standard oppure full.',
        '--from-schema'   => 'Ignores persistent configuration and uses schema-derived defaults.',
        '--save-config'   => 'Saves/updates the persistent configuration actually used.',
        '--force'         => 'Overwrites existing files only inside app/Generated/.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specify the table name.');
            CLI::write('Example: php spark mycrud:generate film', 'yellow');
            return;
        }

        try {
            CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION, 'cyan');
            CLI::write('CLI generation: ' . $table);
            CLI::newLine();

            $configuration = new CrudConfigurationService();
            $preferSaved = !CLI::getOption('from-schema');
            $resolved = $configuration->resolve($table, $preferSaved);
            $config = $resolved['config'];

            $architectureOption = CLI::getOption('architecture');
            if ($architectureOption !== null && $architectureOption !== false && $architectureOption !== '') {
                $architecture = strtolower(trim((string) $architectureOption));
                if (!in_array($architecture, ['basic', 'standard', 'full'], true)) {
                    CLI::error('Architettura non valida. Usa basic, standard oppure full.');
                    return;
                }

                $config = $this->withArchitecture($config, $architecture);
            }

            $source = $preferSaved && $resolved['saved']
                ? 'config persistente + DB schema corrente'
                : 'DB schema corrente';

            CLI::write('Table:         ' . $table);
            CLI::write('Architecture:  ' . (string) ($config['architecture'] ?? 'basic'));
            CLI::write('Configuration: ' . $source);

            if ($resolved['saved'] && !empty($resolved['configPath'])) {
                CLI::write('Config file:   ' . $this->displayPath((string) $resolved['configPath']));
            }

            if (!empty($resolved['savedVersion'])) {
                CLI::write('Config created: ' . (string) $resolved['savedVersion']);
            }

            if (!empty($resolved['schemaDrift'])) {
                CLI::newLine();
                CLI::write('! SCHEMA DRIFT rilevato.', 'yellow');
                CLI::write('  Verrà usato lo DB schema corrente applicando sopra le scelte persistenti.', 'yellow');
            }

            // The first generation automatically creates the configuration.
            // An existing configuration is saved again only when explicitly requested.
            if (!$resolved['saved'] || CLI::getOption('save-config')) {
                $path = $configuration->persist($config);
                CLI::write('Config salvata: ' . $this->displayPath($path), 'cyan');
            }

            CLI::newLine();
            $force = (bool) CLI::getOption('force');
            CLI::write(
                $force
                    ? 'Mode: FORCE (updates app/Generated/)'
                    : 'Mode: SAFE (i file già presenti vengono lasciati invariati)',
                $force ? 'yellow' : 'green'
            );
            CLI::newLine();

            $result = (new CrudGeneratorService())->generate($config, $force);
            $files = $this->collectFileResults((array) ($result['files'] ?? []));

            $summary = [
                'created' => 0,
                'overwritten' => 0,
                'skipped' => 0,
                'other' => 0,
            ];

            foreach ($files as $file) {
                $status = strtolower((string) ($file['status'] ?? 'other'));
                $summary[$status] = ($summary[$status] ?? 0) + 1;

                $label = match ($status) {
                    'created'     => 'CREATED',
                    'overwritten' => 'OVERWRITTEN',
                    'skipped'     => 'SKIPPED',
                    default       => strtoupper($status),
                };

                $color = match ($status) {
                    'created'     => 'green',
                    'overwritten' => 'yellow',
                    'skipped'     => 'light_gray',
                    default       => 'white',
                };

                $path = trim((string) ($file['path'] ?? ''));
                $reason = trim((string) ($file['reason'] ?? ''));
                $suffix = $reason !== '' ? ' [' . $reason . ']' : '';

                CLI::write(
                    str_pad($label, 12) . ' ' . ($path !== '' ? $this->displayPath($path) : '(no file)') . $suffix,
                    $color
                );
            }

            CLI::newLine();
            CLI::write(
                'CREATED ' . ($summary['created'] ?? 0)
                . ' | OVERWRITTEN ' . ($summary['overwritten'] ?? 0)
                . ' | SKIPPED ' . ($summary['skipped'] ?? 0),
                'cyan'
            );

            CLI::write(
                '✓ CRUD ' . $result['table'] . ' [' . $result['architecture'] . '] generated.',
                'green'
            );
            CLI::write('Staging: app/Generated/', 'cyan');

            if (!$force && ($summary['skipped'] ?? 0) > 0) {
                CLI::write(
                    'Note: use --force only when you intend to update files already present in staging.',
                    'yellow'
                );
            }
        } catch (Throwable $e) {
            CLI::error($e->getMessage());
        }
    }

    private function withArchitecture(array $config, string $architecture): array
    {
        $config['architecture'] = $architecture;
        $features = (array) ($config['features'] ?? []);
        $features['entity'] = in_array($architecture, ['standard', 'full'], true);
        $features['service'] = in_array($architecture, ['standard', 'full'], true);
        $features['api'] = $architecture === 'full';
        $config['features'] = $features;

        return $config;
    }

    /**
     * Flattens the tree returned by generators and keeps only nodes
     * that actually represent a file or a create-only/skipped decision.
     *
     * @return list<array<string,mixed>>
     */
    private function collectFileResults(array $node): array
    {
        if (isset($node['status']) && is_string($node['status'])) {
            return [$node];
        }

        $files = [];
        foreach ($node as $value) {
            if (!is_array($value)) {
                continue;
            }

            array_push($files, ...$this->collectFileResults($value));
        }

        return $files;
    }

    private function displayPath(string $path): string
    {
        $normalized = str_replace('\\', '/', $path);
        $root = defined('ROOTPATH')
            ? rtrim(str_replace('\\', '/', ROOTPATH), '/') . '/'
            : '';

        if ($root !== '' && str_starts_with($normalized, $root)) {
            return substr($normalized, strlen($root));
        }

        return $normalized;
    }
}
