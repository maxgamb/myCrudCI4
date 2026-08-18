<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class DashboardConfigBoundaryTest extends TestCase
{
    public function testGeneratorTreatsBuilderWidgetsAsArraysBeforeRuntimeDtoCreation(): void
    {
        $path = APPPATH . 'Libraries/MyCrud/Dashboard/DashboardGenerator.php';
        $code = file_get_contents($path);
        self::assertIsString($code);

        self::assertStringContainsString("\$widget['table']", $code);
        self::assertStringContainsString("\$widget['operation']", $code);
        self::assertStringContainsString("\$widget['chartType']", $code);
        self::assertStringContainsString("\$widget['dateGroup']", $code);

        $resolveStart = strpos($code, 'private function resolveWidgets');
        $dtoStart = strpos($code, 'private function kpiDto');
        self::assertNotFalse($resolveStart);
        self::assertNotFalse($dtoStart);
        $resolveCode = substr($code, $resolveStart, $dtoStart - $resolveStart);

        self::assertStringNotContainsString('$widget->get(', $resolveCode);
    }
    public function testGeneratedServiceTreatsConfiguredWidgetsAsArraysUntilDtoCreation(): void
    {
        $generator = new \App\Libraries\MyCrud\Dashboard\DashboardGenerator();
        $method = new \ReflectionMethod($generator, 'serviceClass');
        $method->setAccessible(true);

        $widget = [
            'id' => 'recent_film',
            'type' => 'recent',
            'table' => 'film',
            'modelShort' => 'FilmModel',
            'recentFields' => ['film_id', 'title'],
            'primaryKey' => 'film_id',
        ];

        $code = (string) $method->invoke($generator, '[]', [$widget]);

        self::assertStringContainsString("\$widget['type']", $code);
        self::assertStringContainsString("\$widget['table']", $code);
        self::assertStringNotContainsString('\$widget->get(', $code);
        self::assertStringNotContainsString('\$widget->type', $code);
        self::assertStringContainsString('new DashboardWidget(', $code);
    }

}
