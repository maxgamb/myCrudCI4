<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class LogObmpFullApiRules
{
    public static function createRules(): array
    {
        return LogObmpFullRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return LogObmpFullRules::updateRules($id);
    }

    public static function messages(): array
    {
        return LogObmpFullRules::messages();
    }
}
