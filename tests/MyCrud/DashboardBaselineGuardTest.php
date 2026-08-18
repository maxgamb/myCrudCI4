<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class DashboardBaselineGuardTest extends TestCase
{
    public function testGeneratorKeepsConfigurationArrayAndRuntimeDtoBoundariesSeparate(): void
    {
        $path = APPPATH . 'Libraries/MyCrud/Dashboard/DashboardGenerator.php';
        $code = file_get_contents($path);
        self::assertIsString($code);

        $resolveStart = strpos($code, 'private function resolveWidgets');
        $dtoStart = strpos($code, 'private function kpiDto');
        self::assertNotFalse($resolveStart);
        self::assertNotFalse($dtoStart);
        $resolveCode = substr($code, $resolveStart, $dtoStart - $resolveStart);

        self::assertStringContainsString("\$widget['table']", $resolveCode);
        self::assertStringNotContainsString('$widget->get(', $resolveCode);
        self::assertStringNotContainsString('$widget->type', $resolveCode);
    }

    public function testGeneratedRecentWidgetUsesConcreteModelAndNoRuntimeResolver(): void
    {
        $generator = new \App\Libraries\MyCrud\Dashboard\DashboardGenerator();
        $method = new \ReflectionMethod($generator, 'serviceClass');
        $method->setAccessible(true);

        $widget = [
            'id' => 'recent_film',
            'type' => 'recent',
            'table' => 'film',
            'modelShort' => 'FilmModel',
            'recentFields' => ['film_id', 'title', 'language_id'],
            'recentRelations' => [
                'language_id' => [
                    'findMethod' => 'findLanguageIdOption',
                ],
            ],
            'primaryKey' => 'film_id',
        ];

        $service = (string) $method->invoke($generator, '[]', [$widget]);

        self::assertStringContainsString('use App\\Models\\FilmModel;', $service);
        self::assertStringContainsString('$model = new FilmModel();', $service);
        self::assertStringContainsString('$model->findLanguageIdOption($relationId);', $service);
        self::assertStringNotContainsString('$modelClass', $service);
        self::assertStringNotContainsString('new $modelClass', $service);
        self::assertStringNotContainsString('class_exists(', $service);
    }

    public function testGeneratedControllerAndViewStayObjectFirst(): void
    {
        $generator = new \App\Libraries\MyCrud\Dashboard\DashboardGenerator();

        $controllerMethod = new \ReflectionMethod($generator, 'controllerClass');
        $controllerMethod->setAccessible(true);
        $controller = (string) $controllerMethod->invoke($generator, 'Dashboard');

        $viewMethod = new \ReflectionMethod($generator, 'viewFile');
        $viewMethod->setAccessible(true);
        $view = (string) $viewMethod->invoke($generator);

        self::assertStringContainsString("'title' => \$dashboard->title", $controller);
        self::assertStringNotContainsString('$dashboard[', $controller);
        self::assertStringNotContainsString('->toArray()', $controller);

        self::assertStringContainsString('$dashboard->widgets', $view);
        self::assertStringContainsString('$widget->type', $view);
        self::assertStringNotContainsString("\$widget['type']", $view);
    }
}
