<?php

namespace App\Libraries\MyCrud\Config;

use RuntimeException;

class CrudConfigRepository
{
    private string $directory;

    public function __construct(?string $directory = null)
    {
        $this->directory = rtrim($directory ?? WRITEPATH . 'mycrud', DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR;

        if (!is_dir($this->directory)
            && !mkdir($this->directory, 0755, true)
            && !is_dir($this->directory)
        ) {
            throw new RuntimeException(
                'Impossibile creare la directory delle configurazioni: ' . $this->directory
            );
        }
    }

    public function save(string $table, array $config): void
    {
        $path = $this->path($table);
        $json = json_encode(
            $config,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        if ($json === false || file_put_contents($path, $json, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile salvare la configurazione: ' . $path);
        }
    }

    public function load(string $table): ?array
    {
        $path = $this->path($table);

        if (!is_file($path)) {
            return null;
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? $decoded : null;
    }

    private function path(string $table): string
    {
        $safe = preg_replace('/[^a-zA-Z0-9_]/', '_', $table);

        return $this->directory . $safe . '.json';
    }
}
