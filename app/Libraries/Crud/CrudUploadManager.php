<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

/**
 * Storage condiviso degli upload generati da myCrudCI4.
 *
 * Tutti i file sono salvati in WRITEPATH/uploads senza sottocartelle con nome:
 * <table>_<id>_<field>_<random>.<ext>
 */
final class CrudUploadManager
{
    /**
     * @param array<string,array{type:string,required:bool}> $definitions
     * @return array<string,string> errors by field
     */
    public function validate(array $definitions, array $files, bool $isUpdate): array
    {
        $settings = $this->settings();
        $maxSize = max(1, (int) ($settings['maxSize'] ?? 5120));
        $imageExtensions = array_map('strtolower', (array) ($settings['imageExtensions'] ?? []));
        $fileExtensions = array_map('strtolower', (array) ($settings['fileExtensions'] ?? []));

        $errors = [];
        foreach ($definitions as $field => $definition) {
            $file = $files[$field] ?? null;
            $hasFile = $file instanceof UploadedFile && $file->getError() !== UPLOAD_ERR_NO_FILE;
            if (!$hasFile) {
                if (!$isUpdate && !empty($definition['required'])) {
                    $errors[$field] = 'Seleziona un file.';
                }
                continue;
            }
            if (!$file->isValid()) {
                $errors[$field] = $file->getErrorString();
                continue;
            }
            if ($file->getSizeByUnit('kb') > $maxSize) {
                $errors[$field] = 'The file exceeds the maximum size of ' . $maxSize . ' KB.';
                continue;
            }
            $extension = strtolower((string) $file->getExtension());
            $allowed = ($definition['type'] ?? 'file') === 'image'
                ? $imageExtensions
                : $fileExtensions;
            if ($allowed !== [] && !in_array($extension, $allowed, true)) {
                $errors[$field] = 'File type is not allowed.';
                continue;
            }
            if (($definition['type'] ?? 'file') === 'image' && @getimagesize($file->getTempName()) === false) {
                $errors[$field] = 'The uploaded file is not a valid image.';
            }
        }
        return $errors;
    }

    /**
     * @param array<string,array{type:string,required:bool}> $definitions
     * @return array<string,string> filenames to persist in the record
     */
    public function store(string $table, int|string $id, array $definitions, array $files): array
    {
        $settings = $this->settings();
        $directory = rtrim((string) ($settings['directory'] ?? (WRITEPATH . 'uploads')), DIRECTORY_SEPARATOR);
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Impossibile creare la directory configurata per gli upload.');
        }

        $stored = [];
        foreach ($definitions as $field => $definition) {
            $file = $files[$field] ?? null;
            if (!$file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            $extension = strtolower((string) $file->getExtension());
            $base = $this->safe($table) . '_' . $this->safe((string) $id) . '_' . $this->safe($field);
            $name = $base . '_' . bin2hex(random_bytes(4)) . ($extension !== '' ? '.' . $extension : '');
            $file->move($directory, $name);
            $stored[$field] = $name;
        }
        return $stored;
    }

    public function delete(?string $filename): void
    {
        $filename = basename(trim((string) $filename));
        if ($filename === '') {
            return;
        }
        $settings = $this->settings();
        $directory = rtrim((string) ($settings['directory'] ?? (WRITEPATH . 'uploads')), DIRECTORY_SEPARATOR);
        $path = $directory . DIRECTORY_SEPARATOR . $filename;
        if (is_file($path)) {
            @unlink($path);
        }
    }

    /** @return array<string,mixed> */
    private function settings(): array
    {
        $config = config('MyCrud');
        return is_array($config->upload ?? null) ? $config->upload : [];
    }

    private function safe(string $value): string
    {
        $value = preg_replace('/[^A-Za-z0-9_-]+/', '_', $value) ?? '';
        return trim($value, '_') ?: 'file';
    }
}
