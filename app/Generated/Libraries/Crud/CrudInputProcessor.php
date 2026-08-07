<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

/**
 * Esegue la normalizzazione meccanica dei dati provenienti dai form CRUD.
 *
 * Non contiene regole di business: rimuove campi infrastrutturali, gestisce
 * date automatiche, campi readonly/managed e password configurate come tali.
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
        bool $hashPasswords = false
    ): array {
        unset($data['_submission_token']);

        $csrfName = csrf_token();
        if ($csrfName !== '') {
            unset($data[$csrfName]);
        }

        // Le select AJAX inviano anche una label di supporto per ripopolare il
        // form dopo errori di validazione. Il database deve ricevere solo l'ID.
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

        return $data;
    }
}