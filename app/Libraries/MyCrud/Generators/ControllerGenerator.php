<?php

namespace App\Libraries\MyCrud\Generators;

class ControllerGenerator
{
    use GeneratorTrait;

    public function generate(
        array $config,
        bool $force = false
    ): array {
        $table       = $config['table'];
        $primaryKey  = $config['primaryKey'];
        $controller  = $config['classes']['controller'];
        $model       = $config['classes']['model'];
        $service     = $config['classes']['service'];
        $rules       = $config['classes']['rules'];
        $usesService = !empty($config['features']['service']);

        /*
         * Dipendenza principale del Controller.
         */
        $dependencyUse = $usesService
            ? "use App\\Services\\{$service};"
            : "use App\\Models\\{$model};";

        $propertyType = $usesService
            ? $service
            : $model;

        $propertyName = $usesService
            ? 'service'
            : 'model';

        $construct = $usesService
            ? "\$this->service = new {$service}();"
            : "\$this->model = new {$model}();";

        /*
         * Chiamate variabili in base all'architettura.
         */
        $findCall = $usesService
            ? "\$this->service->find(\$id)"
            : "\$this->model->getDetail(\$id)";

        $createCall = $usesService
            ? "\$this->service->create(\$data)"
            : "\$this->model->insert(\$data, true)";

        $updateCall = $usesService
            ? "\$this->service->update(\$id, \$data)"
            : "\$this->model->update(\$id, \$data)";

        $deleteCall = $usesService
            ? "\$this->service->delete(\$id)"
            : "\$this->model->delete(\$id)";

        /*
         * Espressione che restituisce il Model.
         */
        $datatableModel = $usesService
            ? "\$this->service->model()"
            : "\$this->model";

        /*
         * Caricamento opzioni delle foreign key.
         */
        $optionLoads = '';

        foreach (
            $config['relations']['belongsTo'] ?? []
            as $field => $relation
        ) {
            $parentTable = $relation['parentTable'];
            $parentKey   = $relation['parentKey'];
            $display     = $relation['displayField'];

            $optionLoads .= <<<PHP
        \$rows = db_connect()
            ->table('{$parentTable}')
            ->select([
                '{$parentKey}',
                '{$display}',
            ])
            ->orderBy('{$display}', 'ASC')
            ->get()
            ->getResult();

        \$options['{$field}'] = [];

        foreach (\$rows as \$option) {
            \$options['{$field}'][
                (string) \$option->{$parentKey}
            ] = (string) \$option->{$display};
        }

PHP;
        }

        /*
         * Elenco campi DB.
         */
        $fields = array_values(
            array_map(
                static fn (array $field): string =>
                    $field['name'],
                $config['fields']
            )
        );

        $fieldsCode = var_export($fields, true);

        /*
         * Campi disabled e readonly.
         */
        $disabledFields = [];
        $readonlyFields = [];

        foreach ($config['fields'] as $field) {
            $boolean = $field['attributes']['boolean'] ?? [];

            if (in_array('disabled', $boolean, true)) {
                $disabledFields[] = $field['name'];
            }

            if (in_array('readonly', $boolean, true)) {
                $readonlyFields[] = $field['name'];
            }
        }

        $disabledFieldsCode = var_export(
            $disabledFields,
            true
        );

        $readonlyFieldsCode = var_export(
            $readonlyFields,
            true
        );

        /*
         * Soft delete opzionale.
         */
        $softDeleteEnabled = !empty(
            $config['features']['softDeletes']
        );

        $trashMethods = '';

        if ($softDeleteEnabled) {
            $deletedField = $config['softDelete']['field']
                ?? 'deleted_at';

            $deletedListCall = $usesService
                ? "\$this->service->deletedList()"
                : "\$this->model->getDeletedList()";

            $restoreCall = $usesService
                ? "\$this->service->restore(\$id)"
                : "\$this->restoreWithModel(\$id)";

            $forceDeleteCall = $usesService
                ? "\$this->service->forceDelete(\$id)"
                : "\$this->forceDeleteWithModel(\$id)";

            $trashMethods = <<<PHP

    public function trash()
    {
        \$rows = {$deletedListCall};

        return view('{$table}/trash', [
            'title'        => 'Cestino',
            'rows'         => \$rows,
            'primaryKey'   => '{$primaryKey}',
            'deletedField' => '{$deletedField}',
        ]);
    }

    public function restore(int|string \$id)
    {
        try {
            {$restoreCall};
        } catch (Throwable \$e) {
            return redirect()
                ->to(site_url('{$table}/trash'))
                ->with(
                    'error',
                    \$e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('{$table}/trash'))
            ->with(
                'message',
                'Record ripristinato correttamente.'
            );
    }

    public function forceDelete(int|string \$id)
    {
        try {
            {$forceDeleteCall};
        } catch (Throwable \$e) {
            return redirect()
                ->to(site_url('{$table}/trash'))
                ->with(
                    'error',
                    \$e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('{$table}/trash'))
            ->with(
                'message',
                'Record eliminato definitivamente.'
            );
    }

PHP;

            if (!$usesService) {
                $trashMethods .= <<<PHP
    private function restoreWithModel(
        int|string \$id
    ): void {
        if (!\$this->model->restoreRecord(\$id)) {
            throw new \RuntimeException(
                'Ripristino non riuscito.'
            );
        }
    }

    private function forceDeleteWithModel(
        int|string \$id
    ): void {
        if (!\$this->model->delete(\$id, true)) {
            throw new \RuntimeException(
                'Eliminazione definitiva non riuscita.'
            );
        }
    }

PHP;
            }
        }

        /*
         * Codice completo del Controller generato.
         */
        $hasManyConfig = $config['relationsConfig']['hasMany'] ?? [];
        $hasManyConfigCode = var_export($hasManyConfig, true);

        $childrenLoadCode = $usesService
            ? "\$children = \$this->service->loadHasMany(\$id, \$hasManyConfig);"
            : "foreach (\$hasManyConfig as \$relationKey => \$relation) {
"
                . "            if (empty(\$relation['enabled'])) { continue; }
"
                . "            \$rows = \$this->model->getRelatedChildren((string) \$relation['childTable'], (string) \$relation['foreignKey'], \$id, (string) \$relation['primaryKey'], (int) (\$relation['limit'] ?? 20));
"
                . "            \$count = !empty(\$relation['showCount']) ? \$this->model->countRelatedChildren((string) \$relation['childTable'], (string) \$relation['foreignKey'], \$id) : count(\$rows);
"
                . "            \$children[\$relationKey] = ['rows' => \$rows, 'count' => \$count];
"
                . "        }";

        $content = <<<PHP
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
{$dependencyUse}
use App\Validation\\{$rules};
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class {$controller} extends BaseController
{
    private {$propertyType} \${$propertyName};

    public function __construct()
    {
        helper([
            'form',
            'url',
        ]);

        {$construct}
    }

    /**
     * Elenco principale.
     */
    public function index()
    {
        return view('{$table}/index', [
            'title'      => '{$table}',
            'fields'     => {$fieldsCode},
            'primaryKey' => '{$primaryKey}',
        ]);
    }

    /**
     * Endpoint DataTables server-side.
     */
    public function datatable()
    {
        \$post = \$this->request->getPost();

        \$draw = (int) (
            \$post['draw']
            ?? 1
        );

        \$start = max(
            0,
            (int) (
                \$post['start']
                ?? 0
            )
        );

        \$length = (int) (
            \$post['length']
            ?? 25
        );

        \$length = \$length < 1
            ? 25
            : min(\$length, 500);

        \$search = trim(
            (string) (
                \$post['search']['value']
                ?? ''
            )
        );

        \$fields = {$fieldsCode};

        \$model = {$datatableModel};

        \$builder = \$model->datatableBuilder();

        /*
         * Ricerca globale.
         */
        if (\$search !== '') {
            \$builder->groupStart();

            foreach (\$fields as \$field) {
                \$builder->orLike(
                    '{$table}.' . \$field,
                    \$search
                );
            }

            \$builder->groupEnd();
        }

        /*
         * Filtri per colonna.
         */
        foreach (
            (array) (
                \$post['columns']
                ?? []
            )
            as \$index => \$column
        ) {
            \$value = trim(
                (string) (
                    \$column['search']['value']
                    ?? ''
                )
            );

            if (
                \$value !== ''
                && isset(\$fields[\$index])
            ) {
                \$builder->like(
                    '{$table}.' . \$fields[\$index],
                    \$value
                );
            }
        }

        \$recordsTotal = \$model->countAll();

        \$recordsFiltered = (
            clone \$builder
        )->countAllResults(false);

        /*
         * Ordinamento.
         */
        \$orderIndex = (int) (
            \$post['order'][0]['column']
            ?? 0
        );

        \$orderField = \$fields[\$orderIndex]
            ?? '{$primaryKey}';

        \$orderDir = strtolower(
            (string) (
                \$post['order'][0]['dir']
                ?? 'asc'
            )
        ) === 'desc'
            ? 'DESC'
            : 'ASC';

        \$rows = \$builder
            ->orderBy(
                '{$table}.' . \$orderField,
                \$orderDir
            )
            ->limit(
                \$length,
                \$start
            )
            ->get()
            ->getResult();

        return \$this->response->setJSON([
            'draw'            => \$draw,
            'recordsTotal'    => \$recordsTotal,
            'recordsFiltered' => \$recordsFiltered,
            'data'            => \$rows,
        ]);
    }

    /**
     * Dettaglio record.
     */
    public function view(int|string \$id)
    {
        \$row = {$findCall};

        if (!is_object(\$row)) {
            throw PageNotFoundException::forPageNotFound(
                'Record non trovato.'
            );
        }

        \$hasManyConfig = {$hasManyConfigCode};
        \$children = [];

        if (!empty(\$hasManyConfig)) {
            {$childrenLoadCode}
        }

        return view('{$table}/view', [
            'title' => 'Dettaglio',
            'row' => \$row,
            'children' => \$children,
            'hasManyConfig' => \$hasManyConfig,
        ]);
    }

    public function create()
    {
        \$submissionToken =
            \$this->createSubmissionToken(
                'store'
            );

        return view('{$table}/create', [
            'title'           => 'Nuovo record',
            'row'             => null,
            'errors'          => session('errors') ?? [],
            'options'         => \$this->relationOptions(),
            'submissionToken' => \$submissionToken,
        ]);
    }

    /**
     * Salvataggio nuovo record.
     */
    public function store()
    {
        if (
            !\$this->consumeSubmissionToken(
                'store'
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Il form è già stato inviato oppure è scaduto.'
                );
        }

        if (
            !\$this->validate(
                {$rules}::createRules(),
                {$rules}::messages()
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    \$this->validator->getErrors()
                );
        }

        \$data = \$this->sanitizeInput(
            \$this->request->getPost(),
            false
        );

        unset(
            \$data['{$primaryKey}']
        );

        try {
            {$createCall};
        } catch (Throwable \$e) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    \$e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('{$table}'))
            ->with(
                'message',
                'Record creato correttamente.'
            );
    }

    /**
     * Form modifica.
     */
    public function edit(int|string \$id)
    {
        \$row = {$findCall};

        if (!is_object(\$row)) {
            throw PageNotFoundException::forPageNotFound(
                'Record non trovato.'
            );
        }

        \$submissionToken =
            \$this->createSubmissionToken(
                'update_' . (string) \$id
            );

        return view('{$table}/edit', [
            'title'           => 'Modifica record',
            'row'             => \$row,
            'errors'          => session('errors') ?? [],
            'options'         => \$this->relationOptions(),
            'submissionToken' => \$submissionToken,
        ]);
    }

    /**
     * Aggiornamento record.
     */
    public function update(int|string \$id)
    {
        if (
            !\$this->consumeSubmissionToken(
                'update_' . (string) \$id
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Il form è già stato inviato oppure è scaduto.'
                );
        }

        if (
            !\$this->validate(
                {$rules}::updateRules(\$id),
                {$rules}::messages()
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    \$this->validator->getErrors()
                );
        }

        \$data = \$this->sanitizeInput(
            \$this->request->getPost(),
            true
        );

        unset(
            \$data['{$primaryKey}']
        );

        try {
            {$updateCall};
        } catch (Throwable \$e) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    \$e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('{$table}'))
            ->with(
                'message',
                'Record aggiornato correttamente.'
            );
    }

    /**
     * Eliminazione normale o soft delete.
     */
    public function delete(int|string \$id)
    {
        try {
            {$deleteCall};
        } catch (Throwable \$e) {
            return redirect()
                ->to(site_url('{$table}'))
                ->with(
                    'error',
                    \$e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('{$table}'))
            ->with(
                'message',
                'Record eliminato correttamente.'
            );
    }
{$trashMethods}
    /**
     * Rimuove campi tecnici, disabled e readonly.
     */
    private function sanitizeInput(
        array \$data,
        bool \$isUpdate
    ): array {
        unset(
            \$data['_submission_token']
        );

        \$csrfName = csrf_token();

        if (\$csrfName !== '') {
            unset(
                \$data[\$csrfName]
            );
        }

        \$disabledFields =
            {$disabledFieldsCode};

        \$readonlyFields =
            {$readonlyFieldsCode};

        foreach (
            \$disabledFields
            as \$field
        ) {
            unset(
                \$data[\$field]
            );
        }

        /*
         * I readonly sono esclusi dall'update
         * perché il valore inviato dal browser
         * può essere comunque alterato.
         */
        if (\$isUpdate) {
            foreach (
                \$readonlyFields
                as \$field
            ) {
                unset(
                    \$data[\$field]
                );
            }
        }

        return \$data;
    }

    /**
     * Crea un token monouso contro il doppio invio.
     */
    private function createSubmissionToken(
        string \$action
    ): string {
        \$token = bin2hex(
            random_bytes(16)
        );

        \$sessionKey =
            'mycrud_submission_'
            . \$action
            . '_'
            . \$token;

        session()->set(
            \$sessionKey,
            true
        );

        return \$token;
    }

    /**
     * Consuma il token.
     *
     * Lo stesso form non può essere inviato due volte.
     */
    private function consumeSubmissionToken(
        string \$action
    ): bool {
        \$token = trim(
            (string) \$this->request->getPost(
                '_submission_token'
            )
        );

        if (\$token === '') {
            return false;
        }

        \$sessionKey =
            'mycrud_submission_'
            . \$action
            . '_'
            . \$token;

        if (!session()->has(\$sessionKey)) {
            return false;
        }

        session()->remove(
            \$sessionKey
        );

        return true;
    }

    /**
     * Opzioni per le relazioni belongsTo.
     */
    private function relationOptions(): array
    {
        \$options = [];

{$optionLoads}
        return \$options;
    }
}

PHP;

        return $this->writeGenerated(
            "Controllers/{$controller}.php",
            $content,
            $force
        );
    }
}