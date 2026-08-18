<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class TestScaffoldArchitectureAlignmentTest extends TestCase
{
    public function testGeneratedContractsMatchCurrentArchitecture(): void
    {
        $root = dirname(__DIR__, 2);
        $source = (string) file_get_contents($root . '/app/Libraries/MyCrud/Generators/TestScaffoldGenerator.php');

        self::assertStringContainsString("assertStringNotContainsString('App\\\\\\\\Models'", $source);
        self::assertStringContainsString("assertStringNotContainsString('App\\\\\\\\Services'", $source);
        self::assertStringContainsString("assertStringContainsString('manyToManyFormOptions'", $source);
        self::assertStringContainsString("assertStringContainsString('manyToManySelected'", $source);
        self::assertStringNotContainsString("assertStringContainsString('applyManyToMany'", $source);
        self::assertStringNotContainsString("assertStringContainsString('validManyToManyTargetIds'", $source);
        self::assertStringNotContainsString("assertStringContainsString('relatedCreateRelationOptions', $model)", $source);
        self::assertStringNotContainsString("assertStringContainsString('manyToManyRelatedCreateRelationOptions', $model)", $source);
        self::assertStringContainsString("'Legacy generic M2M Related Create relation-options adapter found.'", $source);
    }
}
