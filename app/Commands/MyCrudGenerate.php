<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Genera un singolo CRUD usando, quando disponibile, la config persistente 2.8. */
final class MyCrudGenerate extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:generate';
    protected $description = 'Genera un CRUD dallo schema e dalla configurazione persistente 2.8.';
    protected $usage       = 'mycrud:generate <table> [--architecture basic|standard|full] [--from-schema] [--save-config] [--force]';

    protected $arguments = [
        'table' => 'Nome della tabella.',
    ];

    protected $options = [
        '--architecture' => 'Override temporaneo: basic, standard oppure full.',
        '--from-schema'   => 'Ignora la configurazione persistente per questa generazione.',
        '--save-config'   => 'Salva/aggiorna la configurazione persistente usata.',
        '--force'         => 'Sovrascrive i file già presenti esclusivamente in app/Generated/.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare il nome della tabella.');
            return;
        }

        $configuration = new CrudConfigurationService();
        $resolved = $configuration->resolve($table, !CLI::getOption('from-schema'));
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

        // La prima generazione crea automaticamente la configurazione 2.8.
        // Config già esistenti vengono risalvate solo su richiesta esplicita.
        if (!$resolved['saved'] || CLI::getOption('save-config')) {
            $path = $configuration->persist($config);
            CLI::write('Config: ' . $path, 'cyan');
        } else {
            CLI::write('Config persistente: ' . ($resolved['configPath'] ?? $table), 'cyan');
        }

        if (!empty($resolved['schemaDrift'])) {
            CLI::write('! Lo schema DB è cambiato rispetto all’ultimo salvataggio della configurazione.', 'yellow');
            CLI::write('  La generazione usa comunque lo schema corrente e applica sopra le scelte salvate.', 'yellow');
        }

        $result = (new CrudGeneratorService())->generate(
            $config,
            (bool) CLI::getOption('force')
        );

        CLI::write(
            'CRUD generato: ' . $result['table'] . ' [' . $result['architecture'] . ']',
            'green'
        );
        CLI::write('Output: app/Generated/');
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
}
