<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class CaxMotivoApiRules
{
    public static function createRules(): array
    {
        return CaxMotivoRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return CaxMotivoRules::updateRules($id);
    }

    public static function messages(): array
    {
        return CaxMotivoRules::messages();
    }
}
