<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;

/** Genera il Controller web comune alle architetture Basic, Standard e Full. */
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
        $useService = !empty($config['features']['service']);
        $rulesUse = "use App\\Validation\\{$rules};";

        $myCrudConfig = config('MyCrud');
        $csvChunkSize = max(100, min(5000, (int) ($myCrudConfig->csvChunkSize ?? 2000)));
        $csvMaximumRows = max(1000, (int) ($myCrudConfig->csvMaximumRows ?? 150000));
        $wordChunkSize = max(100, min(5000, (int) ($myCrudConfig->wordChunkSize ?? $csvChunkSize)));
        $wordMaximumRows = max(1000, (int) ($myCrudConfig->wordMaximumRows ?? 50000));
        $defaultPerPage = max(25, min(100, (int) ($myCrudConfig->defaultPerPage ?? 25)));
        $maximumPerPage = max($defaultPerPage, min(500, (int) ($myCrudConfig->maximumPerPage ?? 100)));

        $primaryAutoIncrement = false;
        $exportFields = [];
        $exportHeaderLines = [];
        $disabled = [];
        $readonly = [];
        $passwords = [];
        $automaticDateFields = [];
        $managed = [];
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);
        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');

        foreach ($config['fields'] as $field) {
            $name = (string) ($field['name'] ?? '');
            $ui = (array) ($field['ui'] ?? []);
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));

            if ($name === $primaryKey) {
                $primaryAutoIncrement = !empty($field['autoIncrement']);
            }

            if (
                !empty($ui['exportable'])
                && empty($ui['sensitive'])
                && !FieldPolicy::isSensitive($name, $inputType)
                && !str_contains($type, 'blob')
                && !str_contains($type, 'binary')
                && !in_array($inputType, ['file', 'image'], true)
            ) {
                $exportFields[] = $name;
                $customLabel = trim((string) ($field['label'] ?? ''));
                $headerExpression = $customLabel !== ''
                    ? var_export($customLabel, true)
                    : "lang('" . (string) ($field['languageKey'] ?? ('Fields.' . $name)) . "')";
                $exportHeaderLines[] = "            '{$name}' => {$headerExpression},";
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

        if (!in_array($primaryKey, $exportFields, true)) {
            array_unshift($exportFields, $primaryKey);
            array_unshift($exportHeaderLines, "            '{$primaryKey}' => lang('{$languageFile}.{$primaryKey}'),");
        }

        $exportFields = array_values(array_unique($exportFields));
        $exportFieldsCode = var_export($exportFields, true);
        $exportHeadersCode = implode("\n", array_values(array_unique($exportHeaderLines)));
        $disabledCode = var_export(array_values(array_unique($disabled)), true);
        $readonlyCode = var_export(array_values(array_unique($readonly)), true);
        $passwordsCode = var_export(array_values(array_unique($passwords)), true);
        $automaticDateFieldsCode = var_export($automaticDateFields, true);
        $managedCode = var_export(array_values(array_unique($managed)), true);
        $unsetCreatePrimaryKey = $primaryAutoIncrement ? "        unset(\$data['{$primaryKey}']);\n" : '';

        $basicPasswordHashCode = $useService ? '' : <<<PHP
        foreach ({$passwordsCode} as \$field) {
            if (isset(\$data[\$field]) && trim((string) \$data[\$field]) !== '') {
                \$data[\$field] = password_hash((string) \$data[\$field], PASSWORD_DEFAULT);
            }
        }

PHP;

        if ($useService) {
            $gatewayUse = "use App\\Services\\{$service};";
            $gatewayProperty = "    private {$service} \$gateway;";
            $gatewayInit = "        \$this->gateway = new {$service}();";
            $gatewayAdapters = <<<PHP
    private function listPage(array \$filters, int \$page, int \$perPage, string \$sort, string \$direction): array
    {
        return \$this->gateway->listPage(\$filters, \$page, \$perPage, \$sort, \$direction);
    }

    private function exportRows(array \$filters, int \$limit, int|string|null \$after): array
    {
        return \$this->gateway->csvRows(\$filters, \$limit, \$after);
    }

    private function countExportRows(array \$filters): int
    {
        return \$this->gateway->countCsvRows(\$filters);
    }

    private function findRecord(int|string \$id): object
    {
        return \$this->gateway->find(\$id);
    }

    private function relationOptions(): array
    {
        return \$this->gateway->relationOptions();
    }

    private function loadHasMany(int|string \$id): array
    {
        return \$this->gateway->loadHasMany(\$id);
    }

    private function createRecord(array \$data): int|string
    {
        return \$this->gateway->create(\$data);
    }

    private function updateRecord(int|string \$id, array \$data): void
    {
        \$this->gateway->update(\$id, \$data);
    }

    private function deleteRecord(int|string \$id): void
    {
        \$this->gateway->delete(\$id);
    }

PHP;
            $softGatewayAdapters = $softDeleteEnabled ? <<<PHP
    private function deletedRecords(): array
    {
        return \$this->gateway->deletedList();
    }

    private function restoreRecord(int|string \$id): void
    {
        \$this->gateway->restore(\$id);
    }

    private function forceDeleteRecord(int|string \$id): void
    {
        \$this->gateway->forceDelete(\$id);
    }

PHP : '';
        } else {
            $gatewayUse = "use App\\Models\\{$model};";
            $gatewayProperty = "    private {$model} \$gateway;";
            $gatewayInit = "        \$this->gateway = new {$model}();";
            $returnCreatedId = $primaryAutoIncrement
                ? "        return is_int(\$id) ? \$id : (string) \$id;"
                : "        if (array_key_exists('{$primaryKey}', \$data) && (is_int(\$data['{$primaryKey}']) || is_string(\$data['{$primaryKey}']))) {\n            return \$data['{$primaryKey}'];\n        }\n        return is_int(\$id) ? \$id : (string) \$id;";

            $gatewayAdapters = <<<PHP
    private function listPage(array \$filters, int \$page, int \$perPage, string \$sort, string \$direction): array
    {
        return \$this->gateway->getListPage(\$filters, \$page, \$perPage, \$sort, \$direction);
    }

    private function exportRows(array \$filters, int \$limit, int|string|null \$after): array
    {
        return \$this->gateway->getCsvRows(\$filters, \$limit, \$after);
    }

    private function countExportRows(array \$filters): int
    {
        return \$this->gateway->countCsvRows(\$filters);
    }

    private function findRecord(int|string \$id): object
    {
        \$record = \$this->gateway->getDetail(\$id);
        if (!is_object(\$record)) {
            throw new RuntimeException('Record non trovato.');
        }
        return \$record;
    }

    private function relationOptions(): array
    {
        return \$this->gateway->relationOptions();
    }

    private function loadHasMany(int|string \$id): array
    {
        return \$this->gateway->loadHasMany(\$id);
    }

    private function createRecord(array \$data): int|string
    {
        \$id = \$this->gateway->insert(\$data, true);
        if (\$id === false) {
            throw new RuntimeException(implode(' ', \$this->gateway->errors()) ?: 'Inserimento non riuscito.');
        }
        \$this->gateway->clearListCountCache();
{$returnCreatedId}
    }

    private function updateRecord(int|string \$id, array \$data): void
    {
        if (!\$this->gateway->update(\$id, \$data)) {
            throw new RuntimeException(implode(' ', \$this->gateway->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    private function deleteRecord(int|string \$id): void
    {
        if (!\$this->gateway->delete(\$id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
        \$this->gateway->clearListCountCache();
    }

PHP;
            $softGatewayAdapters = $softDeleteEnabled ? <<<PHP
    private function deletedRecords(): array
    {
        return \$this->gateway->getDeletedList();
    }

    private function restoreRecord(int|string \$id): void
    {
        if (!\$this->gateway->restoreRecord(\$id)) {
            throw new RuntimeException('Ripristino non riuscito.');
        }
        \$this->gateway->clearListCountCache();
    }

    private function forceDeleteRecord(int|string \$id): void
    {
        if (!\$this->gateway->delete(\$id, true)) {
            throw new RuntimeException('Eliminazione definitiva non riuscita.');
        }
        \$this->gateway->clearListCountCache();
    }

PHP : '';
        }

        $softMethods = $softDeleteEnabled ? <<<PHP
    public function trash()
    {
        return view('{$table}/trash', [
            'title' => 'Cestino',
            'rows' => \$this->deletedRecords(),
            'primaryKey' => '{$primaryKey}',
            'deletedField' => '{$deletedField}',
        ]);
    }

    public function restore(int|string \$id)
    {
        try {
            \$this->restoreRecord(\$id);
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}/trash'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record ripristinato.');
    }

    public function forceDelete(int|string \$id)
    {
        try {
            \$this->forceDeleteRecord(\$id);
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}/trash'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record eliminato definitivamente.');
    }

PHP : '';

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
{$gatewayUse}
{$rulesUse}
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/** Controller CRUD {$architecture} per {$table}; tutte le query restano nel Model. */
final class {$controller} extends BaseController
{
    private const EXPORT_FIELDS = {$exportFieldsCode};
    private const CSV_CHUNK_SIZE = {$csvChunkSize};
    private const CSV_MAXIMUM_ROWS = {$csvMaximumRows};
    private const WORD_CHUNK_SIZE = {$wordChunkSize};
    private const WORD_MAXIMUM_ROWS = {$wordMaximumRows};

{$gatewayProperty}

    public function __construct()
    {
        helper(['form', 'url']);
{$gatewayInit}
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        \$filters = \$this->getListFilters();
        \$page = max(1, (int) (\$this->request->getGet('page') ?? 1));
        \$perPage = \$this->getPerPage();
        \$sort = trim((string) (\$this->request->getGet('sort') ?? '{$primaryKey}'));
        \$direction = strtolower((string) (\$this->request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        \$data = \$this->listPage(\$filters, \$page, \$perPage, \$sort, \$direction);
        \$data['title'] = '{$table}';
        \$data['primaryKey'] = '{$primaryKey}';
        \$data['filters'] = \$filters;
        \$data['query'] = (array) \$this->request->getGet();

        if (\$this->request->isAJAX()) {
            return view('{$table}/_table', \$data);
        }

        \$data['options'] = \$this->relationOptions();

        return view('{$table}/index', \$data);
    }

    /** Esporta in CSV gli stessi record risultanti dai filtri correnti. */
    public function exportCsv()
    {
        \$filters = \$this->getListFilters();
        \$total = \$this->countExportRows(\$filters);

        if (\$total > self::CSV_MAXIMUM_ROWS) {
            return \$this->exportLimitRedirect('CSV');
        }

        \$temporaryFile = \$this->createTemporaryFile('mycrud_csv_');
        \$handle = fopen(\$temporaryFile, 'wb');
        if (\$handle === false) {
            @unlink(\$temporaryFile);
            throw new RuntimeException('Impossibile aprire il file CSV temporaneo.');
        }

        try {
            fwrite(\$handle, "\xEF\xBB\xBF");
            fputcsv(\$handle, array_values(\$this->exportHeaders()), ';', '"', '');

            \$cursor = null;
            do {
                \$rows = \$this->exportRows(\$filters, self::CSV_CHUNK_SIZE, \$cursor);
                foreach (\$rows as \$row) {
                    \$line = [];
                    foreach (self::EXPORT_FIELDS as \$field) {
                        \$line[] = \$this->safeCsvValue(\$row[\$field] ?? '');
                    }
                    fputcsv(\$handle, \$line, ';', '"', '');
                }
                \$cursor = \$this->nextCursor(\$rows);
            } while (count(\$rows) === self::CSV_CHUNK_SIZE && \$cursor !== null);
        } finally {
            fclose(\$handle);
        }

        \$this->registerTemporaryFileCleanup(\$temporaryFile);

        return \$this->response
            ->download(\$temporaryFile, null)
            ->setFileName('{$table}_' . date('Y-m-d_H-i-s') . '.csv');
    }

    /** Esporta un documento HTML compatibile con Microsoft Word. */
    public function exportWord()
    {
        \$filters = \$this->getListFilters();
        \$total = \$this->countExportRows(\$filters);

        if (\$total > self::WORD_MAXIMUM_ROWS) {
            return \$this->exportLimitRedirect('Word');
        }

        \$temporaryFile = \$this->createTemporaryFile('mycrud_word_');
        \$handle = fopen(\$temporaryFile, 'wb');
        if (\$handle === false) {
            @unlink(\$temporaryFile);
            throw new RuntimeException('Impossibile aprire il file Word temporaneo.');
        }

        try {
            fwrite(\$handle, "\xEF\xBB\xBF");
            fwrite(\$handle, '<!DOCTYPE html><html><head><meta charset="UTF-8">');
            fwrite(\$handle, '</head><body>');
            fwrite(\$handle, '<h1>' . \$this->wordEscape('{$table}') . '</h1>');
            fwrite(\$handle, '<p>Esportazione: ' . \$this->wordEscape(date('d/m/Y H:i:s')) . '</p>');
            fwrite(\$handle, '<p>Record: ' . number_format(\$total, 0, ',', '.') . '</p>');
            fwrite(\$handle, \$this->wordFiltersHtml(\$filters));
            fwrite(\$handle, '<table border="1" cellpadding="4" cellspacing="0"><thead><tr>');
            foreach (\$this->exportHeaders() as \$header) {
                fwrite(\$handle, '<th>' . \$this->wordEscape(\$header) . '</th>');
            }
            fwrite(\$handle, '</tr></thead><tbody>');

            \$cursor = null;
            do {
                \$rows = \$this->exportRows(\$filters, self::WORD_CHUNK_SIZE, \$cursor);
                foreach (\$rows as \$row) {
                    fwrite(\$handle, '<tr>');
                    foreach (self::EXPORT_FIELDS as \$field) {
                        fwrite(\$handle, '<td>' . \$this->wordEscape(\$row[\$field] ?? '') . '</td>');
                    }
                    fwrite(\$handle, '</tr>');
                }
                \$cursor = \$this->nextCursor(\$rows);
            } while (count(\$rows) === self::WORD_CHUNK_SIZE && \$cursor !== null);

            fwrite(\$handle, '</tbody></table></body></html>');
        } finally {
            fclose(\$handle);
        }

        \$this->registerTemporaryFileCleanup(\$temporaryFile);

        return \$this->response
            ->download(\$temporaryFile, null)
            ->setFileName('{$table}_' . date('Y-m-d_H-i-s') . '.doc')
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8');
    }

    public function view(int|string \$id)
    {
        try {
            \$row = \$this->findRecord(\$id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('{$table}/view', [
            'title' => 'Dettaglio',
            'row' => \$row,
            'children' => \$this->loadHasMany(\$id),
        ]);
    }

    public function create()
    {
        return view('{$table}/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => \$this->relationOptions(),
            'submissionToken' => \$this->createSubmissionToken('store'),
        ]);
    }

    public function store()
    {
        if (!\$this->consumeSubmissionToken('store')) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!\$this->validate({$rules}::createRules(), {$rules}::messages())) {
            return redirect()->back()->withInput()->with('errors', \$this->validator->getErrors());
        }

        \$data = \$this->sanitizeInput(\$this->request->getPost(), false);
{$unsetCreatePrimaryKey}
        try {
            \$this->createRecord(\$data);
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string \$id)
    {
        try {
            \$row = \$this->findRecord(\$id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('{$table}/edit', [
            'title' => 'Modifica record',
            'row' => \$row,
            'errors' => session('errors') ?? [],
            'options' => \$this->relationOptions(),
            'submissionToken' => \$this->createSubmissionToken('update_' . (string) \$id),
        ]);
    }

    public function update(int|string \$id)
    {
        if (!\$this->consumeSubmissionToken('update_' . (string) \$id)) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!\$this->validate({$rules}::updateRules(\$id), {$rules}::messages())) {
            return redirect()->back()->withInput()->with('errors', \$this->validator->getErrors());
        }

        \$data = \$this->sanitizeInput(\$this->request->getPost(), true);
        unset(\$data['{$primaryKey}']);

        try {
            \$this->updateRecord(\$id, \$data);
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string \$id)
    {
        try {
            \$this->deleteRecord(\$id);
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record eliminato correttamente.');
    }

{$softMethods}{$gatewayAdapters}{$softGatewayAdapters}    private function getListFilters(): array
    {
        return (array) (\$this->request->getGet('filter') ?? []);
    }

    private function getPerPage(): int
    {
        \$requested = (int) (\$this->request->getGet('perPage') ?? {$defaultPerPage});
        \$allowed = array_values(array_unique(array_filter([25, 50, 100, {$maximumPerPage}], static fn (int \$value): bool => \$value >= 25 && \$value <= {$maximumPerPage})));

        return in_array(\$requested, \$allowed, true) ? \$requested : {$defaultPerPage};
    }

    /** @return array<string, string> */
    private function exportHeaders(): array
    {
        return [
{$exportHeadersCode}
        ];
    }

    private function nextCursor(array \$rows): int|string|null
    {
        if (\$rows === []) {
            return null;
        }

        \$last = end(\$rows);

        return is_array(\$last) && isset(\$last['{$primaryKey}'])
            ? \$last['{$primaryKey}']
            : null;
    }

    private function createTemporaryFile(string \$prefix): string
    {
        \$directory = WRITEPATH . 'cache';
        if (!is_dir(\$directory) && !mkdir(\$directory, 0755, true) && !is_dir(\$directory)) {
            throw new RuntimeException('Impossibile creare la directory temporanea.');
        }

        \$temporaryFile = tempnam(\$directory, \$prefix);
        if (\$temporaryFile === false) {
            throw new RuntimeException('Impossibile creare il file temporaneo.');
        }

        return \$temporaryFile;
    }

    private function registerTemporaryFileCleanup(string \$temporaryFile): void
    {
        register_shutdown_function(static function () use (\$temporaryFile): void {
            if (is_file(\$temporaryFile)) {
                @unlink(\$temporaryFile);
            }
        });
    }

    private function exportLimitRedirect(string \$format)
    {
        return redirect()->to(site_url('{$table}') . '?' . http_build_query((array) \$this->request->getGet()))
            ->with('error', 'Applicare filtri più restrittivi prima di esportare in ' . \$format . '.');
    }

    private function safeCsvValue(mixed \$value): string
    {
        \$value = is_scalar(\$value) || \$value === null
            ? (string) \$value
            : (json_encode(\$value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '');

        if (\$value !== '' && preg_match('/^[=+\\-@]/u', \$value) === 1) {
            return "'" . \$value;
        }

        return \$value;
    }

    private function wordEscape(mixed \$value): string
    {
        if (!is_scalar(\$value) && \$value !== null) {
            \$value = json_encode(\$value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
        }

        return htmlspecialchars((string) \$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function wordFiltersHtml(array \$filters): string
    {
        \$items = [];
        foreach (\$filters as \$field => \$value) {
            if (is_array(\$value)) {
                \$value = implode(' - ', array_filter(array_map('strval', \$value), static fn (string \$item): bool => \$item !== ''));
            }
            if (!is_scalar(\$value) || trim((string) \$value) === '') {
                continue;
            }
            \$items[] = '<li><strong>' . \$this->wordEscape(\$field) . ':</strong> ' . \$this->wordEscape(\$value) . '</li>';
        }

        return \$items === [] ? '' : '<h2>Filtri applicati</h2><ul>' . implode('', \$items) . '</ul>';
    }

    private function sanitizeInput(array \$data, bool \$isUpdate): array
    {
        unset(\$data['_submission_token']);
        \$csrfName = csrf_token();
        if (\$csrfName !== '') {
            unset(\$data[\$csrfName]);
        }

        if (!\$isUpdate) {
            foreach ({$automaticDateFieldsCode} as \$field => \$format) {
                if (!isset(\$data[\$field]) || trim((string) \$data[\$field]) === '') {
                    \$data[\$field] = date(\$format);
                }
            }
        }

        foreach (array_merge({$disabledCode}, {$managedCode}) as \$field) {
            unset(\$data[\$field]);
        }
        if (\$isUpdate) {
            foreach ({$readonlyCode} as \$field) {
                unset(\$data[\$field]);
            }
            foreach ({$passwordsCode} as \$field) {
                if ((string) (\$data[\$field] ?? '') === '') {
                    unset(\$data[\$field]);
                }
            }
        }

{$basicPasswordHashCode}        return \$data;
    }

    private function createSubmissionToken(string \$action): string
    {
        \$token = bin2hex(random_bytes(16));
        session()->set('mycrud_submission_' . \$action . '_' . \$token, true);

        return \$token;
    }

    private function consumeSubmissionToken(string \$action): bool
    {
        \$token = trim((string) \$this->request->getPost('_submission_token'));
        if (\$token === '') {
            return false;
        }

        \$key = 'mycrud_submission_' . \$action . '_' . \$token;
        if (!session()->has(\$key)) {
            return false;
        }

        session()->remove(\$key);

        return true;
    }
}

PHP;

        return $this->writeGenerated("Generated/Controllers/{$controller}.php", $content, $force);
    }
}
