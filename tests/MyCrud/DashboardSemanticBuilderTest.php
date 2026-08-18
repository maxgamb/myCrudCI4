<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class DashboardSemanticBuilderTest extends TestCase
{
    public function testGeneratorBuildsSemanticAutomaticTitlesFromResolvedLabels(): void
    {
        $path = APPPATH . 'Libraries/MyCrud/Dashboard/DashboardGenerator.php';
        $code = file_get_contents($path);
        self::assertIsString($code);

        self::assertStringContainsString("'SUM' => 'Total'", $code);
        self::assertStringContainsString("'AVG' => 'Average'", $code);
        self::assertStringContainsString("'kpi_aggregate' => trim(\$operationLabel . ' ' . \$valueLabel)", $code);
        self::assertStringContainsString("\$tableLabel . ' Count by ' . \$groupLabel", $code);
        self::assertStringContainsString("'title' => trim((string) (\$widget['title'] ?? '')) ?: \$automaticTitle", $code);
    }

    public function testBuilderUsesHumanLabelsAndStaticChartQualityGuidance(): void
    {
        $builderPath = APPPATH . 'Views/mycrud/dashboard_builder.php';
        $builder = file_get_contents($builderPath);
        self::assertIsString($builder);

        self::assertStringContainsString('const automaticTitle = () => {', $builder);
        self::assertStringContainsString("title.placeholder = `Automatic: \${automaticTitle()}`", $builder);
        self::assertStringContainsString("meta.labels?.[value] || value", $builder);
        self::assertStringContainsString('syncChartGuidance', $builder);
        self::assertStringContainsString('is the primary key: grouping by it usually creates one category per record.', $builder);
        self::assertStringContainsString('is a relation field and may create many categories', $builder);
        self::assertStringContainsString('grouping by exact values can fragment the chart', $builder);
        self::assertStringContainsString('will normally contain a single category', $builder);

        $widgetPath = APPPATH . 'Views/mycrud/dashboard_widget.php';
        $widget = file_get_contents($widgetPath);
        self::assertIsString($widget);
        self::assertStringContainsString('data-chart-guidance', $widget);
        self::assertStringContainsString("\$fieldLabels[\$fieldName] ?? \$fieldName", $widget);
    }
}
