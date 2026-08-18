<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use App\Libraries\MyCrud\Dashboard\DashboardGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class DashboardEqualHeightRowTest extends TestCase
{
    public function testGeneratedDashboardViewUsesEqualHeightRowContract(): void
    {
        $reflection = new ReflectionClass(DashboardGenerator::class);
        $method = $reflection->getMethod('viewClass');
        $method->setAccessible(true);

        /** @var string $view */
        $view = $method->invoke(new DashboardGenerator());

        self::assertStringContainsString('row g-3 align-items-stretch', $view);
        self::assertStringContainsString('d-flex dashboard-widget-column', $view);
        self::assertStringContainsString('h-100 w-100 dashboard-widget-card', $view);
        self::assertStringNotContainsString('row g-3 align-items-start', $view);
    }
}
