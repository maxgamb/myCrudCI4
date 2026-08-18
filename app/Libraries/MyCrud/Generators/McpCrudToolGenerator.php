<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Generates read-only MCP tools for a Full CRUD.
 *
 * Tool generati:
 * - list_<table>
 * - get_<table>
 *
 * No tool writes data. Read-only tools call the generated Model directly;
 * the Service layer is reserved for write use-cases.
 */
final class McpCrudToolGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) ($config['table'] ?? '');
        $mcp = (array) ($config['mcp'] ?? []);
        $caps = (array) ($mcp['capabilities'] ?? []);

        if (
            empty($mcp['enabled'])
            || (string) ($config['architecture'] ?? '') !== 'full'
            || (empty($caps['list']) && empty($caps['read']))
        ) {
            return [];
        }

        $studly = $this->studly($table);
        $class = $studly . 'Tools';
        $model = (string) ($config['classes']['model'] ?? ($studly . 'Model'));
        $resource = $studly . 'McpResource';

        // MCP query policy belongs to the Tool boundary, not to the output Resource.
        $filterable = [];
        $sortable = [];
        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }
            $ui = (array) ($field['ui'] ?? []);
            if (empty($ui['mcpVisible'])) {
                continue;
            }
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading'])
                || !empty($config['isView']);
            if (!empty($ui['searchable']) && $indexEligible) {
                $filterable[] = $name;
            }
            if (!empty($ui['sortable']) && $indexEligible) {
                $sortable[] = $name;
            }
        }
        $pk = (string) ($config['primaryKey'] ?? '');
        if ($pk !== '' && !in_array($pk, $sortable, true)) {
            array_unshift($sortable, $pk);
        }
        $filterableCode = var_export(array_values(array_unique($filterable)), true);
        $sortableCode = var_export(array_values(array_unique($sortable)), true);
        $queryPolicyConstants = !empty($caps['list'])
            ? "    private const FILTERABLE_FIELDS = {$filterableCode};\n    private const SORTABLE_FIELDS = {$sortableCode};\n\n"
            : '';

        $methods = [];

        if (!empty($caps['list'])) {
            $toolName = $this->toolName('list', $table);
            $methods[] = <<<PHP
    /**
     * Returns a paginated read-only list of {$table} records.
     *
     * Filtering and sorting are restricted to static Tool-boundary whitelists.
     *
     * @param int         \$page        Requested page, minimum 1.
     * @param int         \$perPage     Records per page, minimum 1 and maximum 100.
     * @param string|null \$filterField Filterable MCP field.
     * @param string|null \$filterValue Filter value.
     * @param string|null \$sort        Sortable MCP field.
     * @param string      \$direction   Sort direction: asc or desc.
     *
     * @return array{
     *     data: array<int,array<string,mixed>>,
     *     meta: array<string,mixed>,
     *     links: array<string,mixed>
     * }
     */
    #[McpTool(
        name: '{$toolName}',
        title: 'List {$table}'
    )]
    public function list{$studly}(
        int \$page = 1,
        int \$perPage = 25,
        ?string \$filterField = null,
        ?string \$filterValue = null,
        ?string \$sort = null,
        string \$direction = 'asc'
    ): array {
        \$page = max(1, \$page);
        \$perPage = max(1, min(100, \$perPage));

        \$filterable = self::FILTERABLE_FIELDS;
        \$sortable = self::SORTABLE_FIELDS;

        \$query = [
            'page' => \$page,
            'perPage' => \$perPage,
            'direction' => strtolower(\$direction) === 'desc' ? 'desc' : 'asc',
        ];

        if (\$filterField !== null && \$filterField !== '') {
            if (!in_array(\$filterField, \$filterable, true)) {
                throw new InvalidArgumentException(
                    'Filter not allowed. Available fields: ' . implode(', ', \$filterable)
                );
            }
            \$query['filter'] = [\$filterField => (string) (\$filterValue ?? '')];
        }

        if (\$sort !== null && \$sort !== '') {
            if (!in_array(\$sort, \$sortable, true)) {
                throw new InvalidArgumentException(
                    'Sorting not allowed. Available fields: ' . implode(', ', \$sortable)
                );
            }
            \$query['sort'] = \$sort;
        }

        \$result = \$this->model->apiList(\$query, \$filterable, \$sortable);

        return [
            'data' => {$resource}::collection(\$result['rows']),
            'meta' => \$result['meta'],
            'links' => \$result['links'],
        ];
    }

PHP;
        }

        if (!empty($caps['read'])) {
            $toolName = $this->toolName('get', $table);
            $methods[] = <<<PHP
    /**
     * Returns the read-only details of a {$table} record.
     *
     * @param string \$id Record primary key.
     *
     * @return array<string,mixed>
     */
    #[McpTool(
        name: '{$toolName}',
        title: 'Get {$table}'
    )]
    public function get{$studly}(string \$id): array
    {
        \$record = \$this->model->getDetail(\$id);
        if (!is_object(\$record)) {
            throw new InvalidArgumentException('Record not found.');
        }

        return {$resource}::make(\$record);
    }

PHP;
        }

        $methodsCode = implode("\n", $methods);

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\\Mcp\\Tools;

use App\\Mcp\\Resources\\{$resource};
use App\\Models\\{$model};
use InvalidArgumentException;
use Mcp\\Capability\\Attribute\\McpTool;

/**
 * MCP tools generated by myCrudCI4 for {$table}.
 *
 * Read-only by design; MCP projection is independent from REST.
 */
final class {$class}
{
{$queryPolicyConstants}    public function __construct(private readonly {$model} \$model = new {$model}())
    {
    }

{$methodsCode}}

PHP;

        return $this->writeGenerated(
            'Generated/Mcp/Tools/' . $class . '.php',
            $content,
            $force
        );
    }

    private function toolName(string $verb, string $table): string
    {
        $name = strtolower($verb . '_' . preg_replace('/[^a-zA-Z0-9_.-]+/', '_', $table));
        return substr($name, 0, 128);
    }

    private function studly(string $value): string
    {
        $parts = preg_split('/[^a-zA-Z0-9]+/', $value) ?: [$value];
        $result = implode('', array_map(
            static fn (string $part): string => ucfirst(strtolower($part)),
            $parts
        ));

        return $result !== '' ? $result : 'Crud';
    }
}
