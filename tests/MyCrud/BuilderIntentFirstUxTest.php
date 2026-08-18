<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class BuilderIntentFirstUxTest extends TestCase
{
    public function testBuilderKeepsCoreWorkflowVisibleAndTechnicalOptionsAdvanced(): void
    {
        $view = file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertIsString($view);
        self::assertStringContainsString('Recommended workflow', $view);
        self::assertStringContainsString('Core workflow', $view);
        self::assertStringContainsString('Advanced · Full', $view);
        self::assertStringContainsString('Advanced · Optional', $view);
        self::assertStringContainsString('Configure API', $view);
        self::assertStringContainsString('Configure MCP', $view);
        self::assertStringContainsString('Generate to staging', $view);
        self::assertStringContainsString('Generation writes only to <code>app/Generated/</code>.', $view);
        self::assertStringContainsString('Overwrite staging files', $view);
        self::assertStringNotContainsString("Trascina i fields", $view);
    }

    public function testFieldGuideIsCollapsedByDefault(): void
    {
        $view = file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertIsString($view);
        self::assertStringContainsString('Field configuration guide', $view);
        self::assertStringNotContainsString('<details class="border rounded p-3 bg-body-tertiary" open>', $view);
    }
}
