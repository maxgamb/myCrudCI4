<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class AdebitiApiRules
{
    public static function createRules(): array
    {
        return AdebitiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return AdebitiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return AdebitiRules::messages();
    }
}
