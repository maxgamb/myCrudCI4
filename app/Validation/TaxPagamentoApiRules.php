<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class TaxPagamentoApiRules
{
    public static function createRules(): array
    {
        return TaxPagamentoRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return TaxPagamentoRules::updateRules($id);
    }

    public static function messages(): array
    {
        return TaxPagamentoRules::messages();
    }
}
