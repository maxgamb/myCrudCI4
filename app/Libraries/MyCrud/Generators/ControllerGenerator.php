<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;

/**
 * Genera il Controller web comune alle architetture Basic, Standard e Full.
 *
 * Lato generatore: il Controller prodotto deve descrivere il flusso HTTP e
 * non replicare infrastruttura. Export, parsing lista, token monouso e pulizia
 * meccanica dell'input sono delegati alle librerie runtime App\Libraries\Crud.
 * Le differenze Basic/Standard-Full vengono risolte qui durante la generazione,
 * così il Controller del sito non ha adapter o wrapper privati inutili.
 */
final class ControllerGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $architecture = (string) ($config['architecture'] ?? 'basic');
        $languageFile = (string) ($config['languageFile'] ?? 'Fields');
        $controller = (string) $config['classes']['controller'];
        $model = (string) $config['classes']['model'];
        $service = (string) $config['classes']['service'];
        $rules = (string) $config['classes']['rules'];
        $rulesUse = "use App\\Validation\\{$rules};";
        $useService = !empty($config['features']['service']);
        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');

        $myCrudConfig = config('MyCrud');
        $csvChunkSize = max(100, min(5000, (int) ($myCrudConfig->csvChunkSize ?? 2000)));
        $csvMaximumRows = max(1000, (int) ($myCrudConfig->csvMaximumRows ?? 150000));
        $wordChunkSize = max(100, min(5000, (int) ($myCrudConfig->wordChunkSize ?? $csvChunkSize)));
        $wordMaximumRows = max(1000, (int) ($myCrudConfig->wordMaximumRows ?? 50000));
        $defaultPerPage = max(25, min(100, (int) ($myCrudConfig->defaultPerPage ?? 25)));
        $maximumPerPage = max($defaultPerPage, min(500, (int) ($myCrudConfig->maximumPerPage ?? 100)));
        $relationAjaxLimit = max(1, min(100, (int) ($myCrudConfig->relationAjaxLimit ?? 20)));
        $relationAjaxMinimumChars = max(0, min(10, (int) ($myCrudConfig->relationAjaxMinimumChars ?? 2)));

        $allowedPerPage = array_values(array_filter(
            [25, 50, 100],
            static fn (int $size): bool => $size <= $maximumPerPage
        ));
        if (!in_array($defaultPerPage, $allowedPerPage, true)) {
            $allowedPerPage[] = $defaultPerPage;
        }
        $allowedPerPage = array_values(array_unique($allowedPerPage));
        sort($allowedPerPage);
        $allowedPerPageCode = var_export($allowedPerPage, true);

        $primaryAutoIncrement = false;
        $disabled = [];
        $readonly = [];
        $passwords = [];
        $automaticDateFields = [];
        $managed = [];
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ($config['fields'] as $field) {
            $name = (string) ($field['name'] ?? '');
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));

            if ($name === $primaryKey) {
                $primaryAutoIncrement = !empty($field['autoIncrement']);
            }

            $boolean = (array) ($field['attributes']['boolean'] ?? []);
            if (in_array('disabled', $boolean, true)) {
                $disabled[] = $name;
            }
            if (in_array('readonly', $boolean, true)) {
                $readonly[] = $name;
            }
            if (FieldPolicy::isPassword($name, $inputType)) {
                $passwords[] = $name;
            }
            if (
                preg_match('/(?:^|_)(?:data_record|recorded_at)(?:$|_)/i', $name) === 1
                && in_array($type, ['date', 'datetime', 'timestamp'], true)
            ) {
                $automaticDateFields[$name] = $type === 'date' ? 'Y-m-d' : 'Y-m-d H:i:s';
            }
            if (
                ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true))
                || ($softDeleteEnabled && $name === $deletedField)
            ) {
                $managed[] = $name;
            }
        }

        $disabledCode = var_export(array_values(array_unique($disabled)), true);
        $readonlyCode = var_export(array_values(array_unique($readonly)), true);
        $passwordsCode = var_export(array_values(array_unique($passwords)), true);
        $automaticDateFieldsCode = var_export($automaticDateFields, true);
        $managedCode = var_export(array_values(array_unique($managed)), true);

        $gatewayUse = $useService
            ? "use App\\Services\\{$service};"
            : "use App\\Models\\{$model};";
        $gatewayType = $useService ? $service : $model;
        $gatewayInit = "        \$this->gateway = new {$gatewayType}();";

        // Lato generatore: Standard/Full demandano date e password al Service;
        // Basic usa CrudInputProcessor perché non dispone del livello Service.
        $processorAutomaticDates = $useService ? '[]' : $automaticDateFieldsCode;
        $processorPasswordFields = $useService ? '[]' : $passwordsCode;
        $processorHashPasswords = $useService ? 'false' : 'true';

        if ($useService) {
            $listCall = "\$this->gateway->listPage(\$listRequest->filters, \$listRequest->page, \$listRequest->perPage, \$listRequest->sort, \$listRequest->direction)";
            $findCall = "\$this->gateway->find(\$id)";
            $createCode = "            \$this->gateway->create(\$data);";
            $updateCode = "            \$this->gateway->update(\$id, \$data);";
            $deleteCode = "            \$this->gateway->delete(\$id);";
            $exportFieldsCall = "\$this->gateway->exportFields()";
            $exportCountCall = "\$this->gateway->countExportRows(\$filters)";
            $exportRowsCall = "\$this->gateway->exportRows(\$filters, \$limit, \$after)";
            $deletedListCall = "\$this->gateway->deletedList()";
            $restoreCode = "            \$this->gateway->restore(\$id);";
            $forceDeleteCode = "            \$this->gateway->forceDelete(\$id);";
        } else {
            $listCall = "\$this->gateway->getListPage(\$listRequest->filters, \$listRequest->page, \$listRequest->perPage, \$listRequest->sort, \$listRequest->direction)";
            $findCall = "\$this->gateway->getDetail(\$id)";
            $returnCreatedId = $primaryAutoIncrement
                ? ''
                : "\n            // PK non autoincrementale: l'ID resta quello ricevuto dal form.\n";
            $createCode = <<<PHP
            \$createdId = \$this->gateway->insert(\$data, true);
            if (\$createdId === false) {
                throw new RuntimeException(implode(' ', \$this->gateway->errors()) ?: 'Inserimento non riuscito.');
            }
            \$this->gateway->clearListCountCache();{$returnCreatedId}
PHP;
            $updateCode = <<<PHP
            if (!\$this->gateway->update(\$id, \$data)) {
                throw new RuntimeException(implode(' ', \$this->gateway->errors()) ?: 'Aggiornamento non riuscito.');
            }
PHP;
            $deleteCode = <<<PHP
            if (!\$this->gateway->delete(\$id)) {
                throw new RuntimeException('Eliminazione non riuscita.');
            }
            \$this->gateway->clearListCountCache();
PHP;
            $exportFieldsCall = "\$this->gateway->exportFields()";
            $exportCountCall = "\$this->gateway->countExportRows(\$filters)";
            $exportRowsCall = "\$this->gateway->getExportRows(\$filters, \$limit, \$after)";
            $deletedListCall = "\$this->gateway->getDeletedList()";
            $restoreCode = <<<PHP
            if (!\$this->gateway->restoreRecord(\$id)) {
                throw new RuntimeException('Ripristino non riuscito.');
            }
            \$this->gateway->clearListCountCache();
PHP;
            $forceDeleteCode = <<<PHP
            if (!\$this->gateway->delete(\$id, true)) {
                throw new RuntimeException('Eliminazione definitiva non riuscita.');
            }
            \$this->gateway->clearListCountCache();
PHP;
        }

        $unsetCreatePrimaryKey = $primaryAutoIncrement ? "        unset(\$data['{$primaryKey}']);\n" : '';

        $softMethods = $softDeleteEnabled ? <<<PHP
    /** Mostra i record eliminati logicamente. */
    public function trash()
    {
        return view('{$table}/trash', [
            'title' => 'Cestino',
            'rows' => {$deletedListCall},
            'primaryKey' => '{$primaryKey}',
            'deletedField' => '{$deletedField}',
        ]);
    }

    public function restore(int|string \$id)
    {
        try {
{$restoreCode}
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}/trash'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record ripristinato.');
    }

    public function forceDelete(int|string \$id)
    {
        try {
{$forceDeleteCode}
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}/trash'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record eliminato definitivamente.');
    }

PHP : '';

        $relationContextFields = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $fieldConfig) {
            if (empty($fieldConfig['foreignKey'])) {
                continue;
            }
            if (!empty($fieldConfig['relationNavigation']['acceptContext'])) {
                $relationContextFields[] = (string) $fieldName;
            }
        }
        $relationContextFieldsCode = var_export(array_values(array_unique($relationContextFields)), true);

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\SubmissionGuard;
{$gatewayUse}
{$rulesUse}
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * Controller CRUD {$architecture} per {$table}.
 *
 * Lato sito: coordina request, validazione, view e redirect. Le query restano
 * nel Model; Standard/Full demandano inoltre la logica applicativa al Service.
 */
final class {$controller} extends BaseController
{
    /** Limiti export configurati al momento della generazione. */
    private const EXPORT_OPTIONS = [
        'csv' => ['chunkSize' => {$csvChunkSize}, 'maximumRows' => {$csvMaximumRows}],
        'word' => ['chunkSize' => {$wordChunkSize}, 'maximumRows' => {$wordMaximumRows}],
    ];

    private {$gatewayType} \$gateway;
    private CrudExporter \$exporter;
    private CrudInputProcessor \$inputProcessor;
    private SubmissionGuard \$submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
{$gatewayInit}
        // Runtime comune del sito: una sola implementazione per export, input e token.
        \$this->exporter = new CrudExporter();
        \$this->inputProcessor = new CrudInputProcessor();
        \$this->submissionGuard = new SubmissionGuard();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        \$listRequest = CrudListRequest::fromRequest(
            \$this->request,
            '{$primaryKey}',
            {$allowedPerPageCode}
        );

        \$data = {$listCall};
        \$data += [
            'title' => '{$table}',
            'primaryKey' => '{$primaryKey}',
            'filters' => \$listRequest->filters,
            'query' => \$listRequest->query,
        ];

        if (\$this->request->isAJAX()) {
            return view('{$table}/_table', \$data);
        }

        \$data['options'] = \$this->gateway->relationOptions();

        return view('{$table}/index', \$data);
    }

    /** Endpoint JSON usato dalle select AJAX delle relazioni grandi. */
    public function relationOptions(string \$field)
    {
        \$query = trim((string) \$this->request->getGet('q'));
        if (strlen(\$query) < {$relationAjaxMinimumChars}) {
            return \$this->response->setJSON(['results' => []]);
        }

        return \$this->response->setJSON([
            'results' => \$this->gateway->searchRelationOptions(\$field, \$query, {$relationAjaxLimit}),
        ]);
    }

    public function exportCsv()
    {
        return \$this->export('csv');
    }

    public function exportWord()
    {
        return \$this->export('word');
    }

    public function view(int|string \$id)
    {
        \$row = \$this->findRecordOrFail(\$id);

        return view('{$table}/view', [
            'title' => 'Dettaglio',
            'row' => \$row,
            'children' => \$this->gateway->loadHasMany(\$id),
        ]);
    }

    public function create()
    {
        // Le sole FK esplicitamente abilitate dal Builder possono essere
        // ricevute dalla query string. Prima di usarle verifichiamo che il
        // record padre esista realmente: hidden/select/input non fanno
        // differenza dal punto di vista della sicurezza.
        \$context = [];
        \$contextLabels = [];
        foreach ({$relationContextFieldsCode} as \$field) {
            \$requested = \$this->request->getGet(\$field);
            if (!is_scalar(\$requested) || trim((string) \$requested) === '') {
                continue;
            }

            \$option = \$this->gateway->relationOptionById(\$field, (string) \$requested);
            if (\$option === null) {
                throw PageNotFoundException::forPageNotFound('Valore FK non valido per ' . \$field . '.');
            }

            \$context[\$field] = (string) \$option['id'];
            \$contextLabels[\$field] = (string) \$option['text'];
        }

        return view('{$table}/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => \$this->gateway->relationOptions(),
            'context' => \$context,
            'contextLabels' => \$contextLabels,
            'submissionToken' => \$this->submissionGuard->create('store'),
        ]);
    }

    public function store()
    {
        if (!\$this->submissionGuard->consume('store', \$this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!\$this->validate({$rules}::createRules(), {$rules}::messages())) {
            return redirect()->back()->withInput()->with('errors', \$this->validator->getErrors());
        }

        \$data = \$this->formData(false);
{$unsetCreatePrimaryKey}
        try {
{$createCode}
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string \$id)
    {
        return view('{$table}/edit', [
            'title' => 'Modifica record',
            'row' => \$this->findRecordOrFail(\$id),
            'errors' => session('errors') ?? [],
            'options' => \$this->gateway->relationOptions(),
            'submissionToken' => \$this->submissionGuard->create('update_' . (string) \$id),
        ]);
    }

    public function update(int|string \$id)
    {
        if (!\$this->submissionGuard->consume('update_' . (string) \$id, \$this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!\$this->validate({$rules}::updateRules(\$id), {$rules}::messages())) {
            return redirect()->back()->withInput()->with('errors', \$this->validator->getErrors());
        }

        \$data = \$this->formData(true);
        unset(\$data['{$primaryKey}']);

        try {
{$updateCode}
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string \$id)
    {
        try {
{$deleteCode}
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record eliminato correttamente.');
    }

{$softMethods}    /**
     * Unifica CSV e Word: cambia solo il writer selezionato dalla libreria runtime.
     */
    private function export(string \$format)
    {
        \$options = self::EXPORT_OPTIONS[\$format] ?? null;
        if (!is_array(\$options)) {
            throw new RuntimeException('Formato export non supportato.');
        }

        \$listRequest = CrudListRequest::fromRequest(\$this->request, '{$primaryKey}', {$allowedPerPageCode});

        try {
            return \$this->exporter->download(
                format: \$format,
                response: \$this->response,
                filename: '{$table}',
                languageGroup: '{$languageFile}',
                fields: {$exportFieldsCall},
                filters: \$listRequest->filters,
                countProvider: fn (array \$filters): int => {$exportCountCall},
                rowProvider: fn (array \$filters, int \$limit, int|string|null \$after): array => {$exportRowsCall},
                primaryKey: '{$primaryKey}',
                chunkSize: (int) \$options['chunkSize'],
                maximumRows: (int) \$options['maximumRows']
            );
        } catch (RuntimeException \$e) {
            if (str_starts_with(\$e->getMessage(), 'EXPORT_LIMIT:')) {
                return \$this->exportLimitRedirect(strtoupper(\$format));
            }
            throw \$e;
        }
    }

    /** Recupera il record o converte l'assenza in un normale 404 del sito. */
    private function findRecordOrFail(int|string \$id): object
    {
        try {
            \$record = {$findCall};
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        if (!is_object(\$record)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return \$record;
    }

    /**
     * Pulizia meccanica comune ai form. In Standard/Full date e password sono
     * preparate dal Service; in Basic vengono gestite qui dal runtime CRUD.
     */
    private function formData(bool \$isUpdate): array
    {
        return \$this->inputProcessor->process(
            \$this->request->getPost(),
            \$isUpdate,
            {$processorAutomaticDates},
            {$disabledCode},
            {$managedCode},
            {$readonlyCode},
            {$processorPasswordFields},
            {$processorHashPasswords}
        );
    }

    private function exportLimitRedirect(string \$format)
    {
        return redirect()->to(site_url('{$table}') . '?' . http_build_query((array) \$this->request->getGet()))
            ->with('error', 'Applicare filtri più restrittivi prima di esportare in ' . \$format . '.');
    }
}

PHP;

        return $this->writeGenerated("Generated/Controllers/{$controller}.php", $content, $force);
    }
}
