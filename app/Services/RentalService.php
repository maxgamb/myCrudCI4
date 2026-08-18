<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Extensions\RentalServiceExtension;
use App\Models\RentalModel;
use App\Validation\RentalRules;
use RuntimeException;

/**
 * Service applicativo per la risorsa `rental`.
 *
 * Responsabilità:
 * - owns write use-cases only: create, update, delete and related creation;
 * - validates and normalizes application data before persistence;
 * - orchestrates writes across related Services without composing SQL;
 * - delegates transactions and persistence to the Model;
 * - invoca gli hook custom definiti nel ServiceExtension persistente;
 *
 * Queries remain the responsibility of RentalModel.
 */
final class RentalService
{
    use RentalServiceExtension;

    private const DATABASE_MANAGED_FIELDS = array (
  0 => 'last_update',
);
    private const DATE_TIME_FIELDS = array (
  0 => 'rental_date',
  1 => 'return_date',
);
    private const NULLABLE_FIELDS = array (
  0 => 'return_date',
);

    public function __construct(private readonly RentalModel $model = new RentalModel())
    {
    }

    /**
     * Creates the parent resource for relation inventory_id.
     *
     * Delegates the write to InventoryService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createInventoryForInventoryId(array $payload): int|string
    {
        return (new InventoryService())->createRelated($payload);
    }

    /**
     * Creates the parent resource for relation customer_id.
     *
     * Delegates the write to CustomerService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createCustomerForCustomerId(array $payload): int|string
    {
        return (new CustomerService())->createRelated($payload);
    }

    /**
     * Creates the parent resource for relation staff_id.
     *
     * Delegates the write to StaffService; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> $payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function createStaffForStaffId(array $payload): int|string
    {
        return (new StaffService())->createRelated($payload);
    }
    /** @param array<string,mixed> $data */
    private function validateCreatePayload(array $data): void
    {
        $this->validatePayload($data, RentalRules::createRules(), RentalRules::messages(), 'Create validation failed.');
    }
    /** @param array<string,mixed> $data */
    private function validateUpdatePayload(int|string $id, array $data): void
    {
        $this->validatePayload($data, RentalRules::updateRules($id), RentalRules::messages(), 'Update validation failed.');
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
     * @return int|string Created record identifier.
     */
    public function create(
        array $data,
        array $related = []
    ): int|string {
        $data = $this->prepareData($data);
        $this->validateCreatePayload($data);
        $data = $this->beforeCreate($data);
        $transactional = $related !== [];
        if ($transactional) {
            $this->model->beginWriteTransaction();
        }

        try {
            if (isset($related['inventory_id']) && is_array($related['inventory_id'])) {
                $data['inventory_id'] = $this->createInventoryForInventoryId($related['inventory_id']);
            }
            if (isset($related['customer_id']) && is_array($related['customer_id'])) {
                $data['customer_id'] = $this->createCustomerForCustomerId($related['customer_id']);
            }
            if (isset($related['staff_id']) && is_array($related['staff_id'])) {
                $data['staff_id'] = $this->createStaffForStaffId($related['staff_id']);
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
        array $data
    ): void {
        $data = $this->prepareData($data);
        $this->validateUpdatePayload($id, $data);
        $data = $this->beforeUpdate($id, $data);
        if (!$this->model->updateRecord($id, $data)) {
            throw new RuntimeException(implode(' ', $this->model->errors()) ?: 'Update failed.');
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
        $rules = array_intersect_key(RentalRules::updateRules($id), $data);
        if ($rules !== []) {
            $this->validatePayload($data, $rules, RentalRules::messages(), 'Patch validation failed.');
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
        // Convert datetime-local input to the database-friendly representation.
        foreach (self::DATE_TIME_FIELDS as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = str_replace('T', ' ', $data[$field]);
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
