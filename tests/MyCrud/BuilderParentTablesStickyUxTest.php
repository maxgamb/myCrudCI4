<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class BuilderParentTablesStickyUxTest extends TestCase
{
    public function testParentDatabaseTablesStickyIsAppliedToAsideContainer(): void
    {
        $view = file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertIsString($view);
        self::assertStringContainsString('mycrud-parent-tables-aside', $view);
        self::assertStringContainsString('.mycrud-parent-tables-aside {', $view);
        self::assertStringContainsString('position: sticky;', $view);
        self::assertStringContainsString('top: 1rem;', $view);
        self::assertStringContainsString('align-self: start;', $view);
        self::assertStringContainsString('<aside class="col-12 col-lg-2 col-xxl-2 mycrud-parent-tables-aside">', $view);
        self::assertStringContainsString('<div class="card shadow-sm">', $view);

        // Sticky must not be constrained by a same-height child container.
        self::assertStringNotContainsString('position-sticky mycrud-parent-tables-card', $view);
        self::assertStringNotContainsString('mycrud-parent-tables-scroll', $view);
        self::assertStringNotContainsString('overflow-y: auto', substr($view, 0, 4000));
    }
}
