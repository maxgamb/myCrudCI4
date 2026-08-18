<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\RentalEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `rental`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class RentalModel extends BaseCrudModel
{

    protected $table = 'rental';
    protected $primaryKey = 'rental_id';
    protected $returnType = RentalEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'return_date',
  5 => 'staff_id',
  6 => 'last_update',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'rental_id' => 'int',
  'rental_date' => 'datetime',
  'inventory_id' => 'mediumint',
  'customer_id' => 'smallint',
  'return_date' => 'datetime',
  'staff_id' => 'tinyint',
  'last_update' => 'timestamp',
);
    protected const FOREIGN_KEY_FIELDS = array (
  0 => 'customer_id',
  1 => 'inventory_id',
  2 => 'staff_id',
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'rental_date',
  1 => 'inventory_id',
  2 => 'customer_id',
  3 => 'return_date',
  4 => 'staff_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
  'rental_id' =>
  array (
    'type' => 'int',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
  ),
  'rental_date' =>
  array (
    'type' => 'datetime',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
  ),
  'inventory_id' =>
  array (
    'type' => 'mediumint',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
  ),
  'customer_id' =>
  array (
    'type' => 'smallint',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
  ),
  'staff_id' =>
  array (
    'type' => 'tinyint',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
      7 => 'is_null',
      8 => 'not_null',
    ),
  ),
);
    private const SORTABLE_FIELDS = array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'staff_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'return_date',
  5 => 'staff_id',
  6 => 'last_update',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('rental');
        $builder->select([
            'rental.rental_id AS rental_id',
            'rental.rental_date AS rental_date',
            'rental.inventory_id AS inventory_id',
            'rental.customer_id AS customer_id',
            'rental.return_date AS return_date',
            'rental.staff_id AS staff_id',
            'rental.last_update AS last_update',
            'customer__customer_id.last_name AS customer_id__label',
            'inventory__inventory_id.inventory_id AS inventory_id__label',
            'staff__staff_id.last_name AS staff_id__label'
        ]);
        $this->joinCustomerCustomerId($builder);
        $this->joinInventoryInventoryId($builder);
        $this->joinStaffStaffId($builder);
        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('rental');
        $builder->select([
            'rental.rental_id AS rental_id',
            'rental.rental_date AS rental_date',
            'rental.inventory_id AS inventory_id',
            'rental.customer_id AS customer_id',
            'rental.return_date AS return_date',
            'rental.staff_id AS staff_id',
            'rental.last_update AS last_update',
            'customer__customer_id.last_name AS customer_id__label',
            'inventory__inventory_id.inventory_id AS inventory_id__label',
            'staff__staff_id.last_name AS staff_id__label'
        ]);
        $this->joinCustomerCustomerId($builder);
        $this->joinInventoryInventoryId($builder);
        $this->joinStaffStaffId($builder);
        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('rental');
        return $builder;
    }

    /** Returns the detail record with belongsTo labels already resolved. */
    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where($this->table . '.' . $this->primaryKey, $id)
            ->get()
            ->getRow();
    }
    /**
     * Returns an HTML-ready page with the CI4 Pager.
     *
     * @param array<int, array<string, mixed>> $filters
     * @return array{rows: array<int, object>, total: int, page: int, perPage: int, pagerLinks: string, sort: string, direction: string}
     */
    public function getListPage(
        array $filters,
        int $page = 1,
        int $perPage = 25,
        string $sort = 'rental_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'rental_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('rental.' . $sort, $direction)
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        $pagerLinks = service('pager')->makeLinks(
            $page,
            $perPage,
            $total,
            'bootstrap_full'
        );

        return [
            'rows' => $rows,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pagerLinks' => $pagerLinks,
            'sort' => $sort,
            'direction' => strtolower($direction),
        ];
    }

    /**
     * Reads export records in chunks using the primary key as a stable cursor.
     *
     * @param array<int, array<string, mixed>> $filters
     * @return array<int, array<string, mixed>>
     */
    public function getExportRows(array $filters, int $limit = 2000, int|string|null $after = null): array
    {
        $builder = $this->db->table('rental');
        $builder->select([
            'rental.rental_id AS rental_id',
            'rental.rental_date AS rental_date',
            'rental.inventory_id AS inventory_id',
            'rental.customer_id AS customer_id',
            'rental.return_date AS return_date',
            'rental.staff_id AS staff_id',
            'rental.last_update AS last_update',
            'customer__customer_id.last_name AS customer_id__label',
            'inventory__inventory_id.inventory_id AS inventory_id__label',
            'staff__staff_id.last_name AS staff_id__label'
        ]);
        $this->joinCustomerCustomerId($builder);
        $this->joinInventoryInventoryId($builder);
        $this->joinStaffStaffId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('rental.rental_id >', $after);
        }

        return $builder
            ->orderBy('rental.rental_id', 'ASC')
            ->limit(max(1, min(5000, $limit)))
            ->get()
            ->getResultArray();
    }

    public function countExportRows(array $filters): int
    {
        $builder = $this->listCountBuilder();
        $this->applyListFilters($builder, $filters, false);

        return $this->countListRows($builder, $filters);
    }

    /** @return list<string> */
    public function exportFields(): array
    {
        return self::EXPORT_FIELDS;
    }

    /**
     * Inserts this Model's own record and only the relation payloads that are
     * actually enabled for this resource.
     *
     * @param array<string,mixed> $data
     * @return int|string
     * @throws RuntimeException|\Throwable If persistence cannot be completed.
     */
    public function createRecord(
        array $data
    ): int|string {
        $id = $this->insert($data, true);
        if ($id === false) {
            throw new RuntimeException(implode(' ', $this->errors()) ?: 'Insert failed.');
        }
        $this->clearListCountCache();
        return is_int($id) ? $id : (string) $id;
    }
    /**
     * Inserts this Model's own resource for reuse by another generated Service.
     *
     * This table has no spatial fields, so Related Create uses the normal CI4
     * insert path without GIS-specific branches. The caller owns any wider transaction.
     *
     * @param array<string,mixed> $data
     * @return int|string
     */
    public function insertRelatedPayload(array $data): int|string
    {
        $allowed = array_fill_keys($this->allowedFields, true);
        $payload = array_intersect_key($data, $allowed);
        $id = $this->insert($payload, true);
        if ($id === false) {
            $dbError = (array) $this->db->error();
            $dbCode = trim((string) ($dbError['code'] ?? ''));
            $dbMessage = trim((string) ($dbError['message'] ?? ''));
            $detail = $dbMessage !== ''
                ? ' Database error' . ($dbCode !== '' ? ' [' . $dbCode . ']' : '') . ': ' . $dbMessage
                : '';
            throw new RuntimeException('Unable to insert related resource: ' . $this->table . '.' . $detail);
        }

        if ($this->useAutoIncrement) {
            $this->clearListCountCache();
            return is_int($id) ? $id : (string) $id;
        }

        $recordId = $payload[$this->primaryKey] ?? $id;
        if (!is_int($recordId) && !is_string($recordId)) {
            throw new RuntimeException('The related resource key must have a value: ' . $this->primaryKey . '.');
        }

        $this->clearListCountCache();
        return $recordId;
    }
    /**
     * Updates only this Model's own table.
     *
     * Cross-resource and pivot orchestration is owned by the generated Service.
     *
     * @param int|string $id Record identifier.
     * @param array<string,mixed> $data Sanitized write payload.
     * @return bool True when the update succeeds.
     */
    public function updateRecord(int|string $id, array $data): bool
    {
        if (!$this->update($id, $data)) {
            return false;
        }
        $this->clearListCountCache();
        return true;
    }
    /** FK rental.customer_id -> customer.customer_id; risultato: customer_id__label. */
    private function joinCustomerCustomerId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'customer AS customer__customer_id',
            'customer__customer_id.customer_id = rental.customer_id',
            'left'
        );

        return $builder;
    }
    /** FK rental.inventory_id -> inventory.inventory_id; risultato: inventory_id__label. */
    private function joinInventoryInventoryId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'inventory AS inventory__inventory_id',
            'inventory__inventory_id.inventory_id = rental.inventory_id',
            'left'
        );

        return $builder;
    }
    /** FK rental.staff_id -> staff.staff_id; risultato: staff_id__label. */
    private function joinStaffStaffId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'staff AS staff__staff_id',
            'staff__staff_id.staff_id = rental.staff_id',
            'left'
        );

        return $builder;
    }
    /** Paginated REST list with filter and sorting whitelists. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('rental.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'rental_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'rental_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('rental.' . $sort, $direction)
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();
        $pageCount = max(1, (int) ceil($total / $perPage));

        return [
            'rows' => $rows,
            'meta' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'pageCount' => $pageCount,
            ],
            'links' => [
                'self' => $this->apiLink($query, $page),
                'next' => $page < $pageCount ? $this->apiLink($query, $page + 1) : null,
                'prev' => $page > 1 ? $this->apiLink($query, $page - 1) : null,
            ],
        ];
    }
    /**
     * Returns ready-to-render options for the explicit customer_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getCustomerCustomerIdOptions(): array
    {
        $rows = (new CustomerModel())->relationOptionRows(
            'customer_id',
            array (
  0 => 'customer_id',
  1 => 'last_name',
),
            'last_name'
        );
        $definition = array (
  'displayField' => 'last_name',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['customer_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }
    /**
     * Returns ready-to-render options for the explicit inventory_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getInventoryInventoryIdOptions(): array
    {
        $rows = (new InventoryModel())->relationOptionRows(
            'inventory_id',
            array (
  0 => 'inventory_id',
),
            'inventory_id'
        );
        $definition = array (
  'displayField' => 'inventory_id',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['inventory_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }
    /**
     * Returns ready-to-render options for the explicit staff_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getStaffStaffIdOptions(): array
    {
        $rows = (new StaffModel())->relationOptionRows(
            'staff_id',
            array (
  0 => 'staff_id',
  1 => 'last_name',
),
            'last_name'
        );
        $definition = array (
  'displayField' => 'last_name',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['staff_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }
    /**
     * Returns nested FK options for inline-created parents.
     * Every query is delegated statically to the Model that owns the queried table.
     *
     * @return array<string,array<string,list<array{id:string,text:string}>>>
     */
    public function relatedCreateRelationOptions(): array
    {
        $result = [];
        $rowsCustomerIdStoreId = (new StoreModel())->relationOptionRows('store_id', array (
  0 => 'store_id',
), 'store_id');
        foreach ($rowsCustomerIdStoreId as $row) { $result['customer_id']['store_id'][] = ['id' => (string) ($row['store_id'] ?? ''), 'text' => (string) ($row['store_id'] ?? $row['store_id'] ?? '')]; }
        $rowsCustomerIdAddressId = (new AddressModel())->relationOptionRows('address_id', array (
  0 => 'address_id',
  1 => 'address',
), 'address');
        foreach ($rowsCustomerIdAddressId as $row) { $result['customer_id']['address_id'][] = ['id' => (string) ($row['address_id'] ?? ''), 'text' => (string) ($row['address'] ?? $row['address_id'] ?? '')]; }
        $rowsInventoryIdFilmId = (new FilmModel())->relationOptionRows('film_id', array (
  0 => 'film_id',
  1 => 'title',
), 'title');
        foreach ($rowsInventoryIdFilmId as $row) { $result['inventory_id']['film_id'][] = ['id' => (string) ($row['film_id'] ?? ''), 'text' => (string) ($row['title'] ?? $row['film_id'] ?? '')]; }
        $rowsInventoryIdStoreId = (new StoreModel())->relationOptionRows('store_id', array (
  0 => 'store_id',
), 'store_id');
        foreach ($rowsInventoryIdStoreId as $row) { $result['inventory_id']['store_id'][] = ['id' => (string) ($row['store_id'] ?? ''), 'text' => (string) ($row['store_id'] ?? $row['store_id'] ?? '')]; }
        $rowsStaffIdAddressId = (new AddressModel())->relationOptionRows('address_id', array (
  0 => 'address_id',
  1 => 'address',
), 'address');
        foreach ($rowsStaffIdAddressId as $row) { $result['staff_id']['address_id'][] = ['id' => (string) ($row['address_id'] ?? ''), 'text' => (string) ($row['address'] ?? $row['address_id'] ?? '')]; }
        $rowsStaffIdStoreId = (new StoreModel())->relationOptionRows('store_id', array (
  0 => 'store_id',
), 'store_id');
        foreach ($rowsStaffIdStoreId as $row) { $result['staff_id']['store_id'][] = ['id' => (string) ($row['store_id'] ?? ''), 'text' => (string) ($row['store_id'] ?? $row['store_id'] ?? '')]; }
        return $result;
    }
    /** Searches options for explicit belongsTo relation customer_id. */
    public function searchCustomerIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'last_name',
  'displayTemplate' => '',
);
        $rows = (new CustomerModel())->relationOptionRows(
            'customer_id', array (
  0 => 'customer_id',
  1 => 'last_name',
), 'last_name', $query, null, max(1, min(100, $limit)), array (
  0 => 'last_name',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['customer_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation customer_id. */
    public function findCustomerIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'last_name',
  'displayTemplate' => '',
);
        $rows = (new CustomerModel())->relationOptionRows(
            'customer_id', array (
  0 => 'customer_id',
  1 => 'last_name',
), 'last_name', '', (string) $id, 1, array (
  0 => 'last_name',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['customer_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    /** Searches options for explicit belongsTo relation inventory_id. */
    public function searchInventoryIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'inventory_id',
  'displayTemplate' => '',
);
        $rows = (new InventoryModel())->relationOptionRows(
            'inventory_id', array (
  0 => 'inventory_id',
), 'inventory_id', $query, null, max(1, min(100, $limit)), array (
  0 => 'inventory_id',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['inventory_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation inventory_id. */
    public function findInventoryIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'inventory_id',
  'displayTemplate' => '',
);
        $rows = (new InventoryModel())->relationOptionRows(
            'inventory_id', array (
  0 => 'inventory_id',
), 'inventory_id', '', (string) $id, 1, array (
  0 => 'inventory_id',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['inventory_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    /** Searches options for explicit belongsTo relation staff_id. */
    public function searchStaffIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'last_name',
  'displayTemplate' => '',
);
        $rows = (new StaffModel())->relationOptionRows(
            'staff_id', array (
  0 => 'staff_id',
  1 => 'last_name',
), 'last_name', $query, null, max(1, min(100, $limit)), array (
  0 => 'last_name',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['staff_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation staff_id. */
    public function findStaffIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'last_name',
  'displayTemplate' => '',
);
        $rows = (new StaffModel())->relationOptionRows(
            'staff_id', array (
  0 => 'staff_id',
  1 => 'last_name',
), 'last_name', '', (string) $id, 1, array (
  0 => 'last_name',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['staff_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }
    /** @return array<string,array<string,string>> */
    public function relationOptions(): array
    {
        return [
            'customer_id' => $this->getCustomerCustomerIdOptions(),
            'inventory_id' => $this->getInventoryInventoryIdOptions(),
            'staff_id' => $this->getStaffStaffIdOptions(),
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        switch ($field) {
            case 'customer_id': return $this->searchCustomerIdOptions($query, $limit);
            case 'inventory_id': return $this->searchInventoryIdOptions($query, $limit);
            case 'staff_id': return $this->searchStaffIdOptions($query, $limit);
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        switch ($field) {
            case 'customer_id': return $this->findCustomerIdOption($id);
            case 'inventory_id': return $this->findInventoryIdOption($id);
            case 'staff_id': return $this->findStaffIdOption($id);
            default: return null;
        }
    }

    private function formatRelationLabel(array $row, array $definition): string
    {
        $template = trim((string) ($definition['displayTemplate'] ?? ''));
        if ($template === '') {
            return trim((string) ($row[(string) $definition['displayField']] ?? ''));
        }
        $label = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array $match): string => (string) ($row[$match[1]] ?? ''),
            $template
        );
        return trim((string) $label);
    }
    /**
     * HasMany scaffolding delegated to the Model that owns table payment.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getPaymentByRentalId(int|string $parentId, int $limit = 20): array
    {
        return (new PaymentModel())->childrenByForeignKey(
            'rental_id',
            $parentId,
            array (
  0 => 'payment_id',
  1 => 'customer_id',
  2 => 'staff_id',
  3 => 'rental_id',
  4 => 'amount',
  5 => 'payment_date',
  6 => 'last_update',
),
            'payment_id',
            $limit
        );
    }
    /** @return array<string,array<string,mixed>> */
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['payment__rental_id'] = $this->getPaymentByRentalId($parentId, 20);
        return $result;
    }
}
