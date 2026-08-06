<?php

namespace App\Services;

use App\Entities\AppIpEntity;
use App\Models\{AppIpModel};
use RuntimeException;

class AppIpService
{
    private AppIpModel $model;

    public function __construct(?AppIpModel $model = null)
    {
        $this->model = $model ?? new AppIpModel();
    }

    public function list(array $filters = []): array
    {
        return $this->model->getList($filters);
    }

    public function find(int|string $id): object
    {
        $record = $this->model->getDetail($id);

        if (!is_object($record)) {
            throw new RuntimeException('Record non trovato.');
        }

        return $record;
    }

    public function create(array $data): int
    {
        $record = new AppIpEntity($data);
        $id = $this->model->insert($record, true);

        if ($id === false) {
            throw new RuntimeException(
                implode(' ', $this->model->errors()) ?: 'Inserimento non riuscito.'
            );
        }

        return (int) $id;
    }

    public function update(int|string $id, array $data): void
    {
        $record = $this->find($id);
        $record->fill($data);
        $result = $this->model->save($record);

        if ($result === false) {
            throw new RuntimeException(
                implode(' ', $this->model->errors()) ?: 'Aggiornamento non riuscito.'
            );
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

    public function loadHasMany(int|string $parentId, array $relations): array
    {
        $result = [];

        foreach ($relations as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $rows = $this->model->getRelatedChildren(
                (string) $relation['childTable'],
                (string) $relation['foreignKey'],
                $parentId,
                (string) ($relation['primaryKey'] ?? ''),
                (int) ($relation['limit'] ?? 20)
            );

            $count = !empty($relation['showCount'])
                ? $this->model->countRelatedChildren(
                    (string) $relation['childTable'],
                    (string) $relation['foreignKey'],
                    $parentId
                )
                : count($rows);

            $result[$key] = [
                'rows'  => $rows,
                'count' => $count,
            ];
        }

        return $result;
    }

    public function model(): AppIpModel
    {
        return $this->model;
    }
}
