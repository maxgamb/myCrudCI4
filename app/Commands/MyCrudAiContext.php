<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\AI\AiProjectContextGenerator;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/** Generates context files that describe the project to AI agents. */
final class MyCrudAiContext extends BaseCommand
{
    protected $group = 'myCrudCI4';
    protected $name = 'mycrud:ai-context';
    protected $description = 'Generates AI_PROJECT_CONTEXT.md and the project/CRUD AI map.';
    protected $usage = 'mycrud:ai-context [table]';

    protected $arguments = [
        'table' => 'Optional CRUD. Without a table, regenerates the complete project context.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));

        try {
            $generator = new AiProjectContextGenerator();
            $result = $table === ''
                ? $generator->generateProject()
                : $generator->generateCrud($table);
        } catch (Throwable $exception) {
            CLI::error($exception->getMessage());
            return EXIT_ERROR;
        }

        CLI::write(
            $table === ''
                ? 'Project AI context generated.'
                : 'CRUD AI context generated: ' . $table,
            'green'
        );

        foreach ((array) ($result['files'] ?? []) as $file) {
            CLI::write('✓ ' . $this->relativePath((string) $file), 'cyan');
        }

        if ($table === '') {
            CLI::newLine();
            CLI::write('Istruzione consigliata per l’agente IA:', 'yellow');
            CLI::write('Leggi AI_PROJECT_CONTEXT.md prima di modificare il progetto.');
            CLI::write('Se modifichi myCrudCI4 stesso, leggi CONTRIBUTING.md e docs/development/ARCHITECTURE_RULES.md.');
            CLI::write('Se lavori su un CRUD, leggi anche docs/ai/crud/<table>.md.');
            CLI::write('Per personalizzazioni Standard/Full usa app/Services/Extensions/<Entity>ServiceExtension.php; non modificare app/Generated/.');
            CLI::write('Mantieni query nei Model e relazioni/scritture cross-resource come chiamate esplicite a Model/Service concreti.');
        }

        return EXIT_SUCCESS;
    }

    private function relativePath(string $path): string
    {
        $root = rtrim(str_replace('\\', '/', ROOTPATH), '/');
        $normalized = str_replace('\\', '/', $path);

        return str_starts_with($normalized, $root . '/')
            ? substr($normalized, strlen($root) + 1)
            : $normalized;
    }
}
