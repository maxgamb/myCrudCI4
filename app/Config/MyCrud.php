<?php

namespace Config;

use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\Config\BaseConfig;

class MyCrud extends BaseConfig
{
    public string $version = MyCrudVersion::VERSION;

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



    /**
     * Configurazioni CRUD persistenti e versionabili introdotte nella 2.8.
     * Non sono codice generato: descrivono le scelte dello sviluppatore e
     * vengono riutilizzate per generate-all, diff e rigenerazione controllata.
     */
    public string $crudConfigPath = APPPATH . 'MyCrudConfig';

    /** Compatibilità in lettura con le configurazioni JSON della linea 2.7.x. */
    public string $legacyCrudConfigPath = WRITEPATH . 'mycrud';

    public string $defaultArchitecture = 'full';
    public bool $safeWrite = true;
    public int $defaultPerPage = 25;
    public int $maximumPerPage = 100;
    public int $listCountCacheSeconds = 60;
    public int $csvChunkSize = 2000;
    public int $csvMaximumRows = 150000;
    public int $wordChunkSize = 1000;
    public int $wordMaximumRows = 50000;

    /**
     * Le relazioni con molte righe vengono proposte come select AJAX.
     * La soglia usa TABLE_ROWS di information_schema come stima veloce.
     */
    public int $relationAjaxThreshold = 5000;
    public int $relationAjaxLimit = 20;
    public int $relationAjaxMinimumChars = 2;

    /** Parametri predefiniti dei benchmark CLI. */
    public int $benchmarkIterations = 5;
    public int $benchmarkPerPage = 50;
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
