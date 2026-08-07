<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class NazioniBandieraApiRules
{
    public static function createRules(): array
    {
        return NazioniBandieraRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return NazioniBandieraRules::updateRules($id);
    }

    public static function messages(): array
    {
        return NazioniBandieraRules::messages();
    }
}
