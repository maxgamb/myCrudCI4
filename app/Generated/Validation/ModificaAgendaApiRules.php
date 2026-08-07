<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ModificaAgendaApiRules
{
    public static function createRules(): array
    {
        return ModificaAgendaRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ModificaAgendaRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ModificaAgendaRules::messages();
    }
}
