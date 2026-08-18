<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

/**
 * Performs mechanical normalization of data coming from CRUD forms.
 *
 * Contains no business rules: removes infrastructure fields and handles
 * automatic dates, readonly/managed fields, and configured password fields.
 */
final class CrudInputProcessor
{
    public function process(
        array $data,
        bool $isUpdate,
        array $automaticDateFields = [],
        array $disabledFields = [],
        array $managedFields = [],
        array $readonlyFields = [],
        array $passwordFields = [],
        bool $hashPasswords = false,
        array $nullableForeignKeyFields = []
    ): array {
        unset($data['_submission_token'], $data['_context'], $data['_related'], $data['_related_new']);

        $csrfName = csrf_token();
        if ($csrfName !== '') {
            unset($data[$csrfName]);
        }

        // Le select AJAX inviano anche una label di supporto per ripopolare il
        // form after validation errors. The database must receive only the ID.
        foreach (array_keys($data) as $field) {
            if (str_ends_with((string) $field, '__label')) {
                unset($data[$field]);
            }
        }

        if (!$isUpdate) {
            foreach ($automaticDateFields as $field => $format) {
                if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                    $data[$field] = date((string) $format);
                }
            }
        }

        foreach (array_unique(array_merge($disabledFields, $managedFields)) as $field) {
            unset($data[(string) $field]);
        }

        if ($isUpdate) {
            foreach ($readonlyFields as $field) {
                unset($data[(string) $field]);
            }
            foreach ($passwordFields as $field) {
                if (trim((string) ($data[$field] ?? '')) === '') {
                    unset($data[$field]);
                }
            }
        }

        if ($hashPasswords) {
            foreach ($passwordFields as $field) {
                if (isset($data[$field]) && trim((string) $data[$field]) !== '') {
                    $data[$field] = password_hash((string) $data[$field], PASSWORD_DEFAULT);
                }
            }
        }

        // Empty HTML selects submit an empty string. For nullable foreign keys
        // the database representation must be NULL, not ''.
        foreach ($nullableForeignKeyFields as $field) {
            $field = (string) $field;
            if ($field === '' || !array_key_exists($field, $data)) {
                continue;
            }
            $value = $data[$field];
            if ($value === null) {
                continue;
            }
            if (is_scalar($value) && trim((string) $value) === '') {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
