<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/** Generates a dedicated API validation class by delegating to CRUD rules. */
final class ApiValidationGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $apiRules = (string) $config['classes']['apiRules'];
        $webRules = (string) $config['classes']['rules'];

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class {$apiRules}
{
    public static function createRules(): array
    {
        return {$webRules}::createRules();
    }

    public static function updateRules(int|string \$id): array
    {
        return {$webRules}::updateRules(\$id);
    }

    public static function messages(): array
    {
        return {$webRules}::messages();
    }
}

PHP;

        return $this->writeGenerated("Generated/Validation/{$apiRules}.php", $content, $force);
    }
}
