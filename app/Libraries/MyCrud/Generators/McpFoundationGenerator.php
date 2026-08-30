<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Generates the per-table MCP contract.
 *
 * Foundation:
 * - manifest schema-driven;
 * - no direct database access;
 * - no write tool;
 * - no mandatory runtime dependency on mcp/sdk.
 */
final class McpFoundationGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) ($config['table'] ?? '');
        $mcp = (array) ($config['mcp'] ?? []);

        if (empty($mcp['enabled']) || (string) ($config['architecture'] ?? '') !== 'full') {
            return [];
        }

        $readable = [];
        $writable = [];

        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $ui = (array) ($field['ui'] ?? []);
            $attributes = (array) ($field['attributes']['boolean'] ?? []);
            $primaryAuto = !empty($field['primary']) && !empty($field['autoIncrement']);
            $managed = !empty($field['databaseManaged']);
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));

            if (!empty($ui['mcpVisible'])) {
                $readable[$name] = $this->fieldDescriptor($field);
            }

            if (
                !$primaryAuto
                && !$managed
                && !in_array($inputType, ['file', 'image'], true)
                && !empty($ui['visibleForm'])
                && !in_array('readonly', $attributes, true)
                && !in_array('disabled', $attributes, true)
            ) {
                $writable[$name] = $this->fieldDescriptor($field);
            }
        }

        $belongsTo = [];
        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $field => $relation) {
            $belongsTo[(string) $field] = [
                'parentTable' => (string) ($relation['parentTable'] ?? ''),
                'parentKey' => (string) ($relation['parentKey'] ?? ''),
                'displayField' => (string) ($relation['displayField'] ?? ''),
                'alias' => (string) ($relation['alias'] ?? ''),
            ];
        }

        $mcpCapabilities = (array) ($mcp['capabilities'] ?? []);
        $toolNames = [];
        if (!empty($mcpCapabilities['list'])) {
            $toolNames[] = 'list_' . strtolower(preg_replace('/[^a-zA-Z0-9_.-]+/', '_', $table));
        }
        if (!empty($mcpCapabilities['read'])) {
            $toolNames[] = 'get_' . strtolower(preg_replace('/[^a-zA-Z0-9_.-]+/', '_', $table));
        }

        if (!empty($mcpCapabilities['relations'])) {
            $relationToolGenerator = new McpRelationToolGenerator();
            $toolNames = array_merge($toolNames, $relationToolGenerator->toolNames($config));
        }
        $toolNames = array_values(array_unique($toolNames));

        $manifest = [
            'format' => 'myCrudCI4-mcp-foundation',
            'formatVersion' => 1,
            'targetProtocol' => '2026-07-28',
            'sdk' => [
                'package' => 'mcp/sdk',
                'requiredForRuntime' => true,
                'status' => 'optional',
            ],
            'server' => [
                'name' => (string) ($mcp['serverName'] ?? 'myCrudCI4'),
                'transport' => 'stdio',
                'mode' => 'read_only',
            ],
            'security' => [
                'boundary' => 'local_process',
                'inheritsApiSecurity' => false,
                'remoteTransportAllowed' => false,
                'oauthRequiredForRemote' => true,
                'fieldPolicy' => 'mcpVisible',
            ],
            'resource' => [
                'table' => $table,
                'primaryKey' => (string) ($config['primaryKey'] ?? ''),
                'serviceClass' => 'App\\Services\\' . (string) ($config['classes']['service'] ?? ''),
                'readOnlySchema' => !empty($config['features']['readOnly']),
            ],
            'fields' => [
                'readable' => $readable,
                'futureWritable' => $writable,
            ],
            'relations' => [
                'belongsTo' => $belongsTo,
                'hasMany' => array_values(array_map(
                    static fn (array $relation): array => [
                        'childTable' => (string) ($relation['childTable'] ?? ''),
                        'foreignKey' => (string) ($relation['foreignKey'] ?? ''),
                    ],
                    (array) ($config['relations']['hasMany'] ?? [])
                )),
            ],
            'api' => [
                'capabilities' => (array) ($config['apiCapabilities'] ?? []),
                'security' => (array) ($config['apiSecurity'] ?? []),
            ],
            'mcp' => [
                'enabled' => true,
                'capabilities' => $mcpCapabilities,
                'toolsGenerated' => $toolNames !== [],
                'tools' => $toolNames,
                'resourcesGenerated' => false,
                'promptsGenerated' => false,
                'nextStep' => '2.9.0_stable_consolidation',
            ],
        ];

        $json = json_encode(
            $manifest,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        ) . PHP_EOL;

        return [
            'manifest' => $this->writeGenerated(
                'Generated/Mcp/Manifests/' . $table . '.json',
                $json,
                $force
            ),
            'readme' => $this->writeGenerated(
                'Generated/Mcp/README.md',
                $this->readme(),
                $force
            ),
        ];
    }

    /** @return array<string,mixed> */
    private function fieldDescriptor(array $field): array
    {
        return [
            'type' => strtolower((string) ($field['type'] ?? 'string')),
            'columnType' => strtolower((string) ($field['columnType'] ?? '')),
            'nullable' => !empty($field['nullable']),
            'primary' => !empty($field['primary']),
            'foreignKey' => !empty($field['foreignKey']),
            'inputType' => (string) ($field['inputType'] ?? 'text'),
            'maxLength' => isset($field['maxLength']) ? (int) $field['maxLength'] : null,
        ];
    }

    private function readme(): string
    {
        return <<<'MD'
# myCrudCI4 MCP Foundation

This directory contains generated MCP foundation manifests.

Generated MCP resources expose **read-only CRUD tools** (`list_*`, `get_*`) when enabled.

Principles:

- MCP never queries the database directly.
- Future MCP tools call the generated Service layer.
- STDIO is the initial transport.
- MCP starts read-only.
- `mcp/sdk` is optional until MCP runtime is enabled.
- The manifest targets MCP protocol `2026-07-28`.
- Write tools are still disabled.
- Relation-aware read tools are available when enabled by the generated contract.

Published manifests live under:

`app/Mcp/Manifests/`
MD;
    }
}
