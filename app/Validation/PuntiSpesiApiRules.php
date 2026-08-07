<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class PuntiSpesiApiRules
{
    public static function createRules(): array
    {
        return PuntiSpesiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return PuntiSpesiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return PuntiSpesiRules::messages();
    }
}
