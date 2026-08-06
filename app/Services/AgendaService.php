<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\AgendaEntity;
use App\Models\AgendaModel;
use RuntimeException;

/** Coordina la logica applicativa senza comporre query SQL. */
final class AgendaService
{
    private const PASSWORD_FIELDS = array (
);
    private const AUTOMATIC_DATE_FIELDS = array (
  'cancella_data_record' => 'Y-m-d H:i:s',
  'preno_data_record' => 'Y-m-d H:i:s',
);

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

    /** Elenco REST paginato con filtri e ordinamento autorizzati. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        return $this->model->apiList($query, $filterable, $sortable);
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
        $data = $this->prepareData($data, false);
        $id = $this->model->insert(new AgendaEntity($data), true);
        if ($id === false) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Inserimento non riuscito.');
        }
        $this->model->clearListCountCache();
        return is_int($id) ? $id : (string) $id;
    }

    public function update(int|string $id, array $data): void
    {
        $data = $this->prepareData($data, true);
        // update() applica allowedFields e funziona sia con returnType object
        // sia con Entity, senza usare il record arricchito dai JOIN.
        if (!$this->model->update($id, $data)) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    private function prepareData(array $data, bool $isUpdate): array
    {
        if (!$isUpdate) {
            foreach (self::AUTOMATIC_DATE_FIELDS as $field => $format) {
                if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                    $data[$field] = date($format);
                }
            }
        }

        foreach (self::PASSWORD_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }

            $value = trim((string) $data[$field]);
            if ($value === '') {
                if ($isUpdate) {
                    unset($data[$field]);
                }
                continue;
            }

            $data[$field] = password_hash($value, PASSWORD_DEFAULT);
        }

        return $data;
    }

    public function delete(int|string $id): void
    {
        if (!$this->model->delete($id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
        $this->model->clearListCountCache();
    }

}
