<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ProdottiListaApiRules
{
    public static function createRules(): array
    {
        return ProdottiListaRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ProdottiListaRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ProdottiListaRules::messages();
    }
}
