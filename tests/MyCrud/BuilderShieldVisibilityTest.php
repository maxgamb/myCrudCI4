<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class BuilderShieldVisibilityTest extends TestCase
{
    public function testShieldIsAVisibleStandaloneBuilderPanel(): void
    {
        $path = dirname(__DIR__, 2) . '/app/Views/mycrud/builder.php';
        $view = file_get_contents($path);

        self::assertIsString($view);
        self::assertStringContainsString('id="builder-shield"', $view);
        self::assertStringContainsString('Security / Shield', $view);
        self::assertStringContainsString('href="#builder-shield"', $view);
        self::assertStringContainsString('id="builderStatusShield"', $view);
        self::assertStringContainsString('name="crudSecurity[auth]"', $view);
        self::assertStringContainsString('value="shield_session"', $view);
        self::assertStringContainsString('crudSecurity[permissions]', $view);
        self::assertStringContainsString('name="apiSecurity[auth]"', $view);
        self::assertStringContainsString('value="shield_tokens"', $view);
        self::assertStringContainsString('apiSecurity[permissions]', $view);

        $apiStart = strpos($view, 'id="builder-api"');
        $shieldStart = strpos($view, 'id="builder-shield"');
        self::assertNotFalse($apiStart);
        self::assertNotFalse($shieldStart);
        self::assertGreaterThan($apiStart, $shieldStart);

        $apiBlock = substr($view, $apiStart, $shieldStart - $apiStart);
        self::assertStringNotContainsString('name="apiSecurity[auth]"', $apiBlock);
        self::assertStringNotContainsString('Shield — Bearer Access Token', $apiBlock);
    }
}
