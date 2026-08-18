<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Customer;

use App\Validation\CustomerRules;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test for generated rules.
 *
 * Does not verify custom business rules: it checks the policies that myCrudCI4
 * can derive directly from configuration.
 */
final class CustomerValidationContractTest extends CIUnitTestCase
{
    private const FORBIDDEN_RULE_FIELDS = array (
  0 => 'customer_id',
  1 => 'last_update',
);
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = array (
);

    public function testCreateRulesAreStructurallyValid(): void
    {
        $rules = CustomerRules::createRules();
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
        $rules = CustomerRules::updateRules('1');
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
        $this->assertIsArray(CustomerRules::messages());
    }
}
