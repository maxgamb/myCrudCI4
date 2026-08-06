<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

/** Regole comuni per campi sensibili, password e campi tecnici. */
final class FieldPolicy
{
    public static function isPassword(string $name, string $inputType = ''): bool
    {
        if (strtolower($inputType) === 'password') {
            return true;
        }

        return preg_match('/(?:^|_)(?:password|passwd|passphrase|pwd)(?:$|_)/i', $name) === 1;
    }

    public static function isSensitive(string $name, string $inputType = ''): bool
    {
        if (self::isPassword($name, $inputType)) {
            return true;
        }

        return preg_match(
            '/(?:^|_)(?:secret|token|access_token|refresh_token|pin|api_key|apikey|private_key|chiave|cvv|cvc|cod_sicurezza|codice_sicurezza|security_code|cc_numero|numero_carta|card_number|credit_card_number|cc_scadenza|card_expiry|card_expiration)(?:$|_)/i',
            $name
        ) === 1;
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

    public static function isLargeOrBinary(string $type, string $inputType = ''): bool
    {
        $type = strtolower($type);
        $inputType = strtolower($inputType);

        return in_array($inputType, ['file', 'image'], true)
            || str_contains($type, 'blob')
            || str_contains($type, 'binary');
    }
}
