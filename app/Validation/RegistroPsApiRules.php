<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RegistroPsApiRules
{
    public static function createRules(): array
    {
        return RegistroPsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RegistroPsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RegistroPsRules::messages();
    }
}
