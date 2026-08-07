<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

/**
 * Regole comuni per campi password, sensibili, tecnici e binari.
 *
 * La classificazione di un campo come password o sensibile non viene più
 * imposta automaticamente in base al nome. La decisione finale deve essere
 * configurata dallo sviluppatore nel Builder.
 *
 * I metodi suggestsPassword() e suggestsSensitive() possono essere usati
 * esclusivamente per mostrare un avviso nel Builder.
 */
final class FieldPolicy
{
    /**
     * Un campo è trattato come password solo quando il tipo input è stato
     * configurato esplicitamente come "password".
     */
    public static function isPassword(string $name, string $inputType = ''): bool
    {
        unset($name);

        return strtolower(trim($inputType)) === 'password';
    }

    /**
     * La sensibilità non viene dedotta automaticamente dal nome del campo.
     * Deve essere stabilita dalla configurazione del Builder.
     */
    public static function isSensitive(string $name, string $inputType = ''): bool
    {
        unset($name, $inputType);

        return false;
    }

    /**
     * Suggerisce che il campo potrebbe rappresentare una password.
     * Non modifica automaticamente la configurazione del campo.
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
     * Suggerisce che il campo potrebbe contenere un valore riservato.
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
