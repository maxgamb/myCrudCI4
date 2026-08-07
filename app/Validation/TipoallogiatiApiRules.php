<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class TipoallogiatiApiRules
{
    public static function createRules(): array
    {
        return TipoallogiatiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return TipoallogiatiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return TipoallogiatiRules::messages();
    }
}
