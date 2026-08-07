<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class EmailsApiRules
{
    public static function createRules(): array
    {
        return EmailsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return EmailsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return EmailsRules::messages();
    }
}
