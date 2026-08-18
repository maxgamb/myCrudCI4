<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ShieldCrudApiSeparationTest extends TestCase
{
    public function testBuilderExposesIndependentCrudAndApiShieldSettings(): void
    {
        $root = dirname(__DIR__, 2);
        $view = (string) file_get_contents($root . '/app/Views/mycrud/builder.php');

        self::assertStringContainsString('Web CRUD', $view);
        self::assertStringContainsString('REST API', $view);
        self::assertStringContainsString('name="crudSecurity[auth]"', $view);
        self::assertStringContainsString('value="shield_session"', $view);
        self::assertStringContainsString('crudSecurity[permissions]', $view);
        self::assertStringContainsString('name="apiSecurity[auth]"', $view);
        self::assertStringContainsString('value="shield_tokens"', $view);
        self::assertStringContainsString('apiSecurity[permissions]', $view);
    }

    public function testCrudSecurityIsPersistentAndNormalized(): void
    {
        $root = dirname(__DIR__, 2);
        $builder = (string) file_get_contents($root . '/app/Libraries/MyCrud/Core/ConfigBuilder.php');
        $repository = (string) file_get_contents($root . '/app/Libraries/MyCrud/Config/CrudConfigRepository.php');

        self::assertStringContainsString("'crudSecurity' => \$this->defaultCrudSecurity()", $builder);
        self::assertStringContainsString('crudSecurityFromPost', $builder);
        self::assertStringContainsString('normalizeCrudSecurity', $builder);
        self::assertStringContainsString("'crudSecurity' => [", $repository);
    }

    public function testRouteGeneratorUsesExplicitShieldFiltersForWebAndApi(): void
    {
        $root = dirname(__DIR__, 2);
        $routes = (string) file_get_contents($root . '/app/Libraries/MyCrud/Generators/RouteGenerator.php');

        self::assertStringContainsString("\$crudAuth === 'shield_session'", $routes);
        self::assertStringContainsString("['filter' => 'session']", $routes);
        self::assertStringContainsString('permission:', $routes);
        self::assertStringContainsString("\$apiAuth === 'shield_tokens'", $routes);
        self::assertStringContainsString("'filter' => 'tokens'", $routes);
        self::assertStringNotContainsString('SecurityResolver', $routes);
        self::assertStringNotContainsString('resolveSecurity', $routes);
    }

    public function testGeneratedTestScaffoldCoversWebShieldContract(): void
    {
        $root = dirname(__DIR__, 2);
        $tests = (string) file_get_contents($root . '/app/Libraries/MyCrud/Generators/TestScaffoldGenerator.php');

        self::assertStringContainsString("['crudSecurity']['auth']", $tests);
        self::assertStringContainsString('WebSecurityContractTest.php', $tests);
        self::assertStringContainsString('webSecurityTest', $tests);
        self::assertStringContainsString('SessionAuth', $tests);
        self::assertStringContainsString('\\$path = APPPATH', $tests);
        self::assertStringContainsString("'filter' => 'session'", $tests);
    }
}
