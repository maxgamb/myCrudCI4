<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class CassaApiRules
{
    public static function createRules(): array
    {
        return CassaRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return CassaRules::updateRules($id);
    }

    public static function messages(): array
    {
        return CassaRules::messages();
    }
}
