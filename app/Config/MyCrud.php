<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyCrud extends BaseConfig
{
    public string $version = '2.7.1';

    /**
     * I generatori producono classi con namespace App\\... e view risolte da
     * CodeIgniter dentro APPPATH. Per questo il percorso operativo predefinito
     * deve essere APPPATH e non una cartella di staging non autocaricata.
     */
    public string $generatedPath = APPPATH;

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
