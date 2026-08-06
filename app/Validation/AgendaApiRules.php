<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class AgendaApiRules
{
    public static function createRules(): array
    {
        return AgendaRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return AgendaRules::updateRules($id);
    }

    public static function messages(): array
    {
        return AgendaRules::messages();
    }
}
