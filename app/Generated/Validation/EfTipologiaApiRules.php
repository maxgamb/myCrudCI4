<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class EfTipologiaApiRules
{
    public static function createRules(): array
    {
        return EfTipologiaRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return EfTipologiaRules::updateRules($id);
    }

    public static function messages(): array
    {
        return EfTipologiaRules::messages();
    }
}
