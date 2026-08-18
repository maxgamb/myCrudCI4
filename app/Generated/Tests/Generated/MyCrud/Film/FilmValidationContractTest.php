<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Film;

use App\Validation\FilmRules;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test for generated rules.
 *
 * Does not verify custom business rules: it checks the policies that myCrudCI4
 * can derive directly from configuration.
 */
final class FilmValidationContractTest extends CIUnitTestCase
{
    private const FORBIDDEN_RULE_FIELDS = array (
  0 => 'film_id',
  1 => 'last_update',
  2 => 'uploads',
);
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = array (
  0 => 'many__film_actor__film_id',
  1 => 'many__film_category__film_id',
);

    public function testCreateRulesAreStructurallyValid(): void
    {
        $rules = FilmRules::createRules();
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
        $rules = FilmRules::updateRules('1');
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
        $rules = FilmRules::manyToManyRelatedCreateRules();
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
        $this->assertIsArray(FilmRules::messages());
    }
}
