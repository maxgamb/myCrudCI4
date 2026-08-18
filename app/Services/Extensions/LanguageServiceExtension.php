<?php

declare(strict_types=1);

namespace App\Services\Extensions;

/**
 * CUSTOM SERVICE EXTENSION
 *
 * Questo file viene creato da myCrudCI4 solo se manca e NON viene mai
 * sovrascritto, neppure usando "Sovrascrivi file esistenti".
 *
 * Inserisci qui la logica applicativa specifica che non deve andare persa
 * quando il CRUD viene rigenerated. Mantieni le query nel Model e usa questo
 * trait per orchestrazione, normalizzazioni e side-effect applicativi.
 */
trait LanguageServiceExtension
{
    /**
     * Executed before creation.
     * Puoi modificare i dati e restituire l'array aggiornato.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function beforeCreate(array $data): array
    {
        // CUSTOM: logica prima del create.
        return $data;
    }

    /**
     * Eseguito dopo che il record è stato creato con successo.
     *
     * @param array<string, mixed> $data
     */
    protected function afterCreate(int|string $id, array $data): void
    {
        // CUSTOM: logica dopo il create.
    }

    /**
     * Executed before update.
     * Puoi modificare i dati e restituire l'array aggiornato.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function beforeUpdate(int|string $id, array $data): array
    {
        // CUSTOM: logica prima dell'update.
        return $data;
    }

    /**
     * Eseguito dopo che il record è stato aggiornato con successo.
     *
     * @param array<string, mixed> $data
     */
    protected function afterUpdate(int|string $id, array $data): void
    {
        // CUSTOM: logica dopo l'update.
    }

    /** Executed before record deletion. */
    protected function beforeDelete(int|string $id): void
    {
        // CUSTOM: logica prima del delete.
    }

    /** Eseguito dopo che il record è stato eliminato con successo. */
    protected function afterDelete(int|string $id): void
    {
        // CUSTOM: logica dopo il delete.
    }
}
