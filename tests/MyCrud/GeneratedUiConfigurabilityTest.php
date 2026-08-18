<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use App\Libraries\MyCrud\Generators\GeneratorTrait;
use PHPUnit\Framework\TestCase;

final class GeneratedUiConfigurabilityTest extends TestCase
{
    public function testBuilderFieldWidthsComeFromProjectConfig(): void
    {
        $config = (string) file_get_contents(APPPATH . 'Config/MyCrud.php');
        $builder = (string) file_get_contents(APPPATH . 'Views/mycrud/builder.php');

        self::assertStringContainsString('bootstrapFieldWidths', $config);
        self::assertStringContainsString('defaultBootstrapFieldWidth', $config);
        self::assertStringContainsString("config('MyCrud')->bootstrapFieldWidths", $builder);
        self::assertStringNotContainsString('for ($width = 12; $width >= 1; $width--)', $builder);
    }

    public function testRelationPanelWidthsComeFromProjectConfig(): void
    {
        $config = (string) file_get_contents(APPPATH . 'Config/MyCrud.php');
        $generator = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Generators/Views/FormViewGenerator.php');

        self::assertStringContainsString('relationPanelWidths', $config);
        self::assertStringContainsString("relation['formWidth']", $generator);
        self::assertStringContainsString("configuredRelationWidth('manyToMany', 12)", $generator);
        self::assertStringContainsString("relationGridClass('relatedCreateField', 6)", $generator);
        self::assertStringContainsString("relationGridClass('manyToManyRelatedCreateField', 6)", $generator);
    }

    public function testManyToManyPrimaryActionsShareOneInputGroupAndBuilderWidth(): void
    {
        $builder = (string) file_get_contents(APPPATH . 'Views/mycrud/builder.php');
        $generator = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Generators/Views/FormViewGenerator.php');
        $configBuilder = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Core/ConfigBuilder.php');

        self::assertStringContainsString('[formWidth]', $builder);
        self::assertStringContainsString("'formWidth'", $configBuilder);
        self::assertStringContainsString('crud-many-primary-actions', $generator);
        self::assertStringContainsString('Search and select {$title}', $generator);
        self::assertStringContainsString('New {$title}', $generator);
        self::assertStringContainsString('input-group input-group-sm mb-2 crud-many-primary-actions', $generator);
    }

    public function testManyToManyFormWidthIsPersistedAcrossRegeneration(): void
    {
        $repository = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Config/CrudConfigRepository.php');
        $configBuilder = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Core/ConfigBuilder.php');
        $generator = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Generators/Views/FormViewGenerator.php');

        self::assertStringContainsString("'formWidth' => \$this->normalizeBootstrapWidth(", $repository);
        self::assertStringContainsString('bootstrapFieldWidths', $repository);
        self::assertStringContainsString("\$relation['formWidth']", $configBuilder);
        self::assertStringContainsString("\$relation['formWidth']", $generator);
    }


    public function testRelatedCreateOffcanvasWidthComesFromProjectConfig(): void
    {
        $config = (string) file_get_contents(APPPATH . 'Config/MyCrud.php');
        $generator = (string) file_get_contents(APPPATH . 'Libraries/MyCrud/Generators/Views/FormViewGenerator.php');

        self::assertStringContainsString('relationOffcanvasWidth = 640', $config);
        self::assertStringContainsString("config('MyCrud')->relationOffcanvasWidth", $generator);
        self::assertStringContainsString('crud-related-create-panel', $generator);
        self::assertStringContainsString('crud-many-related-create-panel', $generator);
        self::assertGreaterThanOrEqual(2, substr_count($generator, '--bs-offcanvas-width: min({$offcanvasWidth}px, 100vw);'));
        self::assertStringContainsString("private function buildManyToManyRelatedCreateFields", $generator);
        self::assertGreaterThanOrEqual(2, substr_count($generator, '$offcanvasWidth = $this->relationOffcanvasWidth();'));
    }

    public function testGeneratedViewTemplatesExposeStableHtmlMarkers(): void
    {
        $templates = [
            APPPATH . 'Libraries/MyCrud/Templates/views/form.tpl',
            APPPATH . 'Libraries/MyCrud/Templates/views/create.tpl',
            APPPATH . 'Libraries/MyCrud/Templates/views/edit.tpl',
            APPPATH . 'Libraries/MyCrud/Templates/views/index.tpl',
            APPPATH . 'Libraries/MyCrud/Templates/views/detail.tpl',
        ];

        foreach ($templates as $template) {
            $php = (string) file_get_contents($template);
            self::assertStringContainsString('<!-- mycrud:start ', $php, $template);
            self::assertStringContainsString('<!-- mycrud:end ', $php, $template);
        }
    }

    public function testGeneratedPhpFormattingIsWhitespaceCompact(): void
    {
        $formatter = new class {
            use GeneratorTrait;

            public function formatForTest(string $relativePath, string $content): string
            {
                return $this->formatGeneratedContent($relativePath, $content);
            }
        };

        $input = "<?php  \n\n\n\nfunction demo(): void {    \n}\t\n\n\n\n";
        $formatted = $formatter->formatForTest('Generated/Models/DemoModel.php', $input);

        self::assertSame("<?php\n\nfunction demo(): void {\n}\n", $formatted);
        self::assertDoesNotMatchRegularExpression('/[ \t]+$/m', $formatted);
        self::assertDoesNotMatchRegularExpression('/\n{3,}/', $formatted);
        self::assertStringEndsWith("\n", $formatted);
    }
}
