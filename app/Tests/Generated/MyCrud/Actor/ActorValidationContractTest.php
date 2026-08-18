<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Actor;

use App\Validation\ActorRules;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test for generated rules.
 *
 * Does not verify custom business rules: it checks the policies that myCrudCI4
 * can derive directly from configuration.
 */
final class ActorValidationContractTest extends CIUnitTestCase
{
    private const FORBIDDEN_RULE_FIELDS = array (
  0 => 'actor_id',
  1 => 'last_update',
);
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = array (
  0 => 'many__film_actor__actor_id',
);

    public function testCreateRulesAreStructurallyValid(): void
    {
        $rules = ActorRules::createRules();
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
        $rules = ActorRules::updateRules('1');
        $this->assertIsArray($rules);

        foreach (self::FORBIDDEN_RULE_FIELDS as $field) {
            $this->assertArrayNotHasKey(
                $field,
                $rules,
                'Framework/DB-managed/upload field present in update rules: ' . $field
            );
        }
    }
    public function testManyToManyRelatedCreateRulesMatchConfiguration(): void
    {
        $rules = ActorRules::manyToManyRelatedCreateRules();
        $this->assertIsArray($rules);

        foreach (self::MANY_TO_MANY_RELATED_CREATE_KEYS as $relationKey) {
            $this->assertArrayHasKey(
                $relationKey,
                $rules,
                'Missing related-create validation rules for relation: ' . $relationKey
            );
            $this->assertNotSame([], $rules[$relationKey]);
        }
    }
    public function testValidationMessagesReturnArray(): void
    {
        $this->assertIsArray(ActorRules::messages());
    }
}
