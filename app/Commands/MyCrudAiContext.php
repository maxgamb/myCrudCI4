<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\AI\AiProjectContextGenerator;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/** Genera i file di contesto che descrivono il progetto agli agenti IA. */
final class MyCrudAiContext extends BaseCommand
{
    protected $group = 'myCrudGpt';
    protected $name = 'mycrud:ai-context';
    protected $description = 'Genera AI_PROJECT_CONTEXT.md e la mappa IA del progetto/CRUD.';
    protected $usage = 'mycrud:ai-context [table]';

    protected $arguments = [
        'table' => 'CRUD opzionale. Senza tabella rigenera il contesto completo del progetto.',
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
                ? 'Contesto IA progetto generato.'
                : 'Contesto IA CRUD generato: ' . $table,
            'green'
        );

        foreach ((array) ($result['files'] ?? []) as $file) {
            CLI::write('✓ ' . $this->relativePath((string) $file), 'cyan');
        }

        if ($table === '') {
            CLI::newLine();
            CLI::write('Istruzione consigliata per l’agente IA:', 'yellow');
            CLI::write('Leggi AI_PROJECT_CONTEXT.md prima di modificare il progetto.');
            CLI::write('Se lavori su un CRUD, leggi anche docs/ai/crud/<tabella>.md.');
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
