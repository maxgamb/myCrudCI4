<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Generates OpenAPI 3.0.3 aligned with generated REST routes and payloads
 * dall'architettura Full.
 */
final class OpenApiGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $pk = (string) $config['primaryKey'];
        $softDeleteField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $apiCaps = (array) ($config['apiCapabilities'] ?? []);
        $apiList = !empty($apiCaps['list']);
        $apiRead = !empty($apiCaps['read']);
        $apiCreate = !empty($apiCaps['create']);
        $apiUpdate = !empty($apiCaps['update']);
        $apiDelete = !empty($apiCaps['delete']);
        $apiTrash = !empty($apiCaps['trash']);
        $apiRestore = !empty($apiCaps['restore']);
        $apiForceDelete = !empty($apiCaps['forceDelete']);
        $apiSecurity = (array) ($config['apiSecurity'] ?? []);
        $shieldTokens = (string) ($apiSecurity['auth'] ?? 'none') === 'shield_tokens';
        $apiPermissions = (array) ($apiSecurity['permissions'] ?? []);
        $apiWritable = $apiCreate || $apiUpdate;
        $recordDetail = $apiRead || $apiUpdate || $apiDelete;
        $softDeleteEnabled = $apiTrash || $apiRestore || $apiForceDelete;
        $isView = !empty($config['isView']);
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        $readFields = [];
        $writeFields = [];
        $multipartFields = [];
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
                || ($softDeleteEnabled && $name === $softDeleteField)
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true));
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            $apiVisible = !array_key_exists('apiVisible', $ui) || !empty($ui['apiVisible']);
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $isUpload = in_array($inputType, ['file', 'image'], true);
            $writable = $apiWritable
                && !$primaryAuto
                && !$managedField
                && !empty($ui['visibleForm'])
                && !in_array('disabled', $attributes, true)
                && !in_array('readonly', $attributes, true);

            if ($apiVisible) {
                $readFields[$name] = $field;
            }

            if ($writable) {
                $multipartFields[$name] = $field;

                // JSON non può assegnare filename upload arbitrari: i file
                // vengono persistiti solo dal multipart runtime.
                if (!$isUpload) {
                    $writeFields[$name] = $field;
                }

                $required = empty($field['nullable'])
                    && ($field['default'] ?? null) === null
                    && !in_array('disabled', $attributes, true);

                if ($required) {
                    $createRequired[] = $name;

                    if ($inputType !== 'password') {
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

        $names = [
            'read' => $this->schemaName($table, 'Read'),
            'create' => $this->schemaName($table, 'Create'),
            'update' => $this->schemaName($table, 'Update'),
            'patch' => $this->schemaName($table, 'Patch'),
            'createMultipart' => $this->schemaName($table, 'CreateMultipart'),
            'updateMultipart' => $this->schemaName($table, 'UpdateMultipart'),
            'patchMultipart' => $this->schemaName($table, 'PatchMultipart'),
            'uploadMultipart' => $this->schemaName($table, 'UploadMultipart'),
            'response' => $this->schemaName($table, 'Response'),
            'listResponse' => $this->schemaName($table, 'ListResponse'),
            'createdResponse' => $this->schemaName($table, 'CreatedResponse'),
            'errorResponse' => $this->schemaName($table, 'ErrorResponse'),
        ];

        $tag = $this->schemaName($table, '');
        $operationBase = $tag !== '' ? $tag : 'Resource';
        $hasApiUploads = count($multipartFields) > count($writeFields);
        $uploadFields = array_diff_key($multipartFields, $writeFields);
        $uploadFieldNames = array_keys($uploadFields);
        $requiresCreateUpload = array_intersect($createRequired, $uploadFieldNames) !== [];

        $lines = [
            'openapi: 3.0.3',
            'info:',
            '  title: ' . $this->yamlScalar($table . ' API'),
            '  version: 1.0.0',
            '  description: ' . $this->yamlScalar('Generated by myCrudCI4 from the current database schema and persisted CRUD configuration.'),
            'tags:',
            '  - name: ' . $this->yamlScalar($tag),
            '    description: ' . $this->yamlScalar('Operations for ' . $table),
        ];

        if ($shieldTokens) {
            $lines[] = 'security:';
            $lines[] = '  - bearerAuth: []';
            $lines[] = 'x-mycrud-security:';
            $lines[] = '  authenticator: shield_tokens';
            $lines[] = '  permissions:';
            foreach ($apiPermissions as $capability => $permission) {
                $permission = strtolower(trim((string) $permission));
                if ($permission !== '') {
                    $lines[] = '    ' . $this->yamlKey((string) $capability) . ': ' . $this->yamlScalar($permission);
                }
            }
        }

        $lines[] = 'paths:';

        if ($apiList || $apiCreate) {
            $lines = array_merge(
                $lines,
                $this->collectionPathLines(
                    $table,
                    $tag,
                    $operationBase,
                    $filterFields,
                    $sortableFields,
                    $names,
                    $apiList,
                    $apiCreate,
                    $hasApiUploads,
                    $requiresCreateUpload
                )
            );
        }

        if ($recordDetail) {
            $lines = array_merge(
                $lines,
                $this->recordPathLines(
                    $table,
                    $pk,
                    $config['fields'][$pk] ?? ['type' => 'string'],
                    $tag,
                    $operationBase,
                    $names,
                    $apiRead,
                    $apiUpdate,
                    $apiDelete
                )
            );
        }

        if ($apiUpdate && $hasApiUploads) {
            $lines = array_merge(
                $lines,
                $this->uploadPathLines(
                    $table,
                    $pk,
                    $config['fields'][$pk] ?? ['type' => 'string'],
                    $tag,
                    $operationBase,
                    $names
                )
            );
        }

        if ($softDeleteEnabled) {
            $lines = array_merge(
                $lines,
                $this->softDeletePathLines(
                    $table,
                    $pk,
                    $config['fields'][$pk] ?? ['type' => 'string'],
                    $tag,
                    $operationBase,
                    $names,
                    $apiTrash,
                    $apiRestore,
                    $apiForceDelete
                )
            );
        }

        $lines[] = 'components:';
        if ($shieldTokens) {
            $lines[] = '  securitySchemes:';
            $lines[] = '    bearerAuth:';
            $lines[] = '      type: http';
            $lines[] = '      scheme: bearer';
            $lines[] = '      description: ' . $this->yamlScalar(
                'CodeIgniter Shield Personal Access Token sent in the Authorization header.'
            );
        }
        $lines[] = '  schemas:';

        $lines = array_merge(
            $lines,
            $this->objectSchemaLines($names['read'], $readFields, [], 'response')
        );

        $jsonCreateRequired = array_values(array_intersect($createRequired, array_keys($writeFields)));
        $jsonUpdateRequired = array_values(array_intersect($updateRequired, array_keys($writeFields)));

        if ($apiCreate) {
            $lines = array_merge(
                $lines,
                $this->objectSchemaLines($names['create'], $writeFields, $jsonCreateRequired, 'request')
            );
            if ($hasApiUploads) {
                $lines = array_merge(
                    $lines,
                    $this->objectSchemaLines($names['createMultipart'], $multipartFields, $createRequired, 'multipart')
                );
            }
        }
        if ($apiUpdate) {
            $lines = array_merge(
                $lines,
                $this->objectSchemaLines($names['update'], $writeFields, $jsonUpdateRequired, 'request'),
                $this->objectSchemaLines($names['patch'], $writeFields, [], 'request')
            );
            if ($hasApiUploads) {
                $lines = array_merge(
                    $lines,
                    $this->objectSchemaLines($names['uploadMultipart'], $uploadFields, [], 'multipart')
                );
            }
        }

        $lines = array_merge(
            $lines,
            $this->responseSchemaLines($names, $pk, $config['fields'][$pk] ?? ['type' => 'string'])
        );

        return $this->writeGenerated(
            'Generated/OpenApi/' . $table . '.yaml',
            implode("\n", $lines) . "\n",
            $force
        );
    }

    /** @return list<string> */
    private function collectionPathLines(
        string $table,
        string $tag,
        string $operationBase,
        array $filterFields,
        array $sortableFields,
        array $names,
        bool $apiList,
        bool $apiCreate,
        bool $hasApiUploads,
        bool $requiresCreateUpload
    ): array {
        $lines = ['  /api/v1/' . $table . ':'];

        if ($apiList) {
            $lines = array_merge($lines, [
                '    get:',
                '      tags: [' . $this->yamlInlineScalar($tag) . ']',
                '      operationId: list' . $operationBase,
                '      summary: ' . $this->yamlScalar('List ' . $table),
                '      parameters:',
                '        - name: page',
                '          in: query',
                '          schema: { type: integer, minimum: 1, default: 1 }',
                '        - name: perPage',
                '          in: query',
                '          schema: { type: integer, minimum: 1, maximum: 100, default: 25 }',
            ]);

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

            $sortableFields = array_values(array_unique(array_map('strval', $sortableFields)));
            $sortEnum = implode(', ', array_map([$this, 'yamlInlineScalar'], $sortableFields));
            $lines = array_merge($lines, [
                '        - name: sort',
                '          in: query',
                '          schema: { type: string, enum: [' . $sortEnum . '] }',
                '        - name: direction',
                '          in: query',
                '          schema: { type: string, enum: [asc, desc], default: asc }',
                '      responses:',
                "        '200':",
                '          description: Paginated list',
                '          content:',
                '            application/json:',
                '              schema:',
                '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['listResponse']),
                "        '500':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/InternalError'),
            ]);
        }

        if ($apiCreate) {
            $lines = array_merge($lines, [
                '    post:',
                '      tags: [' . $this->yamlInlineScalar($tag) . ']',
                '      operationId: create' . $operationBase,
                '      summary: ' . $this->yamlScalar('Create ' . $table . ' record'),
                '      requestBody:',
                '        required: true',
                '        content:',
            ]);
            if (!$requiresCreateUpload) {
                $lines = array_merge($lines, [
                    '          application/json:',
                    '            schema:',
                    '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['create']),
                ]);
            }
            if ($hasApiUploads) {
                $lines = array_merge($lines, [
                    '          multipart/form-data:',
                    '            schema:',
                    '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['createMultipart']),
                ]);
            }
            $lines = array_merge($lines, [
                '      responses:',
                "        '201':",
                '          description: Created',
                '          content:',
                '            application/json:',
                '              schema:',
                '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['createdResponse']),
                "        '400':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/BadRequest'),
                "        '422':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/ValidationError'),
                "        '500':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/InternalError'),
            ]);
        }

        return $lines;
    }

    /** @return list<string> */
    private function recordPathLines(
        string $table,
        string $pk,
        array $pkField,
        string $tag,
        string $operationBase,
        array $names,
        bool $apiRead,
        bool $apiUpdate,
        bool $apiDelete
    ): array {
        $lines = [
            '  /api/v1/' . $table . '/{id}:',
            '    parameters:',
            '      - name: id',
            '        in: path',
            '        required: true',
            '        schema:',
        ];
        array_push($lines, ...$this->propertyTypeLines($pkField, 10, 'path'));

        if ($apiRead) {
            $lines = array_merge($lines, [
                '    get:',
                '      tags: [' . $this->yamlInlineScalar($tag) . ']',
                '      operationId: get' . $operationBase,
                '      summary: ' . $this->yamlScalar('Get ' . $table . ' record'),
                '      responses:',
                "        '200':",
                '          description: Record found',
                '          content:',
                '            application/json:',
                '              schema:',
                '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['response']),
                "        '404':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/NotFound'),
                "        '500':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/InternalError'),
            ]);
        }

        if ($apiUpdate) {
            foreach ([
                'put' => ['update' . $operationBase, 'Replace/update ' . $table . ' record', $names['update']],
                'patch' => ['patch' . $operationBase, 'Partially update ' . $table . ' record', $names['patch']],
            ] as $method => [$operationId, $summary, $schema]) {
                $lines = array_merge($lines, [
                    '    ' . $method . ':',
                    '      tags: [' . $this->yamlInlineScalar($tag) . ']',
                    '      operationId: ' . $operationId,
                    '      summary: ' . $this->yamlScalar($summary),
                    '      requestBody:',
                    '        required: true',
                    '        content:',
                    '          application/json:',
                    '            schema:',
                    '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $schema),
                ]);
                $lines = array_merge($lines, [
                    '      responses:',
                    "        '200':",
                    '          description: Updated',
                    '          content:',
                    '            application/json:',
                    '              schema:',
                    '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['response']),
                    "        '400':",
                    '          $ref: ' . $this->yamlScalar('#/components/responses/BadRequest'),
                    "        '404':",
                    '          $ref: ' . $this->yamlScalar('#/components/responses/NotFound'),
                    "        '422':",
                    '          $ref: ' . $this->yamlScalar('#/components/responses/ValidationError'),
                    "        '500':",
                    '          $ref: ' . $this->yamlScalar('#/components/responses/InternalError'),
                ]);
            }
        }

        if ($apiDelete) {
            $lines = array_merge($lines, [
                '    delete:',
                '      tags: [' . $this->yamlInlineScalar($tag) . ']',
                '      operationId: delete' . $operationBase,
                '      summary: ' . $this->yamlScalar('Delete ' . $table . ' record'),
                '      responses:',
                "        '204': { description: Deleted }",
                "        '400':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/BadRequest'),
                "        '404':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/NotFound'),
                "        '500':",
                '          $ref: ' . $this->yamlScalar('#/components/responses/InternalError'),
            ]);
        }

        return $lines;
    }

    /** @return list<string> */
    private function uploadPathLines(
        string $table,
        string $pk,
        array $pkField,
        string $tag,
        string $operationBase,
        array $names
    ): array {
        $lines = [
            '  /api/v1/' . $table . '/{id}/upload:',
            '    parameters:',
            '      - name: id',
            '        in: path',
            '        required: true',
            '        schema:',
        ];
        array_push($lines, ...$this->propertyTypeLines($pkField, 10, 'path'));

        return array_merge($lines, [
            '    post:',
            '      tags: [' . $this->yamlInlineScalar($tag) . ']',
            '      operationId: upload' . $operationBase,
            '      summary: ' . $this->yamlScalar('Upload/replace files for ' . $table . ' record'),
            '      requestBody:',
            '        required: true',
            '        content:',
            '          multipart/form-data:',
            '            schema:',
            '              $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['uploadMultipart']),
            '      responses:',
            "        '200':",
            '          description: Upload stored and record updated',
            '          content:',
            '            application/json:',
            '              schema:',
            '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['response']),
            "        '400':",
            '          $ref: ' . $this->yamlScalar('#/components/responses/BadRequest'),
            "        '404':",
            '          $ref: ' . $this->yamlScalar('#/components/responses/NotFound'),
            "        '422':",
            '          $ref: ' . $this->yamlScalar('#/components/responses/ValidationError'),
            "        '500':",
            '          $ref: ' . $this->yamlScalar('#/components/responses/InternalError'),
        ]);
    }

    /** @return list<string> */
    private function softDeletePathLines(
        string $table,
        string $pk,
        array $pkField,
        string $tag,
        string $operationBase,
        array $names,
        bool $apiTrash,
        bool $apiRestore,
        bool $apiForceDelete
    ): array {
        $lines = [];

        if ($apiTrash) {
            $lines = array_merge($lines, [
                '  /api/v1/' . $table . '/trash:',
                '    get:',
                '      tags: [' . $this->yamlInlineScalar($tag) . ']',
                '      operationId: listDeleted' . $operationBase,
                '      summary: ' . $this->yamlScalar('List deleted ' . $table . ' records'),
                '      responses:',
                "        '200':",
                '          description: Deleted records',
                '          content:',
                '            application/json:',
                '              schema:',
                '                $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['listResponse']),
            ]);
        }

        foreach ([
            'restore' => [$apiRestore, 'post', 'restore' . $operationBase, 'Restore deleted ' . $table . ' record', '200', 'Restored'],
            'force' => [$apiForceDelete, 'delete', 'forceDelete' . $operationBase, 'Permanently delete ' . $table . ' record', '204', 'Permanently deleted'],
        ] as $suffix => [$enabled, $method, $operationId, $summary, $status, $description]) {
            if (!$enabled) {
                continue;
            }

            $lines[] = '  /api/v1/' . $table . '/{id}/' . $suffix . ':';
            $lines[] = '    parameters:';
            $lines[] = '      - name: id';
            $lines[] = '        in: path';
            $lines[] = '        required: true';
            $lines[] = '        schema:';
            array_push($lines, ...$this->propertyTypeLines($pkField, 10, 'path'));
            $lines[] = '    ' . $method . ':';
            $lines[] = '      tags: [' . $this->yamlInlineScalar($tag) . ']';
            $lines[] = '      operationId: ' . $operationId;
            $lines[] = '      summary: ' . $this->yamlScalar($summary);
            $lines[] = '      responses:';
            $lines[] = "        '" . $status . "': { description: " . $description . " }";
        }

        return $lines;
    }

    /** @param array<string,array> $fields @param list<string> $required */
    private function objectSchemaLines(
        string $name,
        array $fields,
        array $required,
        string $context
    ): array {
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
            array_push($lines, ...$this->propertyTypeLines($field, 10, $context));
        }

        return $lines;
    }

    /** @return list<string> */
    private function responseSchemaLines(array $names, string $pk, array $pkField): array
    {
        $pkLines = $this->propertyTypeLines($pkField, 14, 'response');

        return array_merge(
            [
                '    ' . $names['response'] . ':',
                '      type: object',
                '      properties:',
                '        data:',
                '          $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['read']),
                '        meta: { type: object }',
                '        links: { type: object }',
                '    ' . $names['listResponse'] . ':',
                '      type: object',
                '      properties:',
                '        data:',
                '          type: array',
                '          items:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['read']),
                '        meta:',
                '          type: object',
                '          properties:',
                '            page: { type: integer }',
                '            perPage: { type: integer }',
                '            total: { type: integer }',
                '            pageCount: { type: integer }',
                '        links:',
                '          type: object',
                '          properties:',
                '            self: { type: string, nullable: true }',
                '            next: { type: string, nullable: true }',
                '            prev: { type: string, nullable: true }',
                '    ' . $names['createdResponse'] . ':',
                '      type: object',
                '      properties:',
                '        data:',
                '          type: object',
                '          properties:',
                '            ' . $this->yamlKey($pk) . ':',
            ],
            $pkLines,
            [
                '        meta: { type: object }',
                '        links: { type: object }',
                '    ' . $names['errorResponse'] . ':',
                '      type: object',
                '      required: [error]',
                '      properties:',
                '        error:',
                '          type: object',
                '          required: [code, message]',
                '          properties:',
                '            code: { type: string }',
                '            message: { type: string }',
                '            fields:',
                '              type: object',
                '              additionalProperties:',
                '                type: string',
                '  responses:',
                '    BadRequest:',
                '      description: Bad request',
                '      content:',
                '        application/json:',
                '          schema:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['errorResponse']),
                '    NotFound:',
                '      description: Record not found',
                '      content:',
                '        application/json:',
                '          schema:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['errorResponse']),
                '    ValidationError:',
                '      description: Validation error',
                '      content:',
                '        application/json:',
                '          schema:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['errorResponse']),
                '    InternalError:',
                '      description: Internal server error',
                '      content:',
                '        application/json:',
                '          schema:',
                '            $ref: ' . $this->yamlScalar('#/components/schemas/' . $names['errorResponse']),
            ]
        );
    }

    /** @return list<string> */
    private function propertyTypeLines(
        array $field,
        int $indent,
        string $context = 'response'
    ): array {
        [$type, $format] = $this->openApiType($field);
        $prefix = str_repeat(' ', $indent);
        $lines = [$prefix . 'type: ' . $type];

        if ($format !== null) {
            $lines[] = $prefix . 'format: ' . $format;
        }

        if (!empty($field['nullable']) && $context !== 'path') {
            $lines[] = $prefix . 'nullable: true';
        }

        if (!empty($field['maxLength']) && $type === 'string') {
            $lines[] = $prefix . 'maxLength: ' . (int) $field['maxLength'];
        }

        $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
        if ($context === 'multipart' && in_array($inputType, ['file', 'image'], true)) {
            $lines[0] = $prefix . 'type: string';
            if (isset($lines[1]) && str_starts_with(trim($lines[1]), 'format:')) {
                unset($lines[1]);
                $lines = array_values($lines);
            }
            $lines[] = $prefix . 'format: binary';
            $lines[] = $prefix . 'description: ' . $this->yamlScalar(
                'Binary upload stored by CrudUploadManager; the database persists the generated filename.'
            );
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

        // Upload field DB columns contain filenames, not binary payloads.
        if (in_array($inputType, ['file', 'image'], true)) {
            return ['string', null];
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

    private function schemaName(string $table, string $suffix): string
    {
        $parts = preg_split('/[^a-zA-Z0-9]+/', $table) ?: [$table];
        $base = implode('', array_map(
            static fn (string $part): string => ucfirst(strtolower($part)),
            $parts
        ));

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
