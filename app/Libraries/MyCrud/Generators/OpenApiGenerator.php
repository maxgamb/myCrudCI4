<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/** Genera una specifica OpenAPI essenziale e coerente con la risorsa. */
final class OpenApiGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $pk = (string) $config['primaryKey'];
        $schema = [];
        $required = [];

        foreach ($config['fields'] as $field) {
            $name = (string) $field['name'];
            $ui = (array) ($field['ui'] ?? []);
            if (!empty($ui['sensitive']) || preg_match('/(?:^|_)(?:password|secret|token|pin|api_key|private_key|chiave|cvv)(?:$|_)/i', $name)) {
                continue;
            }

            [$openType, $format] = $this->openApiType($field);
            $schema[] = "        {$name}:\n          type: {$openType}" . ($format !== null ? "\n          format: {$format}" : '');

            $managedTimestamp = in_array($name, ['created_at', 'updated_at', 'deleted_at'], true);
            $autoIncrement = !empty($field['autoIncrement']);
            if (empty($field['nullable']) && ($field['default'] ?? null) === null && !$autoIncrement && !$managedTimestamp) {
                $required[] = "        - {$name}";
            }
        }

        $properties = implode("\n", $schema);
        $requiredYaml = $required !== [] ? "\n      required:\n" . implode("\n", $required) : '';
        $content = <<<YAML
openapi: 3.0.3
info:
  title: {$table} API
  version: 1.0.0
paths:
  /api/v1/{$table}:
    get:
      summary: Elenco {$table}
      parameters:
        - { name: page, in: query, schema: { type: integer, minimum: 1 } }
        - { name: perPage, in: query, schema: { type: integer, minimum: 1, maximum: 100 } }
        - { name: search, in: query, schema: { type: string } }
        - { name: sort, in: query, schema: { type: string } }
        - { name: direction, in: query, schema: { type: string, enum: [asc, desc] } }
      responses:
        '200': { description: Elenco paginato }
    post:
      summary: Crea record
      responses:
        '201': { description: Record creato }
        '422': { description: Errore di validazione }
  /api/v1/{$table}/{id}:
    parameters:
      - { name: id, in: path, required: true, schema: { type: string } }
    get:
      summary: Dettaglio record
      responses:
        '200': { description: Record trovato }
        '404': { description: Record non trovato }
    put:
      summary: Aggiornamento completo
      responses:
        '200': { description: Record aggiornato }
    patch:
      summary: Aggiornamento parziale
      responses:
        '200': { description: Record aggiornato }
    delete:
      summary: Elimina record
      responses:
        '204': { description: Record eliminato }
components:
  schemas:
    {$table}:
      type: object{$requiredYaml}
      properties:
{$properties}
YAML;
        return $this->writeGenerated("OpenApi/{$table}.yaml", $content, $force);
    }

    /** @return array{0:string,1:?string} */
    private function openApiType(array $field): array
    {
        $type = strtolower((string) ($field['columnType'] ?? $field['type'] ?? 'string'));

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
}
