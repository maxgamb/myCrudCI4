<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class QuestionApiRules
{
    public static function createRules(): array
    {
        return QuestionRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return QuestionRules::updateRules($id);
    }

    public static function messages(): array
    {
        return QuestionRules::messages();
    }
}
