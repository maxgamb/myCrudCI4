<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use RuntimeException;

/**
 * Risolve la configurazione effettiva di un CRUD nella linea 2.8.
 *
 * Lo schema DB è sempre la fonte per struttura, indici e relazioni; il file
 * persistente applica sopra lo schema solo le scelte dello sviluppatore.
 */
final class CrudConfigurationService
{
    public function __construct(
        private readonly ?ConfigBuilder $builder = null,
        private readonly ?CrudConfigRepository $repository = null,
    ) {
    }

    /**
     * @return array{config:array<string,mixed>,saved:bool,configPath:?string,schemaDrift:bool,savedVersion:?string}
     */
    public function resolve(string $table, bool $preferSaved = true): array
    {
        $builder = $this->builder ?? new ConfigBuilder();
        $repository = $this->repository ?? new CrudConfigRepository();

        $base = $builder->buildFromTable($table);
        $saved = $preferSaved ? $repository->load($table) : null;

        if ($saved === null) {
            return [
                'config' => $base,
                'saved' => false,
                'configPath' => null,
                'schemaDrift' => false,
                'savedVersion' => null,
            ];
        }

        $savedMeta = (array) ($saved['_meta'] ?? []);
        $currentFingerprint = $repository->schemaFingerprint($base);
        $savedFingerprint = (string) ($savedMeta['schemaFingerprint'] ?? '');

        return [
            'config' => $builder->mergeSavedConfiguration($base, $saved),
            'saved' => true,
            'configPath' => $repository->pathFor($table),
            'schemaDrift' => $savedFingerprint !== '' && !hash_equals($savedFingerprint, $currentFingerprint),
            'savedVersion' => isset($savedMeta['generatorVersion'])
                ? (string) $savedMeta['generatorVersion']
                : null,
        ];
    }

    /**
     * Salva lo snapshot persistente della configurazione effettiva.
     */
    public function persist(array $config): string
    {
        $table = trim((string) ($config['table'] ?? ''));
        if ($table === '') {
            throw new RuntimeException('Configurazione senza nome tabella.');
        }

        return ($this->repository ?? new CrudConfigRepository())->save($table, $config);
    }

    /** @return list<string> */
    public function configuredTables(): array
    {
        return ($this->repository ?? new CrudConfigRepository())->tables();
    }
}
