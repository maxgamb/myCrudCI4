<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\Naming;

/** Generates a separate language file for each CRUD. */
final class LanguageGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $languageFile = (string) ($config['languageFile'] ?? Naming::studly((string) $config['table']));
        $labels = [];

        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            $label = trim((string) ($field['label'] ?? ''));
            if ($label === '') {
                $label = trim((string) ($field['defaultLabel'] ?? ''));
            }
            if ($label === '') {
                $label = Naming::human((string) $name);
            }
            $labels[(string) $name] = $label;
        }

        $labels['filtersSummary'] = trim((string) ($config['list']['filtersSummary'] ?? 'Search filters')) ?: 'Search filters';
        $labels['actions'] = 'Azioni';
        $labels['recordsFound'] = 'Record trovati';
        $labels['noRecords'] = 'No record trovato.';

        $content = "<?php\n\ndeclare(strict_types=1);\n\nreturn " . var_export($labels, true) . ";\n";

        return [
            'it' => $this->writeGenerated("Generated/Language/it/{$languageFile}.php", $content, $force),
            'en' => $this->writeGenerated("Generated/Language/en/{$languageFile}.php", $content, $force),
        ];
    }
}
