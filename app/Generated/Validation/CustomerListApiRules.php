<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class CustomerListApiRules
{
    public static function createRules(): array
    {
        return CustomerListRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return CustomerListRules::updateRules($id);
    }

    public static function messages(): array
    {
        return CustomerListRules::messages();
    }
}
