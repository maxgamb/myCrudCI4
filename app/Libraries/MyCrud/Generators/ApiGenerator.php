<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/** Genera controller REST v1 e Resource di serializzazione. */
final class ApiGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $api = (string) $config['classes']['api'];
        $service = (string) $config['classes']['service'];
        $rules = (string) $config['classes']['apiRules'];
        $pk = (string) $config['primaryKey'];
        $resource = (string) ($config['classes']['resource'] ?? (preg_replace('/ApiController$/', 'Resource', $api) ?: $api . 'Resource'));
        $softDeleteField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        $readable = [];
        $writable = [];
        $filterable = [];
        $sortable = [];

        foreach ($config['fields'] as $field) {
            $name = (string) $field['name'];
            $ui = (array) ($field['ui'] ?? []);
            $attributes = (array) ($field['attributes']['boolean'] ?? []);
            $primaryAuto = !empty($field['primary']) && !empty($field['autoIncrement']);
            $managedField = (!empty($config['features']['softDeletes']) && $name === $softDeleteField)
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true));
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            // La visibilità API è una scelta esplicita del Builder e non viene
            // dedotta dal nome del campo.
            if (!array_key_exists('apiVisible', $ui) || !empty($ui['apiVisible'])) {
                $readable[] = $name;
            }

            // In assenza di una proprietà apiWritable dedicata, l'API accetta
            // gli stessi campi gestiti dal form web, esclusi quelli amministrati
            // dal framework o dichiarati readonly/disabled.
            if (
                !$primaryAuto
                && !$managedField
                && !empty($ui['visibleForm'])
                && !in_array('disabled', $attributes, true)
                && !in_array('readonly', $attributes, true)
            ) {
                $writable[] = $name;
            }

            if (!empty($ui['searchable']) && $indexEligible) {
                $filterable[] = $name;
            }
            if (!empty($ui['sortable']) && $indexEligible) {
                $sortable[] = $name;
            }
        }

        foreach ($config['relations']['belongsTo'] ?? [] as $fieldName => $relation) {
            $fieldUi = (array) ($config['fields'][$fieldName]['ui'] ?? []);
            $alias = (string) ($relation['alias'] ?? '');
            if ($alias !== '' && (!array_key_exists('apiVisible', $fieldUi) || !empty($fieldUi['apiVisible']))) {
                $readable[] = $alias;
            }
        }

        if (!in_array($pk, $readable, true)) {
            array_unshift($readable, $pk);
        }
        if (!in_array($pk, $sortable, true)) {
            $sortable[] = $pk;
        }

        $readableCode = var_export(array_values(array_unique($readable)), true);
        $writableCode = var_export(array_values(array_unique($writable)), true);
        $filterableCode = var_export(array_values(array_unique($filterable)), true);
        $sortableCode = var_export(array_values(array_unique($sortable)), true);

        $baseControllerContent = <<<'BASEAPI'
<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

/**
 * Base comune delle API generate.
 * Uniforma payload, errori e limiti di paginazione.
 */
abstract class BaseApiController extends BaseController
{
    protected int $maxPerPage = 100;

    protected function success(
        mixed $data,
        array $meta = [],
        array $links = [],
        int $status = 200
    ): ResponseInterface {
        return $this->response->setStatusCode($status)->setJSON([
            'data'  => $data,
            'meta'  => (object) $meta,
            'links' => (object) $links,
        ]);
    }

    protected function error(
        string $code,
        string $message,
        int $status,
        array $fields = []
    ): ResponseInterface {
        $error = [
            'code'    => $code,
            'message' => $message,
        ];

        if ($fields !== []) {
            $error['fields'] = $fields;
        }

        return $this->response
            ->setStatusCode($status)
            ->setJSON(['error' => $error]);
    }

    protected function payload(): array
    {
        $json = $this->request->getJSON(true);

        if (is_array($json)) {
            return $json;
        }

        $raw = $this->request->getRawInput();

        return is_array($raw) && $raw !== []
            ? $raw
            : (array) $this->request->getPost();
    }

    protected function safePerPage(int $default = 25): int
    {
        $requested = (int) ($this->request->getGet('perPage') ?? $default);

        return max(1, min($this->maxPerPage, $requested));
    }

    protected function internalError(Throwable $exception): ResponseInterface
    {
        log_message('error', '[API] {message} in {file}:{line}', [
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
        ]);

        return $this->error(
            'INTERNAL_ERROR',
            'Errore interno del server.',
            500
        );
    }
}

BASEAPI;

        $resourceContent = <<<PHP
<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa {$table} secondo la configurazione del Builder. */
final class {$resource}
{
    private const READABLE = {$readableCode};
    private const WRITABLE = {$writableCode};
    private const FILTERABLE = {$filterableCode};
    private const SORTABLE = {$sortableCode};

    public static function make(object|array \$record): array
    {
        if (is_array(\$record)) {
            \$source = \$record;
        } elseif (method_exists(\$record, 'toRawArray')) {
            \$source = \$record->toRawArray();
        } elseif (method_exists(\$record, 'toArray')) {
            \$source = \$record->toArray();
        } else {
            \$source = get_object_vars(\$record);
        }

        return array_intersect_key(\$source, array_flip(self::READABLE));
    }

    public static function collection(array \$records): array
    {
        return array_map(static fn (object|array \$record): array => self::make(\$record), \$records);
    }

    public static function writableData(array \$data): array
    {
        return array_intersect_key(\$data, array_flip(self::WRITABLE));
    }

    public static function filterableFields(): array
    {
        return self::FILTERABLE;
    }

    public static function sortableFields(): array
    {
        return self::SORTABLE;
    }
}

PHP;

        $softMethods = !empty($config['features']['softDeletes']) ? <<<PHP

    public function trash()
    {
        try {
            return \$this->success({$resource}::collection(\$this->service->deletedList()));
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

    public function restore(int|string \$id)
    {
        try {
            \$this->service->restore(\$id);
            return \$this->success(['{$pk}' => \$id, 'restored' => true]);
        } catch (RuntimeException \$e) {
            return \$this->error('RESTORE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

    public function forceDelete(int|string \$id)
    {
        try {
            \$this->service->forceDelete(\$id);
            return \$this->response->setStatusCode(204)->setBody('');
        } catch (RuntimeException \$e) {
            return \$this->error('DELETE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }
PHP : '';

        $resourceUse = "use App\\API\\Resources\\{$resource};";
        $serviceUse = "use App\\Services\\{$service};";
        $rulesUse = "use App\\Validation\\{$rules};";

        $controllerContent = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

{$resourceUse}
use App\Controllers\Api\BaseApiController;
{$serviceUse}
{$rulesUse}
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa {$table}. */
final class {$api} extends BaseApiController
{
    public function __construct(private readonly {$service} \$service = new {$service}())
    {
    }

    public function index()
    {
        try {
            \$query = (array) \$this->request->getGet();
            \$query['perPage'] = \$this->safePerPage();
            \$result = \$this->service->apiList(\$query, {$resource}::filterableFields(), {$resource}::sortableFields());
            return \$this->success({$resource}::collection(\$result['rows']), \$result['meta'], \$result['links']);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

    public function show(int|string \$id)
    {
        try {
            return \$this->success({$resource}::make(\$this->service->find(\$id)));
        } catch (RuntimeException) {
            return \$this->error('NOT_FOUND', 'Record non trovato.', 404);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

    public function create()
    {
        \$data = {$resource}::writableData(\$this->payload());
        if (\$data === []) {
            return \$this->error('EMPTY_PAYLOAD', 'Nessun campo scrivibile ricevuto.', 422);
        }
        if (!\$this->validateData(\$data, {$rules}::createRules(), {$rules}::messages())) {
            return \$this->error('VALIDATION_ERROR', 'Dati non validi.', 422, \$this->validator->getErrors());
        }
        try {
            \$id = \$this->service->create(\$data);
            return \$this->success(['{$pk}' => \$id], [], [], 201);
        } catch (RuntimeException \$e) {
            return \$this->error('CREATE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

    public function update(int|string \$id)
    {
        return \$this->writeUpdate(\$id, false);
    }

    public function patch(int|string \$id)
    {
        return \$this->writeUpdate(\$id, true);
    }

    private function writeUpdate(int|string \$id, bool \$partial)
    {
        \$data = {$resource}::writableData(\$this->payload());
        unset(\$data['{$pk}']);
        if (\$data === []) {
            return \$this->error('EMPTY_PAYLOAD', 'Nessun campo scrivibile ricevuto.', 422);
        }

        \$rules = {$rules}::updateRules(\$id);
        if (\$partial) {
            \$rules = array_intersect_key(\$rules, \$data);
        }
        if (\$rules !== [] && !\$this->validateData(\$data, \$rules, {$rules}::messages())) {
            return \$this->error('VALIDATION_ERROR', 'Dati non validi.', 422, \$this->validator->getErrors());
        }

        try {
            \$this->service->find(\$id);
            \$this->service->update(\$id, \$data);
            return \$this->success({$resource}::make(\$this->service->find(\$id)));
        } catch (RuntimeException \$e) {
            if (\$e->getMessage() === 'Record non trovato.') {
                return \$this->error('NOT_FOUND', 'Record non trovato.', 404);
            }
            return \$this->error('UPDATE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

    public function delete(int|string \$id)
    {
        try {
            \$this->service->find(\$id);
            \$this->service->delete(\$id);
            return \$this->response->setStatusCode(204)->setBody('');
        } catch (RuntimeException \$e) {
            if (\$e->getMessage() === 'Record non trovato.') {
                return \$this->error('NOT_FOUND', 'Record non trovato.', 404);
            }
            return \$this->error('DELETE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }{$softMethods}
}

PHP;

        return [
            'base_controller' => $this->writeGenerated(
                'Generated/Controllers/Api/BaseApiController.php',
                $baseControllerContent,
                $force
            ),
            'controller' => $this->writeGenerated(
                "Generated/Controllers/Api/V1/{$api}.php",
                $controllerContent,
                $force
            ),
            'resource' => $this->writeGenerated(
                "Generated/API/Resources/{$resource}.php",
                $resourceContent,
                $force
            ),
        ];
    }
}
