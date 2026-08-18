<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

/**
 * Shared rules for password, sensitive, technical, and binary fields.
 *
 * Classification of a field as password or sensitive is no longer
 * imposta automaticamente in base al nome. La decisione finale deve essere
 * configurata dallo sviluppatore nel Builder.
 *
 * I metodi suggestsPassword() e suggestsSensitive() possono essere usati
 * esclusivamente per mostrare un avviso nel Builder.
 */
final class FieldPolicy
{
    /**
     * A field is treated as a password only when the input type has been
     * configurato esplicitamente come "password".
     */
    public static function isPassword(string $name, string $inputType = ''): bool
    {
        unset($name);

        return strtolower(trim($inputType)) === 'password';
    }

    /**
     * Sensitivity is not inferred automatically from the field name.
     * It must be defined by Builder configuration.
     */
    public static function isSensitive(string $name, string $inputType = ''): bool
    {
        unset($name, $inputType);

        return false;
    }

    /**
     * Suggests that the field may represent a password.
     * Does not automatically modify field configuration.
     */
    public static function suggestsPassword(string $name, string $inputType = ''): bool
    {
        if (strtolower(trim($inputType)) === 'password') {
            return true;
        }

        return preg_match(
            '/(?:^|_)(?:password|passwd|passphrase|pwd)(?:$|_)/i',
            $name
        ) === 1;
    }

    /**
     * Suggests that the field may contain a confidential value.
     * Il risultato deve essere usato soltanto come avviso nel Builder.
     */
    public static function suggestsSensitive(string $name, string $inputType = ''): bool
    {
        if (self::suggestsPassword($name, $inputType)) {
            return true;
        }

        return preg_match(
            '/(?:^|_)(?:secret|token|access_token|refresh_token|pin|api_key|apikey|private_key|chiave|cvv|cvc|cod_sicurezza|codice_sicurezza|security_code|cc_numero|numero_carta|card_number|credit_card_number|cc_scadenza|card_expiry|card_expiration)(?:$|_)/i',
            $name
        ) === 1;
    }

    /**
     * Riconosce i TIMESTAMP/DATETIME interamente gestiti dal database:
     * DEFAULT CURRENT_TIMESTAMP + ON UPDATE CURRENT_TIMESTAMP.
     *
     * These fields are readable but must not be sent by forms/APIs
     * né inclusi nelle regole di validazione o negli allowedFields del Model.
     */
    public static function isDatabaseManagedTimestamp(array $field): bool
    {
        $type = strtolower(trim((string) ($field['type'] ?? '')));
        if (!in_array($type, ['timestamp', 'datetime'], true)) {
            return false;
        }

        $default = trim((string) ($field['default'] ?? $field['defaultValue'] ?? ''));
        $extra = strtolower(trim((string) ($field['extra'] ?? '')));

        $currentTimestampDefault = preg_match(
            '/^current_timestamp(?:\([0-9]*\))?$/i',
            $default
        ) === 1;

        $autoOnUpdate = !empty($field['autoOnUpdate'])
            || preg_match('/on\s+update\s+current_timestamp(?:\([0-9]*\))?/i', $extra) === 1;

        return $currentTimestampDefault && $autoOnUpdate;
    }

    public static function isTechnical(string $name, string $softDeleteField = 'deleted_at'): bool
    {
        $name = strtolower($name);
        $softDeleteField = strtolower($softDeleteField);

        if ($name === $softDeleteField) {
            return true;
        }

        return preg_match(
            '/(?:^|_)(?:created_at|updated_at|deleted_at|data_record|recorded_at)(?:$|_)/i',
            $name
        ) === 1;
    }

    public static function isSpatial(string $type): bool
    {
        $type = strtolower(trim($type));

        return preg_match('/^(?:geometry|point|linestring|polygon|multipoint|multilinestring|multipolygon|geometrycollection)$/', $type) === 1;
    }

    public static function isLargeOrBinary(string $type, string $inputType = ''): bool
    {
        $type = strtolower($type);
        $inputType = strtolower($inputType);

        return in_array($inputType, ['file', 'image'], true)
            || str_contains($type, 'blob')
            || str_contains($type, 'binary')
            || self::isSpatial($type);
    }
}
