<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Extensions\CategoryServiceExtension;
use App\Models\CategoryModel;
use App\Validation\CategoryRules;
use RuntimeException;

/**
 * Service applicativo per la risorsa `category`.
 *
 * Responsabilità:
 * - owns write use-cases only: create, update, delete and related creation;
 * - validates and normalizes application data before persistence;
 * - orchestrates writes across related Services without composing SQL;
 * - delegates transactions and persistence to the Model;
 * - invoca gli hook custom definiti nel ServiceExtension persistente;
 *
 * Queries remain the responsibility of CategoryModel.
 */
final class CategoryService
{
    use CategoryServiceExtension;

    private const DATABASE_MANAGED_FIELDS = array (
  0 => 'last_update',
);

    public function __construct(private readonly CategoryModel $model = new CategoryModel())
    {
    }

    /**
     * Creates a target resource for many-to-many relation many__film_category__category_id.
     *
     * Delegates target persistence to FilmService; pivot persistence remains in the current Model.
     *
     * @param array<string,mixed> $payload Target resource payload.
     * @return int|string Created target identifier.
     */
    private function createFilmForManyFilmCategoryCategoryId(array $payload): int|string
    {
        return (new FilmService())->createRelated($payload);
    }
    /** @param array<string,mixed> $data */
    private function validateCreatePayload(array $data): void
    {
        $this->validatePayload($data, CategoryRules::createRules(), CategoryRules::messages(), 'Create validation failed.');
    }
    /** @param array<string,mixed> $data */
    private function validateUpdatePayload(int|string $id, array $data): void
    {
        $this->validatePayload($data, CategoryRules::updateRules($id), CategoryRules::messages(), 'Update validation failed.');
    }
    /**
     * Runs the generated Rules for this resource.
     *
     * @param array<string,mixed> $data
     * @param array<string,mixed> $rules Generated validation rules.
     * @param array<string,string|array<string,string>> $messages Generated custom validation messages.
     * @param string $fallback Error used when the validator exposes no field messages.
     * @throws RuntimeException When validation fails.
     */
    private function validatePayload(array $data, array $rules, array $messages, string $fallback): void
    {
        $validation = service('validation');
        $validation->reset();
        $validation->setRules($rules, $messages);

        if ($validation->run($data)) {
            return;
        }

        $errors = $validation->getErrors();
        $message = $errors === []
            ? $fallback
            : implode(' ', array_values(array_map('strval', $errors)));

        throw new RuntimeException($message);
    }
    /**
     * Creates this resource when another generated Service needs it as a parent.
     *
     * Validation, normalization and extension hooks remain owned by this Service;
     * persistence remains owned by the current Model.
     *
     * @param array<string,mixed> $data
     * @return int|string
     */
    public function createRelated(array $data): int|string
    {
        $data = $this->prepareData($data);
        $this->validateCreatePayload($data);
        $data = $this->beforeCreate($data);
        $id = $this->model->insertRelatedPayload($data);
        $this->afterCreate($id, $data);

        return $id;
    }
    /**
     * Creates this resource.
     *
     * @param array<string, mixed> $data Main record data.
     * @param array<string, list<int|string>> $manyToMany Many-to-many associations.
     * @param array<string, array<string,mixed>> $manyToManyNew New target records.
     * @return int|string Created record identifier.
     */
    public function create(
        array $data,
        array $manyToMany = [],
        array $manyToManyNew = []
    ): int|string {
        $data = $this->prepareData($data);
        $this->validateCreatePayload($data);
        $data = $this->beforeCreate($data);
        $transactional = $manyToMany !== [] || $manyToManyNew !== [];
        if ($transactional) {
            $this->model->beginWriteTransaction();
        }

        try {
            if (isset($manyToManyNew['many__film_category__category_id']) && is_array($manyToManyNew['many__film_category__category_id'])) {
                $newId = $this->createFilmForManyFilmCategoryCategoryId($manyToManyNew['many__film_category__category_id']);
                $manyToMany['many__film_category__category_id'] ??= [];
                $manyToMany['many__film_category__category_id'][] = $newId;
                $manyToMany['many__film_category__category_id'] = array_values(array_unique(array_map('strval', $manyToMany['many__film_category__category_id'])));
            }
            $id = $this->model->createRecord($data);
            if (isset($manyToMany['many__film_category__category_id']) && is_array($manyToMany['many__film_category__category_id'])) {
                // Persist this explicit pivot only after the main record has an identifier.
                $this->model->syncFilmIdsForManyFilmCategoryCategoryId($id, $manyToMany['many__film_category__category_id']);
            }

            if ($transactional) {
                if (!$this->model->writeTransactionStatus()) {
                    throw new RuntimeException('Related create transaction failed.');
                }
                $this->model->commitWriteTransaction();
            }
        } catch (\Throwable $e) {
            if ($transactional) {
                $this->model->rollbackWriteTransaction();
            }
            throw $e;
        }
        $this->afterCreate($id, $data);

        return $id;
    }
    /**
     * Updates this resource.
     *
     * Many-to-many parameters are generated only when this table actually uses them.
     *
     * @param int|string $id Record identifier.
     * @param array<string, mixed> $data Main record data.
     * @throws RuntimeException If validation or persistence cannot be completed.
     */
    public function update(
        int|string $id,
        array $data,
        array $manyToMany = [],
        array $manyToManyNew = []
    ): void {
        $data = $this->prepareData($data);
        $this->validateUpdatePayload($id, $data);
        $data = $this->beforeUpdate($id, $data);
        $transactional = $manyToMany !== [] || $manyToManyNew !== [];
        if ($transactional) {
            $this->model->beginWriteTransaction();
        }

        try {
            if (isset($manyToManyNew['many__film_category__category_id']) && is_array($manyToManyNew['many__film_category__category_id'])) {
                $newId = $this->createFilmForManyFilmCategoryCategoryId($manyToManyNew['many__film_category__category_id']);
                $manyToMany['many__film_category__category_id'] ??= [];
                $manyToMany['many__film_category__category_id'][] = $newId;
                $manyToMany['many__film_category__category_id'] = array_values(array_unique(array_map('strval', $manyToMany['many__film_category__category_id'])));
            }
            if (!$this->model->updateRecord($id, $data)) {
                throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Update failed.');
            }
            if (isset($manyToMany['many__film_category__category_id']) && is_array($manyToMany['many__film_category__category_id'])) {
                // Synchronize this explicit pivot through the current Model.
                $this->model->syncFilmIdsForManyFilmCategoryCategoryId($id, $manyToMany['many__film_category__category_id']);
            }
            if ($transactional) {
                if (!$this->model->writeTransactionStatus()) {
                    throw new RuntimeException('Many-to-many update transaction failed.');
                }
                $this->model->commitWriteTransaction();
            }
        } catch (\Throwable $e) {
            if ($transactional) {
                $this->model->rollbackWriteTransaction();
            }
            throw $e;
        }
        $this->afterUpdate($id, $data);
    }
    /**
     * Applies a partial REST update using only rules for fields actually received.
     *
     * The API boundary already filters writable fields; this Service remains
     * authoritative for normalization, validation, hooks, and persistence.
     *
     * @param int|string $id Record identifier.
     * @param array<string,mixed> $data Partial application payload.
     * @throws RuntimeException If validation or persistence fails.
     */
    public function patch(int|string $id, array $data): void
    {
        $data = $this->prepareData($data);
        $rules = array_intersect_key(CategoryRules::updateRules($id), $data);
        if ($rules !== []) {
            $this->validatePayload($data, $rules, CategoryRules::messages(), 'Patch validation failed.');
        }
        $data = $this->beforeUpdate($id, $data);
        if (!$this->model->updateRecord($id, $data)) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Patch failed.');
        }
        $this->afterUpdate($id, $data);
    }
    /**
     * Normalizes only the features that are present in this table's schema.
     * No query is executed here.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function prepareData(array $data): array
    {
        // Database-managed columns are never accepted from application input.
        foreach (self::DATABASE_MANAGED_FIELDS as $field) {
            unset($data[$field]);
        }
        return $data;
    }
    /**
     * Deletes the record according to the Model soft-delete policy.
     *
     * @throws RuntimeException If deletion fails.
     */
    public function delete(int|string $id): void
    {
        $this->beforeDelete($id);
        if (!$this->model->delete($id)) {
            throw new RuntimeException('Delete failed.');
        }
        $this->model->clearListCountCache();
        $this->afterDelete($id);
    }
}
