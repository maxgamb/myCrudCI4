<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class LogObmpApiRules
{
    public static function createRules(): array
    {
        return LogObmpRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return LogObmpRules::updateRules($id);
    }

    public static function messages(): array
    {
        return LogObmpRules::messages();
    }
}
