<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyCrud extends BaseConfig
{
    public string $version = '2.7.3';

    /**
     * Directory base usata dal writer. Ogni generatore deve passare un percorso
     * relativo che inizi con Generated/, così nessun file viene scritto
     * direttamente nelle cartelle operative di app/.
     */
    public string $generatedPath = APPPATH;

    /** Percorso effettivo dell'area di staging sicura. */
    public function generatedStagingPath(): string
    {
        return rtrim($this->generatedPath, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'Generated'
            . DIRECTORY_SEPARATOR;
    }

    public string $defaultArchitecture = 'standard';
    public bool $safeWrite = true;
    public int $defaultPerPage = 25;
    public string $defaultLocale = 'it';
    public string $softDeleteField = 'deleted_at';

    public array $ignoredTables = [
        'migrations', 'sessions', 'cache', 'cache_locks',
    ];

    /** @var list<string> */
    public array $ignoredTablePatterns = [
        '/^tmp_/',
        '/^backup_/',
        '/_backup$/',
    ];

    public array $displayFieldCandidates = [
        'nome', 'name', 'titolo', 'title',
        'descrizione', 'description', 'label', 'codice', 'code',
    ];
}
