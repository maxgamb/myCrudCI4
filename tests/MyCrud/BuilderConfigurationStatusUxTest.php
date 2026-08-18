<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class BuilderConfigurationStatusUxTest extends TestCase
{
    public function testBuilderSidebarShowsLiveConfigurationStatusBadges(): void
    {
        $view = file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertIsString($view);
        self::assertStringContainsString('builderStatusArchitecture', $view);
        self::assertStringContainsString('builderStatusRelations', $view);
        self::assertStringContainsString('builderStatusSections', $view);
        self::assertStringContainsString('builderStatusFields', $view);
        self::assertStringContainsString('builderStatusApi', $view);
        self::assertStringContainsString('builderStatusMcp', $view);
        self::assertStringContainsString('syncBuilderStatus', $view);
    }

    public function testStatusUxDoesNotChangeGenerationBoundary(): void
    {
        $view = file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertIsString($view);
        self::assertStringContainsString('Generate to staging', $view);
        self::assertStringContainsString('Generation writes only to <code>app/Generated/</code>.', $view);
        self::assertStringContainsString('Overwrite staging files', $view);
    }
}
