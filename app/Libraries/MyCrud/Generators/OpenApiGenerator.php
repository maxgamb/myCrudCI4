<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/** Genera OpenAPI 3 allineata a Resource, filtri e payload dell'API. */
final class OpenApiGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $pk = (string) $config['primaryKey'];
        $softDeleteField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $readOnly = !empty($config['features']['readOnly']);
        $isView = !empty($config['isView']);
        $recordDetail = !empty($config['features']['recordDetail']);
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        $readFields = [];
        $writeFields = [];
        $filterFields = [];
        $sortableFields = [];
        $createRequired = [];
        $updateRequired = [];

        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $ui = (array) ($field['ui'] ?? []);
            $attributes = (array) ($field['attributes']['boolean'] ?? []);
            $primaryAuto = !empty($field['primary']) && !empty($field['autoIncrement']);
            $managedField = !empty($field['databaseManaged'])
                || (!empty($config['features']['softDeletes']) && $name === $softDeleteField)
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true));
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            $apiVisible = !array_key_exists('apiVisible', $ui) || !empty($ui['apiVisible']);
            $writable = !$readOnly && !$primaryAuto
                && !$managedField
                && !empty($ui['visibleForm'])
                && !in_array('disabled', $attributes, true)
                && !in_array('readonly', $attributes, true);

            if ($apiVisible) {
                $readFields[$name] = $field;
            }

            if ($writable) {
                $writeFields[$name] = $field;

                $required = empty($field['nullable'])
                    && ($field['default'] ?? null) === null
                    && !in_array('disabled', $attributes, true);

                if ($required) {
                    $createRequired[] = $name;
                    if (strtolower((string) ($field['inputType'] ?? 'text')) !== 'password') {
                        $updateRequired[] = $name;
                    }
                }
            }

            if (!empty($ui['searchable']) && ($indexEligible || $isView)) {
                $filterFields[$name] = $field;
            }

            if (!empty($ui['sortable']) && ($indexEligible || $isView)) {
                $sortableFields[] = $name;
            }
        }

        if (isset($config['fields'][$pk]) && !isset($readFields[$pk])) {
            $readFields = [$pk => $config['fields'][$pk]] + $readFields;
        }
        if (!in_array($pk, $sortableFields, true)) {
            array_unshift($sortableFields, $pk);
        }

        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            $fieldUi = (array) ($config['fields'][$fieldName]['ui'] ?? []);
            if (array_key_exists('apiVisible', $fieldUi) && empty($fieldUi['apiVisible'])) {
                continue;
            }

            $alias = (string) ($relation['alias'] ?? '');
            if ($alias !== '') {
                $readFields[$alias] = [
                    'name' => $alias,
                    'type' => 'varchar',
                    'columnType' => 'varchar',
                    'nullable' => true,
                    'inputType' => 'text',
                ];
            }
        }

        if ($readOnly) {
            return $this->generateReadOnly($config, $readFields, $filterFields, $sortableFields, $recordDetail, $force);
        }

        $resourceName = $this->schemaName($table, 'Read');
        $createName = $this->schemaName($table, 'Create');
        $updateName = $this->schemaName($table, 'Update');
        $patchName = $this->schemaName($table, 'Patch');
        $listName = $this->schemaName($table, 'ListResponse');
        $createdName = $this->schemaName($table, 'CreatedResponse');

        $lines = [
            'openapi: 3.0.3',
            'info:',
            '  title: ' . $this->yamlScalar($table . ' API'),
            '  version: 1.0.0',
            'paths:',
            '  /api/v1/' . $table . ':',
            '    get:',
            '      summary: ' . $this->yamlScalar('Elenco ' . $table),
            '      parameters:',
            '        - name: page',
            '          in: query',
            '          schema: { type: integer, minimum: 1 }',
            '        - name: perPage',
            '          in: query',
            '          schema: { type: integer, minimum: 1, maximum: 100 }',
        ];

        foreach ($filterFields as $name => $field) {
            [$type, $format] = $this->openApiType($field);
            $lines[] = '        - name: ' . $this->yamlScalar('filter[' . $name . ']');
            $lines[] = '          in: query';
            $lines[] = '          schema:';
            $lines[] = '            type: ' . $type;
            if ($format !== null) {
                $lines[] = '            format: ' . $format;
            }
        }

        $sortEnum = implode(', ', array_map([$this, 'yamlInlineScalar'], array_values(array_unique($sortableFields))));
        $lines = array_merge($lines, [
            '        - name: sort',
            '          in: query',
            '          schema: { type: string, enum: [' . $sortEnum . '] }',
            '        - name: direction',
            '          in: query',
            '          schema: { type: string, enum: [asc, desc] }',
            '      responses:',
            "        '200':",
            '          description: Elenco paginato',
            '          content:',
            '            application/json:',
            '              schema:',
            '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $listName),
            '    post:',
            '      summary: Crea record',
            '      requestBody:',
            '        required: true',
            '        content:',
            '          application/json:',
            '            schema:',
            '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $createName),
            '      responses:',
            "        '201':",
            '          description: Record creato',
            '          content:',
            '            application/json:',
            '              schema:',
            '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $createdName),
            "        '422': { description: Errore di validazione }",
            '  /api/v1/' . $table . '/{id}:',
            '    parameters:',
            '      - name: id',
            '        in: path',
            '        required: true',
            '        schema: { type: string }',
            '    get:',
            '      summary: Dettaglio record',
            '      responses:',
            "        '200':",
            '          description: Record trovato',
            '          content:',
            '            application/json:',
            '              schema:',
            '                type: object',
            '                properties:',
            '                  data:',
            '                    $ref: ' . $this->yamlScalar('#/components/schemas/' . $resourceName),
            "        '404': { description: Record non trovato }",
            '    put:',
            '      summary: Aggiornamento completo',
            '      requestBody:',
            '        required: true',
            '        content:',
            '          application/json:',
            '            schema:',
            '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $updateName),
            '      responses:',
            "        '200': { description: Record aggiornato }",
            "        '422': { description: Errore di validazione }",
            '    patch:',
            '      summary: Aggiornamento parziale',
            '      requestBody:',
            '        required: true',
            '        content:',
            '          application/json:',
            '            schema:',
            '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $patchName),
            '      responses:',
            "        '200': { description: Record aggiornato }",
            "        '422': { description: Errore di validazione }",
            '    delete:',
            '      summary: Elimina record',
            '      responses:',
            "        '204': { description: Record eliminato }",
            'components:',
            '  schemas:',
        ]);

        $lines = array_merge(
            $lines,
            $this->objectSchemaLines($resourceName, $readFields, []),
            $this->objectSchemaLines($createName, $writeFields, $createRequired),
            $this->objectSchemaLines($updateName, $writeFields, $updateRequired),
            $this->objectSchemaLines($patchName, $writeFields, []),
            [
                '    ' . $listName . ':',
                '      type: object',
                '      properties:',
                '        data:',
                '          type: array',
                '          items:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $resourceName),
                '        meta: { type: object }',
                '        links: { type: object }',
                '    ' . $createdName . ':',
                '      type: object',
                '      properties:',
                '        data:',
                '          type: object',
                '          properties:',
                '            ' . $this->yamlKey($pk) . ':',
                ...$this->propertyTypeLines($config['fields'][$pk] ?? ['type' => 'string'], 14),
                '        meta: { type: object }',
                '        links: { type: object }',
            ]
        );

        return $this->writeGenerated(
            'Generated/OpenApi/' . $table . '.yaml',
            implode("\n", $lines) . "\n",
            $force
        );
    }

    /** @param array<string,array> $fields @param list<string> $required */
    private function objectSchemaLines(string $name, array $fields, array $required): array
    {
        $lines = [
            '    ' . $name . ':',
            '      type: object',
        ];

        if ($required !== []) {
            $lines[] = '      required:';
            foreach (array_values(array_unique($required)) as $field) {
                $lines[] = '        - ' . $this->yamlScalar($field);
            }
        }

        if ($fields === []) {
            $lines[] = '      properties: {}';
            return $lines;
        }

        $lines[] = '      properties:';

        foreach ($fields as $fieldName => $field) {
            $lines[] = '        ' . $this->yamlKey((string) $fieldName) . ':';
            array_push($lines, ...$this->propertyTypeLines($field, 10));
        }

        return $lines;
    }

    /** @return list<string> */
    private function propertyTypeLines(array $field, int $indent): array
    {
        [$type, $format] = $this->openApiType($field);
        $prefix = str_repeat(' ', $indent);
        $lines = [$prefix . 'type: ' . $type];

        if ($format !== null) {
            $lines[] = $prefix . 'format: ' . $format;
        }
        if (!empty($field['nullable'])) {
            $lines[] = $prefix . 'nullable: true';
        }
        if (!empty($field['maxLength']) && $type === 'string') {
            $lines[] = $prefix . 'maxLength: ' . (int) $field['maxLength'];
        }

        return $lines;
    }

    /** @return array{0:string,1:?string} */
    private function openApiType(array $field): array
    {
        $type = strtolower((string) ($field['columnType'] ?? $field['type'] ?? 'string'));
        $inputType = strtolower((string) ($field['inputType'] ?? 'text'));

        if ($inputType === 'password') {
            return ['string', 'password'];
        }
        if (preg_match('/bool|tinyint\s*\(\s*1\s*\)/', $type)) {
            return ['boolean', null];
        }
        if (preg_match('/bigint/', $type)) {
            return ['integer', 'int64'];
        }
        if (preg_match('/(?:smallint|mediumint|tinyint|\bint\b|integer)/', $type)) {
            return ['integer', 'int32'];
        }
        if (preg_match('/decimal|numeric|float|double|real/', $type)) {
            return ['number', preg_match('/float/', $type) ? 'float' : 'double'];
        }
        if (preg_match('/datetime|timestamp/', $type)) {
            return ['string', 'date-time'];
        }
        if (preg_match('/\bdate\b/', $type)) {
            return ['string', 'date'];
        }
        if (preg_match('/binary|blob/', $type)) {
            return ['string', 'byte'];
        }

        return ['string', null];
    }

    private function generateReadOnly(
        array $config,
        array $readFields,
        array $filterFields,
        array $sortableFields,
        bool $recordDetail,
        bool $force
    ): array {
        unset($recordDetail);
        $table = (string) $config['table'];
        $resourceName = $this->schemaName($table, 'Read');
        $listName = $this->schemaName($table, 'ListResponse');
        $lines = [
            'openapi: 3.0.3',
            'info:',
            '  title: ' . $this->yamlScalar($table . ' API'),
            '  version: 1.0.0',
            'paths:',
            '  /api/v1/' . $table . ':',
            '    get:',
            '      summary: ' . $this->yamlScalar('Elenco read-only ' . $table),
            '      parameters:',
            '        - name: page',
            '          in: query',
            '          schema: { type: integer, minimum: 1 }',
            '        - name: perPage',
            '          in: query',
            '          schema: { type: integer, minimum: 1, maximum: 100 }',
        ];

        foreach ($filterFields as $name => $field) {
            [$type, $format] = $this->openApiType($field);
            $lines[] = '        - name: ' . $this->yamlScalar('filter[' . $name . ']');
            $lines[] = '          in: query';
            $lines[] = '          schema:';
            $lines[] = '            type: ' . $type;
            if ($format !== null) {
                $lines[] = '            format: ' . $format;
            }
        }

        $sortEnum = implode(', ', array_map([$this, 'yamlInlineScalar'], array_values(array_unique($sortableFields))));
        $lines = array_merge($lines, [
            '        - name: sort',
            '          in: query',
            '          schema: { type: string, enum: [' . $sortEnum . '] }',
            '        - name: direction',
            '          in: query',
            '          schema: { type: string, enum: [asc, desc] }',
            '      responses:',
            "        '200':",
            '          description: Elenco paginato read-only',
            '          content:',
            '            application/json:',
            '              schema:',
            '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $listName),
            'components:',
            '  schemas:',
        ]);

        $lines = array_merge(
            $lines,
            $this->objectSchemaLines($resourceName, $readFields, []),
            [
                '    ' . $listName . ':',
                '      type: object',
                '      properties:',
                '        data:',
                '          type: array',
                '          items:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $resourceName),
                '        meta: { type: object }',
                '        links: { type: object }',
            ]
        );

        return $this->writeGenerated(
            'Generated/OpenApi/' . $table . '.yaml',
            implode("\n", $lines) . "\n",
            $force
        );
    }

    private function schemaName(string $table, string $suffix): string
    {
        $parts = preg_split('/[^a-zA-Z0-9]+/', $table) ?: [$table];
        $base = implode('', array_map(static fn (string $part): string => ucfirst(strtolower($part)), $parts));

        return ($base !== '' ? $base : 'Resource') . $suffix;
    }

    private function yamlKey(string $value): string
    {
        return $this->yamlScalar($value);
    }

    private function yamlScalar(string $value): string
    {
        return "'" . str_replace("'", "''", $value) . "'";
    }

    private function yamlInlineScalar(string $value): string
    {
        return $this->yamlScalar($value);
    }
}
