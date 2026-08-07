<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class DocFileApiRules
{
    public static function createRules(): array
    {
        return DocFileRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return DocFileRules::updateRules($id);
    }

    public static function messages(): array
    {
        return DocFileRules::messages();
    }
}
