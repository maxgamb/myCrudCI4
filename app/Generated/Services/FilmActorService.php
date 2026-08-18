<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\FilmActorModel;
use App\Validation\FilmActorRules;
use RuntimeException;

/**
 * Write Service for `film_actor`.
 *
 * The table exposes Create but no record-level Update/Delete identity.
 * Read/query operations remain in FilmActorModel; this Service owns write preparation,
 * validation and orchestration only.
 */
final class FilmActorService
{
    private const DATABASE_MANAGED_FIELDS = array (
  0 => 'last_update',
);

    public function __construct(private readonly FilmActorModel $model = new FilmActorModel())
    {
    }

    /**
     * Creates the parent resource for relation actor_id.
     *
     * Delegates the write to ActorService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createActorForActorId(array $payload): int|string
    {
        return (new ActorService())->createRelated($payload);
    }

    /**
     * Creates the parent resource for relation film_id.
     *
     * Delegates the write to FilmService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createFilmForFilmId(array $payload): int|string
    {
        return (new FilmService())->createRelated($payload);
    }
    /** @param array<string,mixed> $data */
    private function validateCreatePayload(array $data): void
    {
        $this->validatePayload($data, FilmActorRules::createRules(), FilmActorRules::messages(), 'Create validation failed.');
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
        $id = $this->model->insertRelatedPayload($data);

        return $id;
    }
    /**
     * Creates this resource.
     *
     * @param array<string, mixed> $data Main record data.
     * @param array<string, array<string, mixed>> $related Inline parent records.
     * @return int|string Created record identifier.
     */
    public function create(
        array $data,
        array $related = []
    ): int|string {
        $data = $this->prepareData($data);
        $this->validateCreatePayload($data);
        $transactional = $related !== [];
        if ($transactional) {
            $this->model->beginWriteTransaction();
        }

        try {
            if (isset($related['actor_id']) && is_array($related['actor_id'])) {
                $data['actor_id'] = $this->createActorForActorId($related['actor_id']);
            }
            if (isset($related['film_id']) && is_array($related['film_id'])) {
                $data['film_id'] = $this->createFilmForFilmId($related['film_id']);
            }
            $id = $this->model->createRecord($data);

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

        return $id;
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
}
