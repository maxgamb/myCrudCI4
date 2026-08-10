<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ActorInfoApiRules
{
    public static function createRules(): array
    {
        return ActorInfoRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ActorInfoRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ActorInfoRules::messages();
    }
}
