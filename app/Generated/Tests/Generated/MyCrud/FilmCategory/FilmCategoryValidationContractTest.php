<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\FilmCategory;

use App\Validation\FilmCategoryRules;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test for generated rules.
 *
 * Does not verify custom business rules: it checks the policies that myCrudCI4
 * can derive directly from configuration.
 */
final class FilmCategoryValidationContractTest extends CIUnitTestCase
{
    private const FORBIDDEN_RULE_FIELDS = array (
  0 => 'last_update',
);
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = array (
);

    public function testCreateRulesAreStructurallyValid(): void
    {
        $rules = FilmCategoryRules::createRules();
        $this->assertIsArray($rules);

        foreach (self::FORBIDDEN_RULE_FIELDS as $field) {
            $this->assertArrayNotHasKey(
                $field,
                $rules,
                'Framework/DB-managed/upload field present in create rules: ' . $field
            );
        }
    }
    public function testValidationMessagesReturnArray(): void
    {
        $this->assertIsArray(FilmCategoryRules::messages());
    }
}
