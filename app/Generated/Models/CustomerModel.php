<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CustomerEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `customer`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class CustomerModel extends BaseCrudModel
{

    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    protected $returnType = CustomerEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'first_name',
  3 => 'last_name',
  4 => 'email',
  5 => 'address_id',
  6 => 'active',
  7 => 'create_date',
  8 => 'last_update',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'customer_id' => 'smallint',
  'store_id' => 'tinyint',
  'first_name' => 'varchar',
  'last_name' => 'varchar',
  'email' => 'varchar',
  'address_id' => 'smallint',
  'active' => 'tinyint',
  'create_date' => 'datetime',
  'last_update' => 'timestamp',
);
    protected const FOREIGN_KEY_FIELDS = array (
  0 => 'address_id',
  1 => 'store_id',
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'store_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'email',
  4 => 'address_id',
  5 => 'active',
  6 => 'create_date',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
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
  'store_id' =>
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
  'last_name' =>
  array (
    'type' => 'varchar',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'starts_with',
      3 => 'contains',
      4 => 'ends_with',
      5 => 'is_null',
      6 => 'not_null',
    ),
  ),
  'address_id' =>
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'last_name',
  3 => 'address_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'first_name',
  3 => 'last_name',
  4 => 'email',
  5 => 'address_id',
  6 => 'active',
  7 => 'create_date',
  8 => 'last_update',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('customer');
        $builder->select([
            'customer.customer_id AS customer_id',
            'customer.store_id AS store_id',
            'customer.first_name AS first_name',
            'customer.last_name AS last_name',
            'customer.email AS email',
            'customer.address_id AS address_id',
            'customer.active AS active',
            'customer.create_date AS create_date',
            'customer.last_update AS last_update',
            'TRIM(CONCAT(COALESCE(CAST(address__address_id.address AS CHAR), \'\'), \' \', COALESCE(CAST(address__address_id.district AS CHAR), \'\'), \' \', COALESCE(CAST(address__address_id.postal_code AS CHAR), \'\'))) AS address_id__label',
            'store__store_id.store_id AS store_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStoreStoreId($builder);
        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('customer');
        $builder->select([
            'customer.customer_id AS customer_id',
            'customer.store_id AS store_id',
            'customer.first_name AS first_name',
            'customer.last_name AS last_name',
            'customer.email AS email',
            'customer.address_id AS address_id',
            'customer.active AS active',
            'customer.create_date AS create_date',
            'customer.last_update AS last_update',
            'TRIM(CONCAT(COALESCE(CAST(address__address_id.address AS CHAR), \'\'), \' \', COALESCE(CAST(address__address_id.district AS CHAR), \'\'), \' \', COALESCE(CAST(address__address_id.postal_code AS CHAR), \'\'))) AS address_id__label',
            'store__store_id.store_id AS store_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStoreStoreId($builder);
        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('customer');
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
        string $sort = 'customer_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'customer_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('customer.' . $sort, $direction)
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
        $builder = $this->db->table('customer');
        $builder->select([
            'customer.customer_id AS customer_id',
            'customer.store_id AS store_id',
            'customer.first_name AS first_name',
            'customer.last_name AS last_name',
            'customer.email AS email',
            'customer.address_id AS address_id',
            'customer.active AS active',
            'customer.create_date AS create_date',
            'customer.last_update AS last_update',
            'TRIM(CONCAT(COALESCE(CAST(address__address_id.address AS CHAR), \'\'), \' \', COALESCE(CAST(address__address_id.district AS CHAR), \'\'), \' \', COALESCE(CAST(address__address_id.postal_code AS CHAR), \'\'))) AS address_id__label',
            'store__store_id.store_id AS store_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStoreStoreId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('customer.customer_id >', $after);
        }

        return $builder
            ->orderBy('customer.customer_id', 'ASC')
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
    /** FK customer.address_id -> address.address_id; risultato: address_id__label. */
    private function joinAddressAddressId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'address AS address__address_id',
            'address__address_id.address_id = customer.address_id',
            'left'
        );

        return $builder;
    }
    /** FK customer.store_id -> store.store_id; risultato: store_id__label. */
    private function joinStoreStoreId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'store AS store__store_id',
            'store__store_id.store_id = customer.store_id',
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
                $builder->where('customer.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'customer_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'customer_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('customer.' . $sort, $direction)
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
     * Returns ready-to-render options for the explicit store_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getStoreStoreIdOptions(): array
    {
        $rows = (new StoreModel())->relationOptionRows(
            'store_id',
            array (
  0 => 'store_id',
),
            'store_id'
        );
        $definition = array (
  'displayField' => 'store_id',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['store_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
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
        $rowsAddressIdCityId = (new CityModel())->relationOptionRows('city_id', array (
  0 => 'city_id',
  1 => 'city',
), 'city');
        foreach ($rowsAddressIdCityId as $row) { $result['address_id']['city_id'][] = ['id' => (string) ($row['city_id'] ?? ''), 'text' => (string) ($row['city'] ?? $row['city_id'] ?? '')]; }
        $rowsStoreIdManagerStaffId = (new StaffModel())->relationOptionRows('staff_id', array (
  0 => 'staff_id',
  1 => 'first_name',
), 'first_name');
        $usedStoreIdManagerStaffId = array_values(array_filter(array_map(static fn (array $row): string => (string) ($row['manager_staff_id'] ?? ''), (new StoreModel())->relationOptionRows('manager_staff_id', ['manager_staff_id'], 'manager_staff_id', '', null, 5000)), static fn (string $value): bool => $value !== ''));
        if ($usedStoreIdManagerStaffId !== []) { $rowsStoreIdManagerStaffId = array_values(array_filter($rowsStoreIdManagerStaffId, static fn (array $row): bool => !in_array((string) ($row['staff_id'] ?? ''), $usedStoreIdManagerStaffId, true))); }
        foreach ($rowsStoreIdManagerStaffId as $row) { $result['store_id']['manager_staff_id'][] = ['id' => (string) ($row['staff_id'] ?? ''), 'text' => (string) ($row['first_name'] ?? $row['staff_id'] ?? '')]; }
        $rowsStoreIdAddressId = (new AddressModel())->relationOptionRows('address_id', array (
  0 => 'address_id',
  1 => 'address',
), 'address');
        foreach ($rowsStoreIdAddressId as $row) { $result['store_id']['address_id'][] = ['id' => (string) ($row['address_id'] ?? ''), 'text' => (string) ($row['address'] ?? $row['address_id'] ?? '')]; }
        return $result;
    }
    /** Searches options for explicit belongsTo relation address_id. */
    public function searchAddressIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'address',
  'displayTemplate' => '{{address}} {{district}} {{postal_code}}',
);
        $rows = (new AddressModel())->relationOptionRows(
            'address_id', array (
  0 => 'address_id',
  1 => 'address',
  2 => 'district',
  3 => 'postal_code',
), 'address', $query, null, max(1, min(100, $limit)), array (
  0 => 'address',
  1 => 'district',
  2 => 'postal_code',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['address_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation address_id. */
    public function findAddressIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'address',
  'displayTemplate' => '{{address}} {{district}} {{postal_code}}',
);
        $rows = (new AddressModel())->relationOptionRows(
            'address_id', array (
  0 => 'address_id',
  1 => 'address',
  2 => 'district',
  3 => 'postal_code',
), 'address', '', (string) $id, 1, array (
  0 => 'address',
  1 => 'district',
  2 => 'postal_code',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['address_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    /** Searches options for explicit belongsTo relation store_id. */
    public function searchStoreIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'store_id',
  'displayTemplate' => '',
);
        $rows = (new StoreModel())->relationOptionRows(
            'store_id', array (
  0 => 'store_id',
), 'store_id', $query, null, max(1, min(100, $limit)), array (
  0 => 'store_id',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['store_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation store_id. */
    public function findStoreIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'store_id',
  'displayTemplate' => '',
);
        $rows = (new StoreModel())->relationOptionRows(
            'store_id', array (
  0 => 'store_id',
), 'store_id', '', (string) $id, 1, array (
  0 => 'store_id',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['store_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }
    /** @return array<string,array<string,string>> */
    public function relationOptions(): array
    {
        return [
            'store_id' => $this->getStoreStoreIdOptions(),
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        switch ($field) {
            case 'address_id': return $this->searchAddressIdOptions($query, $limit);
            case 'store_id': return $this->searchStoreIdOptions($query, $limit);
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        switch ($field) {
            case 'address_id': return $this->findAddressIdOption($id);
            case 'store_id': return $this->findStoreIdOption($id);
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
    public function getPaymentByCustomerId(int|string $parentId, int $limit = 20): array
    {
        return (new PaymentModel())->childrenByForeignKey(
            'customer_id',
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
    /**
     * HasMany scaffolding delegated to the Model that owns table rental.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getRentalByCustomerId(int|string $parentId, int $limit = 20): array
    {
        return (new RentalModel())->childrenByForeignKey(
            'customer_id',
            $parentId,
            array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'return_date',
  5 => 'staff_id',
  6 => 'last_update',
),
            'rental_id',
            $limit
        );
    }
    /** @return array<string,array<string,mixed>> */
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['payment__customer_id'] = $this->getPaymentByCustomerId($parentId, 20);

        $result['rental__customer_id'] = $this->getRentalByCustomerId($parentId, 20);
        return $result;
    }
}
