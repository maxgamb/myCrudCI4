<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\AgendaEntity;
use App\Models\{AgendaModel};
use RuntimeException;

/** Coordina la logica applicativa senza comporre query SQL. */
final class AgendaService
{
    public function __construct(private readonly AgendaModel $model = new AgendaModel())
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

    public function datatable(array $request): array
    {
        return $this->model->datatable($request);
    }

    public function relationOptions(): array
    {
        return $this->model->relationOptions();
    }

    public function loadHasMany(int|string $parentId): array
    {
        return $this->model->loadHasMany($parentId);
    }

    public function create(array $data): int
    {
        $id = $this->model->insert(new AgendaEntity($data), true);
        if ($id === false) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Inserimento non riuscito.');
        }
        return (int) $id;
    }

    public function update(int|string $id, array $data): void
    {
        $record = $this->find($id);
        $record->fill($data);
        $result = $this->model->save($record);
        if ($result === false) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    public function delete(int|string $id): void
    {
        if (!$this->model->delete($id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
    }

    public function deletedList(): array
    {
        return $this->model->getDeletedList();
    }

    public function restore(int|string $id): void
    {
        if (!$this->model->restoreRecord($id)) {
            throw new RuntimeException('Ripristino non riuscito.');
        }
    }

    public function forceDelete(int|string $id): void
    {
        if (!$this->model->delete($id, true)) {
            throw new RuntimeException('Eliminazione definitiva non riuscita.');
        }
    }
}
