<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Country;

use App\Validation\CountryRules;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test for generated rules.
 *
 * Does not verify custom business rules: it checks the policies that myCrudCI4
 * can derive directly from configuration.
 */
final class CountryValidationContractTest extends CIUnitTestCase
{
    private const FORBIDDEN_RULE_FIELDS = array (
  0 => 'country_id',
  1 => 'last_update',
);
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = array (
);

    public function testCreateRulesAreStructurallyValid(): void
    {
        $rules = CountryRules::createRules();
        $this->assertIsArray($rules);

        foreach (self::FORBIDDEN_RULE_FIELDS as $field) {
            $this->assertArrayNotHasKey(
                $field,
                $rules,
                'Framework/DB-managed/upload field present in create rules: ' . $field
            );
        }
    }
    public function testUpdateRulesAreStructurallyValid(): void
    {
        $rules = CountryRules::updateRules('1');
        $this->assertIsArray($rules);

        foreach (self::FORBIDDEN_RULE_FIELDS as $field) {
            $this->assertArrayNotHasKey(
                $field,
                $rules,
                'Framework/DB-managed/upload field present in update rules: ' . $field
            );
        }
    }
    public function testValidationMessagesReturnArray(): void
    {
        $this->assertIsArray(CountryRules::messages());
    }
}
