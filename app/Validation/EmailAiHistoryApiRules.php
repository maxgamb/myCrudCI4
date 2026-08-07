<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class EmailAiHistoryApiRules
{
    public static function createRules(): array
    {
        return EmailAiHistoryRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return EmailAiHistoryRules::updateRules($id);
    }

    public static function messages(): array
    {
        return EmailAiHistoryRules::messages();
    }
}
