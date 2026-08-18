<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

/**
 * Gestisce upload semplici per i CRUD generati.
 *
 * Il DB conserva soltanto il percorso relativo; i file vengono scritti sotto
 * FCPATH in una directory whitelistata dalla configurazione generata.
 */
final class CrudFileUploader
{
    /**
     * @param array{directory:string,allowedExtensions:list<string>,maxSizeKb:int,safeName:bool,allowRemove:bool,required:bool} $config
     * @return string|null Percorso relativo, stringa vuota per rimozione, null se invariato.
     */
    public static function store(
        ?UploadedFile $file,
        array $config,
        ?string $existingPath = null,
        bool $remove = false
    ): ?string {
        if ($remove && !empty($config['allowRemove'])) {
            if (!empty($config['required'])) {
                throw new RuntimeException('Il file è obbligatorio e non può essere rimosso senza sostituzione.');
            }
            // Rimuove il riferimento dal DB. Il file fisico viene conservato:
            // una delete prima del commit DB potrebbe causare perdita dati.
            return '';
        }

        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            if (!empty($config['required']) && ($existingPath === null || $existingPath === '')) {
                throw new RuntimeException('File obbligatorio non selezionato.');
            }
            return null;
        }

        if (!$file->isValid()) {
            throw new RuntimeException($file->getErrorString() ?: 'Upload non valido.');
        }

        $maxBytes = max(1, (int) ($config['maxSizeKb'] ?? 5120)) * 1024;
        if ($file->getSize() > $maxBytes) {
            throw new RuntimeException('Il file supera la dimensione massima consentita.');
        }

        $extension = strtolower((string) $file->getClientExtension());
        $allowed = array_values(array_filter(array_map(
            static fn ($value): string => strtolower(trim((string) $value)),
            (array) ($config['allowedExtensions'] ?? [])
        )));
        if ($allowed !== [] && !in_array($extension, $allowed, true)) {
            throw new RuntimeException('Estensione file non consentita.');
        }

        $directory = trim(str_replace('\\', '/', (string) ($config['directory'] ?? 'uploads')), '/');
        if ($directory === '' || str_contains($directory, '..')) {
            throw new RuntimeException('Directory upload non valida.');
        }

        $targetDirectory = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $directory);
        if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0775, true) && !is_dir($targetDirectory)) {
            throw new RuntimeException('Impossibile creare la directory di upload.');
        }

        $name = !empty($config['safeName']) ? $file->getRandomName() : $file->getName();
        $name = basename($name);
        if ($name === '') {
            $name = $file->getRandomName();
        }

        $file->move($targetDirectory, $name, true);

        // Il vecchio file non viene cancellato automaticamente prima del commit DB.
        // Lo sviluppatore può implementare una policy di cleanup nell'Extension.
        return $directory . '/' . $name;
    }
}