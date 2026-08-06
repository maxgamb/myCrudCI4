<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/** Genera Controller sottili: HTTP, validazione e delega. */
final class ControllerGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $controller = (string) $config['classes']['controller'];
        $model = (string) $config['classes']['model'];
        $service = (string) $config['classes']['service'];
        $rules = (string) $config['classes']['rules'];
        $architecture = (string) ($config['architecture'] ?? 'standard');
        $usesService = $architecture !== 'basic' && !empty($config['features']['service']);

        $dependencyUse = $usesService ? "use App\\Services\\{$service};" : "use App\\Models\\{$model};";
        $propertyType = $usesService ? $service : $model;
        $propertyName = $usesService ? 'service' : 'model';
        $construct = $usesService ? "\$this->service = new {$service}();" : "\$this->model = new {$model}();";
        $findCall = $usesService ? "\$this->service->find(\$id)" : "\$this->model->getDetail(\$id)";
        $optionsCall = $usesService ? "\$this->service->relationOptions()" : "\$this->model->relationOptions()";
        $childrenCall = $usesService ? "\$this->service->loadHasMany(\$id)" : "\$this->model->loadHasMany(\$id)";
        $createCall = $usesService
            ? "\$this->service->create(\$data);"
            : "if (\$this->model->insert(\$data, true) === false) {
                throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Inserimento non riuscito.');
            }";
        $updateCall = $usesService
            ? "\$this->service->update(\$id, \$data);"
            : "if (!\$this->model->update(\$id, \$data)) {
                throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Aggiornamento non riuscito.');
            }";
        $deleteCall = $usesService
            ? "\$this->service->delete(\$id);"
            : "if (!\$this->model->delete(\$id)) {
                throw new RuntimeException('Eliminazione non riuscita.');
            }";

        $primaryAutoIncrement = false;
        foreach ($config['fields'] as $field) {
            if ((string) ($field['name'] ?? '') === $primaryKey) {
                $primaryAutoIncrement = !empty($field['autoIncrement']);
                break;
            }
        }
        $unsetCreatePrimaryKey = $primaryAutoIncrement ? "        unset(\$data['{$primaryKey}']);
" : '';

        $disabled = [];
        $readonly = [];
        $passwords = [];
        $managed = [];
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);
        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        foreach ($config['fields'] as $field) {
            $boolean = (array) ($field['attributes']['boolean'] ?? []);
            if (in_array('disabled', $boolean, true)) {
                $disabled[] = (string) $field['name'];
            }
            if (in_array('readonly', $boolean, true)) {
                $readonly[] = (string) $field['name'];
            }
            if ((string) ($field['inputType'] ?? '') === 'password') {
                $passwords[] = (string) $field['name'];
            }
            $fieldName = (string) $field['name'];
            if (
                ($timestampsEnabled && in_array($fieldName, ['created_at', 'updated_at'], true))
                || ($softDeleteEnabled && $fieldName === $deletedField)
            ) {
                $managed[] = $fieldName;
            }
        }
        $disabledCode = var_export($disabled, true);
        $readonlyCode = var_export($readonly, true);
        $passwordsCode = var_export($passwords, true);
        $managedCode = var_export(array_values(array_unique($managed)), true);

        if ($architecture === 'basic') {
            $indexMethod = <<<PHP
    /** Elenco paginato tramite Pager nativo di CodeIgniter. */
    public function index()
    {
        \$perPage = max(10, min(200, (int) (\$this->request->getGet('perPage') ?? 25)));
        \$search = trim((string) (\$this->request->getGet('q') ?? ''));
        \$group = '{$table}';
        \$rows = \$this->model->paginateWithParents(\$perPage, \$group, \$search);

        return view('{$table}/index', [
            'title' => '{$table}',
            'rows' => \$rows,
            'pager' => \$this->model->pager,
            'pagerGroup' => \$group,
            'perPage' => \$perPage,
            'search' => \$search,
            'primaryKey' => '{$primaryKey}',
        ]);
    }

PHP;
            $datatableMethod = '';
        } else {
            $indexMethod = <<<PHP
    public function index()
    {
        return view('{$table}/index', [
            'title' => '{$table}',
            'primaryKey' => '{$primaryKey}',
        ]);
    }

PHP;
            $datatableCall = $usesService ? "\$this->service->datatable(\$this->request->getPost())" : "\$this->model->datatable(\$this->request->getPost())";
            $datatableMethod = <<<PHP
    /** Endpoint DataTables server-side; la query è gestita dal Model. */
    public function datatable()
    {
        \$result = {$datatableCall};
        \$result['csrfHash'] = csrf_hash();
        return \$this->response->setJSON(\$result);
    }

PHP;
        }

        $softMethods = '';
        if (!empty($config['features']['softDeletes'])) {
            $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
            $deletedCall = $usesService ? "\$this->service->deletedList()" : "\$this->model->getDeletedList()";
            $restoreCall = $usesService ? "\$this->service->restore(\$id)" : "\$this->model->restoreRecord(\$id)";
            $forceCall = $usesService ? "\$this->service->forceDelete(\$id)" : "\$this->model->delete(\$id, true)";
            $softMethods = <<<PHP
    public function trash()
    {
        return view('{$table}/trash', [
            'title' => 'Cestino',
            'rows' => {$deletedCall},
            'primaryKey' => '{$primaryKey}',
            'deletedField' => '{$deletedField}',
        ]);
    }

    public function restore(int|string \$id)
    {
        {$restoreCall};
        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record ripristinato.');
    }

    public function forceDelete(int|string \$id)
    {
        {$forceCall};
        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record eliminato definitivamente.');
    }

PHP;
        }

        $rulesUse = "use App\\Validation\\{$rules};";

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
{$dependencyUse}
{$rulesUse}
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/** Controller CRUD per {$table}; non contiene query SQL. */
final class {$controller} extends BaseController
{
    private {$propertyType} \${$propertyName};

    public function __construct()
    {
        helper(['form', 'url']);
        {$construct}
    }

{$indexMethod}{$datatableMethod}    public function view(int|string \$id)
    {
        \$row = {$findCall};
        if (!is_object(\$row)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('{$table}/view', [
            'title' => 'Dettaglio',
            'row' => \$row,
            'children' => {$childrenCall},
        ]);
    }

    public function create()
    {
        return view('{$table}/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => {$optionsCall},
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
            {$createCall}
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string \$id)
    {
        \$row = {$findCall};
        if (!is_object(\$row)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('{$table}/edit', [
            'title' => 'Modifica record',
            'row' => \$row,
            'errors' => session('errors') ?? [],
            'options' => {$optionsCall},
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
            {$updateCall}
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string \$id)
    {
        try {
            {$deleteCall}
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}'))->with('error', \$e->getMessage());
        }
        return redirect()->to(site_url('{$table}'))->with('message', 'Record eliminato correttamente.');
    }

{$softMethods}    private function sanitizeInput(array \$data, bool \$isUpdate): array
    {
        unset(\$data['_submission_token']);
        \$csrfName = csrf_token();
        if (\$csrfName !== '') {
            unset(\$data[\$csrfName]);
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
        return \$data;
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
