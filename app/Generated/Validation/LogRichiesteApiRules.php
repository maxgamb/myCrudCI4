<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class LogRichiesteApiRules
{
    public static function createRules(): array
    {
        return LogRichiesteRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return LogRichiesteRules::updateRules($id);
    }

    public static function messages(): array
    {
        return LogRichiesteRules::messages();
    }
}
