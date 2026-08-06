<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\AgenzieEntity;
use App\Models\AgenzieModel;
use RuntimeException;

/** Coordina la logica applicativa senza comporre query SQL. */
final class AgenzieService
{
    public function __construct(private readonly AgenzieModel $model = new AgenzieModel())
    {
    }

    public function find(int|string $id): object
    {
        $record = $this->model->getDetail($id);
        if (!is_object($record)) {
            throw new RuntimeException('Record non trovato.');
        }
        return $record;
    }

    public function listPage(
        array $filters,
        int $page,
        int $perPage,
        string $sort,
        string $direction
    ): array {
        return $this->model->getListPage($filters, $page, $perPage, $sort, $direction);
    }

    public function csvRows(array $filters, int $limit, int|string|null $after = null): array
    {
        return $this->model->getCsvRows($filters, $limit, $after);
    }

    public function countCsvRows(array $filters): int
    {
        return $this->model->countCsvRows($filters);
    }

    /** @return list<string> */
    public function csvFields(): array
    {
        return $this->model->csvFields();
    }

    public function relationOptions(): array
    {
        return $this->model->relationOptions();
    }

    public function loadHasMany(int|string $parentId): array
    {
        return $this->model->loadHasMany($parentId);
    }

    public function create(array $data): int|string
    {
        $id = $this->model->insert(new AgenzieEntity($data), true);
        if ($id === false) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Inserimento non riuscito.');
        }
        return is_int($id) ? $id : (string) $id;
    }

    public function update(int|string $id, array $data): void
    {
        // update() applica allowedFields e funziona sia con returnType object
        // sia con Entity, senza usare il record arricchito dai JOIN.
        if (!$this->model->update($id, $data)) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    public function delete(int|string $id): void
    {
        if (!$this->model->delete($id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
    }

}
