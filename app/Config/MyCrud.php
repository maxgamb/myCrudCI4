<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyCrud extends BaseConfig
{
    public string $generatedPath = APPPATH . 'Generated/';
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
