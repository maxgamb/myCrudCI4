<?php

namespace App\Libraries\MyCrud\Core;

/**
 * Deriva le regole di validazione direttamente dai metadati del database.
 *
 * Il database resta la fonte principale: nullable, tipo, lunghezza,
 * indici UNIQUE e foreign key vengono convertiti in regole CI4.
 */
final class DatabaseValidationResolver
{
    /** @return list<string> */
    public function rulesFor(array $field, string $table, string $primaryKey, bool $update = false): array
    {
        if ((!empty($field['primary']) && !empty($field['autoIncrement'])) || !empty($field['databaseManaged'])) {
            return [];
        }

        $rules = [$this->isRequired($field) ? 'required' : 'permit_empty'];
        $type = strtolower((string) ($field['type'] ?? ''));
        $columnType = strtolower((string) ($field['columnType'] ?? ''));
        $maxLength = (int) ($field['maxLength'] ?? 0);

        if ($maxLength > 0 && $maxLength <= 65535) {
            // CHAR(n) indica la capacità massima della colonna DB, non una
            // required application length. exact_length must remain
            // una scelta esplicita del programmatore/Builder.
            $rules[] = 'max_length[' . $maxLength . ']';
        }

        if (preg_match('/tinyint|smallint|mediumint|bigint|int/', $type) === 1) {
            $rules[] = 'integer';
        } elseif (preg_match('/decimal|numeric|float|double|real/', $type) === 1) {
            $rules[] = 'decimal';
        } elseif ($type === 'date') {
            $rules[] = 'valid_date[Y-m-d]';
        } elseif (in_array($type, ['datetime', 'timestamp'], true)) {
            $rules[] = 'valid_date';
        }

        $inputType = (string) ($field['inputType'] ?? '');
        if ($inputType === 'email') {
            $rules[] = 'valid_email';
        } elseif ($inputType === 'url') {
            $rules[] = 'valid_url_strict';
        }

        $pattern = trim((string) ($field['attributes']['values']['pattern'] ?? ''));
        if ($pattern !== '') {
            $rules[] = 'regex_match[' . $pattern . ']';
        }

        $foreignKey = $field['foreignKey'] ?? null;
        if (is_array($foreignKey) && !empty($foreignKey['parentTable']) && !empty($foreignKey['parentKey'])) {
            $rules[] = sprintf(
                'is_not_unique[%s.%s]',
                $foreignKey['parentTable'],
                $foreignKey['parentKey']
            );
        }

        if (!empty($field['unique'])) {
            $rules[] = $update
                ? "is_unique[{$table}.{$field['name']},{$primaryKey},{id}]"
                : "is_unique[{$table}.{$field['name']}]";
        }

        return array_values(array_unique($rules));
    }

    public function ruleString(array $field, string $table, string $primaryKey, bool $update = false): string
    {
        return implode('|', $this->rulesFor($field, $table, $primaryKey, $update));
    }

    private function isRequired(array $field): bool
    {
        $attributes = (array) ($field['attributes']['boolean'] ?? []);
        return in_array('required', $attributes, true)
            || (($field['nullable'] ?? true) === false
                && ($field['default'] ?? null) === null
                && empty($field['autoIncrement']));
    }
}
