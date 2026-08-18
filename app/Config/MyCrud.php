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

    /**
     * Directory persistente per i Service Extension custom.
     * Non appartiene allo staging Generated/ e può essere cancellato/rigenerato
     * indipendentemente senza perdere il codice dello sviluppatore.
     */
    public string $serviceExtensionPath = APPPATH . 'Services' . DIRECTORY_SEPARATOR . 'Extensions';

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

    /** Persistent application Dashboard configurations. */
    public string $dashboardConfigPath = APPPATH . 'MyCrudConfig' . DIRECTORY_SEPARATOR . 'Dashboards';

    /** Compatibilità in lettura con le configurazioni JSON della linea 2.7.x. */
    public string $legacyCrudConfigPath = WRITEPATH . 'mycrud';

    public string $defaultArchitecture = 'full';
    public bool $safeWrite = true;

    /**
     * Genera test contract/smoke insieme al CRUD.
     *
     * I file nascono in app/Generated/Tests/ e vengono pubblicati dal comando
     * mycrud:publish sotto ROOTPATH/tests/, separati dal codice applicativo.
     */
    public bool $testScaffolding = true;

    public int $defaultPerPage = 25;
    public int $maximumPerPage = 100;
    public int $listCountCacheSeconds = 60;
    public int $csvChunkSize = 2000;
    public int $csvMaximumRows = 150000;
    public int $csvUnfilteredMaximumRows = 25000;
    public int $wordChunkSize = 1000;
    public int $wordMaximumRows = 10000;
    public int $wordUnfilteredMaximumRows = 5000;

    /** Anteprima tabellare: il contenuto completo resta in dettaglio/form/export. */
    public int $mediumTextPreviewLength = 250;
    public int $longTextPreviewLength = 350;

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

    /**
     * Upload file/immagini generati da myCrudCI4.
     *
     * Tutte le impostazioni globali degli upload sono raccolte qui, così non
     * devono essere duplicate nel Builder o nei generatori.
     *
     * directory
     *     Directory fisica in cui vengono salvati i file. Di default tutti gli
     *     upload finiscono direttamente in writable/uploads/, senza sottocartelle.
     *
     * maxSize
     *     Dimensione massima di ogni singolo file espressa in KB.
     *     5120 KB = 5 MB.
     *
     * imageExtensions
     *     Estensioni ammesse quando il campo del Builder usa inputType=image.
     *
     * fileExtensions
     *     Estensioni ammesse quando il campo del Builder usa inputType=file.
     *
     * Il nome fisico resta: <table>_<id>_<field>_<random>.<ext>
     */
    public array $upload = [
        'directory' => WRITEPATH . 'uploads',
        'maxSize' => 5120,
        'imageExtensions' => [
            'jpg', 'jpeg', 'png', 'webp',
        ],
        'fileExtensions' => [
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv',
        ],
    ];

    /**
     * Bootstrap widths offered by Builder > Fields.
     *
     * The key is persisted in the CRUD configuration; the value is only the
     * human-readable Bootstrap class shown by the Builder. Projects may expose
     * a smaller set (for example 12/8/6/4/3) without changing the generator.
     *
     * @var array<int,string>
     */
    public array $bootstrapFieldWidths = [
        12 => 'col-md-12',
        11 => 'col-md-11',
        10 => 'col-md-10',
        9 => 'col-md-9',
        8 => 'col-md-8',
        7 => 'col-md-7',
        6 => 'col-md-6',
        5 => 'col-md-5',
        4 => 'col-md-4',
        3 => 'col-md-3',
        2 => 'col-md-2',
        1 => 'col-md-1',
    ];

    /** Default field width used when a CRUD has no persisted field width yet. */
    public int $defaultBootstrapFieldWidth = 6;

    /**
     * Generated relation UI widths (Bootstrap grid units, 1..12).
     *
     * These are project-wide defaults evaluated at generation time. They do
     * not become runtime metadata or dynamic relation resolvers.
     *
     * @var array<string,int>
     */
    public array $relationPanelWidths = [
        'manyToMany' => 12,
        'relatedCreateField' => 6,
        'manyToManyRelatedCreateField' => 6,
    ];

    /** Global Related Create offcanvas width in pixels. */
    public int $relationOffcanvasWidth = 640;

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
