<?php
namespace App\Libraries\MyCrud\Template;

use RuntimeException;

final class TemplateEngine
{
    private string $root;

    public function __construct(?string $root = null)
    {
        $this->root = rtrim($root ?? dirname(__DIR__) . '/Templates', DIRECTORY_SEPARATOR);
    }

    /** @param array<string, scalar|null> $variables */
    public function render(string $template, array $variables = []): string
    {
        $path = $this->resolvePath($template);
        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException('Impossibile leggere il template: ' . $path);
        }

        foreach ($variables as $name => $value) {
            if (!is_scalar($value) && $value !== null) {
                throw new RuntimeException('Il placeholder ' . $name . ' deve essere scalare.');
            }

            $content = str_replace(
                '{{' . strtoupper((string) $name) . '}}',
                (string) $value,
                $content
            );
        }

        if (preg_match_all('/\{\{[A-Z0-9_]+\}\}/', $content, $matches) > 0) {
            throw new RuntimeException(
                'Placeholder non risolti nel template ' . $template . ': '
                . implode(', ', array_unique($matches[0]))
            );
        }

        return $this->normalize($content);
    }

    private function resolvePath(string $template): string
    {
        $template = ltrim(
            str_replace(['\\', '/'], DIRECTORY_SEPARATOR, trim($template)),
            DIRECTORY_SEPARATOR
        );

        if ($template === '' || str_contains($template, '..')) {
            throw new RuntimeException('Nome template non valido: ' . $template);
        }

        $path = $this->root . DIRECTORY_SEPARATOR . $template;

        if (!is_file($path)) {
            throw new RuntimeException('Template myCrud non trovato: ' . $path);
        }

        return $path;
    }

    private function normalize(string $content): string
    {
        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $lines = array_map(static fn (string $line): string => rtrim($line), explode("\n", $content));
        $content = implode("\n", $lines);
        $content = preg_replace("/\n{3,}/", "\n\n", $content) ?? $content;

        return trim($content) . PHP_EOL;
    }
}
