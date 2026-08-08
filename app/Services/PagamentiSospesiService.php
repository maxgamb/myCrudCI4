<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\PagamentiSospesiEntity;
use App\Models\PagamentiSospesiModel;
use RuntimeException;

/** Coordina la logica applicativa senza comporre query SQL. */
final class PagamentiSospesiService
{
    private const PASSWORD_FIELDS = array (
);
    private const AUTOMATIC_DATE_FIELDS = array (
);

    public function __construct(private readonly PagamentiSospesiModel $model = new PagamentiSospesiModel())
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

    public function exportRows(array $filters, int $limit, int|string|null $after = null): array
    {
        return $this->model->getExportRows($filters, $limit, $after);
    }

    public function countExportRows(array $filters): int
    {
        return $this->model->countExportRows($filters);
    }

    /** @return list<string> */
    public function exportFields(): array
    {
        return $this->model->exportFields();
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

    /** @return list<array{id:string,text:string}> */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        return $this->model->searchRelationOptions($field, $query, $limit);
    }

    /** Restituisce una FK valida con la relativa descrizione. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        return $this->model->relationOptionById($field, $id);
    }

    public function loadHasMany(int|string $parentId): array
    {
        return $this->model->loadHasMany($parentId);
    }

    public function create(array $data): int|string
    {
        $data = $this->prepareData($data, false);
        $id = $this->model->insert(new PagamentiSospesiEntity($data), true);
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
