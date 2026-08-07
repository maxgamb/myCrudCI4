<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpCancellationsApiRules
{
    public static function createRules(): array
    {
        return ObmpCancellationsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpCancellationsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpCancellationsRules::messages();
    }
}
