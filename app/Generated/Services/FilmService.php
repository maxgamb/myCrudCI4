<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Extensions\FilmServiceExtension;
use App\Models\FilmModel;
use App\Validation\FilmRules;
use RuntimeException;

/**
 * Service applicativo per la risorsa `film`.
 *
 * Responsabilità:
 * - owns write use-cases only: create, update, delete and related creation;
 * - validates and normalizes application data before persistence;
 * - orchestrates writes across related Services without composing SQL;
 * - delegates transactions and persistence to the Model;
 * - invoca gli hook custom definiti nel ServiceExtension persistente;
 *
 * Queries remain the responsibility of FilmModel.
 */
final class FilmService
{
    use FilmServiceExtension;

    private const DATABASE_MANAGED_FIELDS = array (
  0 => 'last_update',
);
    private const NULLABLE_FOREIGN_KEY_FIELDS = array (
  0 => 'original_language_id',
);
    private const NULLABLE_FIELDS = array (
  0 => 'description',
  1 => 'release_year',
  2 => 'original_language_id',
  3 => 'length',
  4 => 'rating',
  5 => 'special_features',
  6 => 'uploads',
);

    public function __construct(private readonly FilmModel $model = new FilmModel())
    {
    }

    /**
     * Creates the parent resource for relation language_id.
     *
     * Delegates the write to LanguageService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createLanguageForLanguageId(array $payload): int|string
    {
        return (new LanguageService())->createRelated($payload);
    }

    /**
     * Creates the parent resource for relation original_language_id.
     *
     * Delegates the write to LanguageService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createLanguageForOriginalLanguageId(array $payload): int|string
    {
        return (new LanguageService())->createRelated($payload);
    }
    /**
     * Creates a target resource for many-to-many relation many__film_actor__film_id.
     *
     * Delegates target persistence to ActorService; pivot persistence remains in the current Model.
     *
     * @param array<string,mixed> $payload Target resource payload.
     * @return int|string Created target identifier.
     */
    private function createActorForManyFilmActorFilmId(array $payload): int|string
    {
        return (new ActorService())->createRelated($payload);
    }

    /**
     * Creates a target resource for many-to-many relation many__film_category__film_id.
     *
     * Delegates target persistence to CategoryService; pivot persistence remains in the current Model.
     *
     * @param array<string,mixed> $payload Target resource payload.
     * @return int|string Created target identifier.
     */
    private function createCategoryForManyFilmCategoryFilmId(array $payload): int|string
    {
        return (new CategoryService())->createRelated($payload);
    }
    /** @param array<string,mixed> $data */
    private function validateCreatePayload(array $data): void
    {
        $this->validatePayload($data, FilmRules::createRules(), FilmRules::messages(), 'Create validation failed.');
    }
    /** @param array<string,mixed> $data */
    private function validateUpdatePayload(int|string $id, array $data): void
    {
        $this->validatePayload($data, FilmRules::updateRules($id), FilmRules::messages(), 'Update validation failed.');
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
     * @param array<string, array<string, mixed>> $related Inline parent records.
     * @param array<string, list<int|string>> $manyToMany Many-to-many associations.
     * @param array<string, array<string,mixed>> $manyToManyNew New target records.
     * @return int|string Created record identifier.
     */
    public function create(
        array $data,
        array $related = [],
        array $manyToMany = [],
        array $manyToManyNew = []
    ): int|string {
        $data = $this->prepareData($data);
        $this->validateCreatePayload($data);
        $data = $this->beforeCreate($data);
        $transactional = $related !== [] || $manyToMany !== [] || $manyToManyNew !== [];
        if ($transactional) {
            $this->model->beginWriteTransaction();
        }

        try {
            if (isset($related['language_id']) && is_array($related['language_id'])) {
                $data['language_id'] = $this->createLanguageForLanguageId($related['language_id']);
            }
            if (isset($related['original_language_id']) && is_array($related['original_language_id'])) {
                $data['original_language_id'] = $this->createLanguageForOriginalLanguageId($related['original_language_id']);
            }
            if (isset($manyToManyNew['many__film_actor__film_id']) && is_array($manyToManyNew['many__film_actor__film_id'])) {
                $newId = $this->createActorForManyFilmActorFilmId($manyToManyNew['many__film_actor__film_id']);
                $manyToMany['many__film_actor__film_id'] ??= [];
                $manyToMany['many__film_actor__film_id'][] = $newId;
                $manyToMany['many__film_actor__film_id'] = array_values(array_unique(array_map('strval', $manyToMany['many__film_actor__film_id'])));
            }
            if (isset($manyToManyNew['many__film_category__film_id']) && is_array($manyToManyNew['many__film_category__film_id'])) {
                $newId = $this->createCategoryForManyFilmCategoryFilmId($manyToManyNew['many__film_category__film_id']);
                $manyToMany['many__film_category__film_id'] ??= [];
                $manyToMany['many__film_category__film_id'][] = $newId;
                $manyToMany['many__film_category__film_id'] = array_values(array_unique(array_map('strval', $manyToMany['many__film_category__film_id'])));
            }
            $id = $this->model->createRecord($data);
            if (isset($manyToMany['many__film_actor__film_id']) && is_array($manyToMany['many__film_actor__film_id'])) {
                // Persist this explicit pivot only after the main record has an identifier.
                $this->model->syncActorIdsForManyFilmActorFilmId($id, $manyToMany['many__film_actor__film_id']);
            }
            if (isset($manyToMany['many__film_category__film_id']) && is_array($manyToMany['many__film_category__film_id'])) {
                // Persist this explicit pivot only after the main record has an identifier.
                $this->model->syncCategoryIdsForManyFilmCategoryFilmId($id, $manyToMany['many__film_category__film_id']);
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
            if (isset($manyToManyNew['many__film_actor__film_id']) && is_array($manyToManyNew['many__film_actor__film_id'])) {
                $newId = $this->createActorForManyFilmActorFilmId($manyToManyNew['many__film_actor__film_id']);
                $manyToMany['many__film_actor__film_id'] ??= [];
                $manyToMany['many__film_actor__film_id'][] = $newId;
                $manyToMany['many__film_actor__film_id'] = array_values(array_unique(array_map('strval', $manyToMany['many__film_actor__film_id'])));
            }
            if (isset($manyToManyNew['many__film_category__film_id']) && is_array($manyToManyNew['many__film_category__film_id'])) {
                $newId = $this->createCategoryForManyFilmCategoryFilmId($manyToManyNew['many__film_category__film_id']);
                $manyToMany['many__film_category__film_id'] ??= [];
                $manyToMany['many__film_category__film_id'][] = $newId;
                $manyToMany['many__film_category__film_id'] = array_values(array_unique(array_map('strval', $manyToMany['many__film_category__film_id'])));
            }
            if (!$this->model->updateRecord($id, $data)) {
                throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Update failed.');
            }
            if (isset($manyToMany['many__film_actor__film_id']) && is_array($manyToMany['many__film_actor__film_id'])) {
                // Synchronize this explicit pivot through the current Model.
                $this->model->syncActorIdsForManyFilmActorFilmId($id, $manyToMany['many__film_actor__film_id']);
            }
            if (isset($manyToMany['many__film_category__film_id']) && is_array($manyToMany['many__film_category__film_id'])) {
                // Synchronize this explicit pivot through the current Model.
                $this->model->syncCategoryIdsForManyFilmCategoryFilmId($id, $manyToMany['many__film_category__film_id']);
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
        $rules = array_intersect_key(FilmRules::updateRules($id), $data);
        if ($rules !== []) {
            $this->validatePayload($data, $rules, FilmRules::messages(), 'Patch validation failed.');
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
        // Empty defaulted values are omitted; empty nullable columns become NULL.
        $nullable = array_fill_keys(self::NULLABLE_FIELDS, true);
        $defaulted = array_fill_keys([], true);
        foreach ($data as $field => $value) {
            if (!is_string($value) || trim($value) !== '') {
                continue;
            }
            if (isset($defaulted[$field])) {
                unset($data[$field]);
                continue;
            }
            if (isset($nullable[$field])) {
                $data[$field] = null;
            }
        }
        // HTML empty strings for nullable foreign keys are persisted as SQL NULL.
        foreach (self::NULLABLE_FOREIGN_KEY_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }
            $value = $data[$field];
            if ($value !== null && is_scalar($value) && trim((string) $value) === '') {
                $data[$field] = null;
            }
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
