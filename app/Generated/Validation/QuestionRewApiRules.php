<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class QuestionRewApiRules
{
    public static function createRules(): array
    {
        return QuestionRewRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return QuestionRewRules::updateRules($id);
    }

    public static function messages(): array
    {
        return QuestionRewRules::messages();
    }
}
