<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class BuilderParentTablesScrollUxTest extends TestCase
{
    public function testParentTableListOwnsTheScrollBoundary(): void
    {
        $view = file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertIsString($view);
        self::assertStringContainsString('mycrud-parent-tables-card', $view);
        self::assertStringContainsString('mycrud-parent-tables-scroll', $view);
        self::assertStringContainsString('max-height: min(360px, calc(100vh - 10rem));', $view);
        self::assertStringContainsString('overflow-y: auto;', $view);
        self::assertStringContainsString('overscroll-behavior: contain;', $view);
        self::assertStringContainsString('list-group list-group-flush mycrud-parent-tables-scroll', $view);
        self::assertStringNotContainsString('max-height: calc(100vh - 2rem); overflow-y: auto;', $view);
    }
}
