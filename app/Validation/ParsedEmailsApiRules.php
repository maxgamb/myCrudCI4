<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ParsedEmailsApiRules
{
    public static function createRules(): array
    {
        return ParsedEmailsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ParsedEmailsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ParsedEmailsRules::messages();
    }
}
