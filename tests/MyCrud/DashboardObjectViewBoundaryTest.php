<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use App\Libraries\MyCrud\Dashboard\DashboardGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

final class DashboardObjectViewBoundaryTest extends TestCase
{
    public function testControllerPassesDashboardDataObjectDirectlyToView(): void
    {
        $generator = new DashboardGenerator();
        $method = new ReflectionMethod($generator, 'controllerClass');
        $method->setAccessible(true);

        $code = (string) $method->invoke($generator, 'Application Dashboard');

        self::assertStringContainsString("'title' => \$dashboard->title", $code);
        self::assertStringContainsString("'dashboard' => \$dashboard", $code);
        self::assertStringNotContainsString("\$dashboard['title']", $code);
        self::assertStringNotContainsString('->toArray()', $code);
    }

    public function testGeneratedViewUsesDashboardAndWidgetObjects(): void
    {
        $generator = new DashboardGenerator();
        $method = new ReflectionMethod($generator, 'viewFile');
        $method->setAccessible(true);

        $code = (string) $method->invoke($generator);

        self::assertStringContainsString('$dashboard->title', $code);
        self::assertStringContainsString('$dashboard->widgets', $code);
        self::assertStringContainsString('$widget->type', $code);
        self::assertStringContainsString("\$widget->get('records', [])", $code);
        self::assertStringContainsString('$record->value((string) $field)', $code);
        self::assertStringNotContainsString("\$dashboard['widgets']", $code);
        self::assertStringNotContainsString("\$widget['type']", $code);
    }

    public function testGeneratedViewKeepsRecentTablesReadableAndUsesAggregateFieldLabels(): void
    {
        $generator = new DashboardGenerator();
        $viewMethod = new ReflectionMethod($generator, 'viewFile');
        $viewMethod->setAccessible(true);
        $viewCode = (string) $viewMethod->invoke($generator);

        self::assertStringContainsString('dashboard-recent-table', $viewCode);
        self::assertStringContainsString('dashboard-cell-text', $viewCode);
        self::assertStringContainsString('text-truncate', $viewCode);
        self::assertStringContainsString("\$widget->get('fieldLabel', \$widget->get('field', ''))", $viewCode);

        $serviceMethod = new ReflectionMethod($generator, 'serviceClass');
        $serviceMethod->setAccessible(true);
        $serviceCode = (string) $serviceMethod->invoke($generator, '[]', []);

        self::assertStringContainsString("'fieldLabel' => (string)", $serviceCode);
    }

    public function testRecentRecordDtosAreNotFlattenedBeforeView(): void
    {
        $generator = new DashboardGenerator();
        $method = new ReflectionMethod($generator, 'serviceClass');
        $method->setAccessible(true);

        $code = (string) $method->invoke($generator, '[]', []);

        self::assertStringContainsString("'records' => \$records", $code);
        self::assertStringNotContainsString('static fn (RecentRecord $record): array => $record->toArray()', $code);
    }
}
