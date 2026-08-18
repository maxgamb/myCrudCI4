<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\StoreEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `store`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class StoreModel extends BaseCrudModel
{

    protected $table = 'store';
    protected $primaryKey = 'store_id';
    protected $returnType = StoreEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'store_id',
  1 => 'manager_staff_id',
  2 => 'address_id',
  3 => 'last_update',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'store_id' => 'tinyint',
  'manager_staff_id' => 'tinyint',
  'address_id' => 'smallint',
  'last_update' => 'timestamp',
);
    protected const FOREIGN_KEY_FIELDS = array (
  0 => 'address_id',
  1 => 'manager_staff_id',
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'manager_staff_id',
  1 => 'address_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
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
  'manager_staff_id' =>
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
  0 => 'store_id',
  1 => 'manager_staff_id',
  2 => 'address_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'store_id',
  1 => 'manager_staff_id',
  2 => 'address_id',
  3 => 'last_update',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('store');
        $builder->select([
            'store.store_id AS store_id',
            'store.manager_staff_id AS manager_staff_id',
            'store.address_id AS address_id',
            'store.last_update AS last_update',
            'address__address_id.address AS address_id__label',
            'staff__manager_staff_id.last_name AS manager_staff_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStaffManagerStaffId($builder);
        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('store');
        $builder->select([
            'store.store_id AS store_id',
            'store.manager_staff_id AS manager_staff_id',
            'store.address_id AS address_id',
            'store.last_update AS last_update',
            'address__address_id.address AS address_id__label',
            'staff__manager_staff_id.last_name AS manager_staff_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStaffManagerStaffId($builder);
        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('store');
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
        string $sort = 'store_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'store_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('store.' . $sort, $direction)
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
        $builder = $this->db->table('store');
        $builder->select([
            'store.store_id AS store_id',
            'store.manager_staff_id AS manager_staff_id',
            'store.address_id AS address_id',
            'store.last_update AS last_update',
            'address__address_id.address AS address_id__label',
            'staff__manager_staff_id.last_name AS manager_staff_id__label'
        ]);
        $this->joinAddressAddressId($builder);
        $this->joinStaffManagerStaffId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('store.store_id >', $after);
        }

        return $builder
            ->orderBy('store.store_id', 'ASC')
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
    /** FK store.address_id -> address.address_id; risultato: address_id__label. */
    private function joinAddressAddressId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'address AS address__address_id',
            'address__address_id.address_id = store.address_id',
            'left'
        );

        return $builder;
    }
    /** FK store.manager_staff_id -> staff.staff_id; risultato: manager_staff_id__label. */
    private function joinStaffManagerStaffId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'staff AS staff__manager_staff_id',
            'staff__manager_staff_id.staff_id = store.manager_staff_id',
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
                $builder->where('store.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'store_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'store_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('store.' . $sort, $direction)
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
     * Returns ready-to-render options for the explicit address_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getAddressAddressIdOptions(): array
    {
        $rows = (new AddressModel())->relationOptionRows(
            'address_id',
            array (
  0 => 'address_id',
  1 => 'address',
),
            'address'
        );
        $definition = array (
  'displayField' => 'address',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['address_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }
    /**
     * Returns ready-to-render options for the explicit manager_staff_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getStaffManagerStaffIdOptions(): array
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
        $rowsAddressIdCityId = (new CityModel())->relationOptionRows('city_id', array (
  0 => 'city_id',
  1 => 'city',
), 'city');
        foreach ($rowsAddressIdCityId as $row) { $result['address_id']['city_id'][] = ['id' => (string) ($row['city_id'] ?? ''), 'text' => (string) ($row['city'] ?? $row['city_id'] ?? '')]; }
        $rowsManagerStaffIdAddressId = (new AddressModel())->relationOptionRows('address_id', array (
  0 => 'address_id',
  1 => 'address',
), 'address');
        foreach ($rowsManagerStaffIdAddressId as $row) { $result['manager_staff_id']['address_id'][] = ['id' => (string) ($row['address_id'] ?? ''), 'text' => (string) ($row['address'] ?? $row['address_id'] ?? '')]; }
        $rowsManagerStaffIdStoreId = (new StoreModel())->relationOptionRows('store_id', array (
  0 => 'store_id',
), 'store_id');
        foreach ($rowsManagerStaffIdStoreId as $row) { $result['manager_staff_id']['store_id'][] = ['id' => (string) ($row['store_id'] ?? ''), 'text' => (string) ($row['store_id'] ?? $row['store_id'] ?? '')]; }
        return $result;
    }
    /** Searches options for explicit belongsTo relation address_id. */
    public function searchAddressIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'address',
  'displayTemplate' => '',
);
        $rows = (new AddressModel())->relationOptionRows(
            'address_id', array (
  0 => 'address_id',
  1 => 'address',
), 'address', $query, null, max(1, min(100, $limit)), array (
  0 => 'address',
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
  'displayTemplate' => '',
);
        $rows = (new AddressModel())->relationOptionRows(
            'address_id', array (
  0 => 'address_id',
  1 => 'address',
), 'address', '', (string) $id, 1, array (
  0 => 'address',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['address_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    /** Searches options for explicit belongsTo relation manager_staff_id. */
    public function searchManagerStaffIdOptions(string $query, int $limit = 20): array
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

    /** Finds one option for explicit belongsTo relation manager_staff_id. */
    public function findManagerStaffIdOption(int|string $id): ?array
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
            'address_id' => $this->getAddressAddressIdOptions(),
            'manager_staff_id' => $this->getStaffManagerStaffIdOptions(),
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        switch ($field) {
            case 'address_id': return $this->searchAddressIdOptions($query, $limit);
            case 'manager_staff_id': return $this->searchManagerStaffIdOptions($query, $limit);
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        switch ($field) {
            case 'address_id': return $this->findAddressIdOption($id);
            case 'manager_staff_id': return $this->findManagerStaffIdOption($id);
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
     * HasMany scaffolding delegated to the Model that owns table customer.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getCustomerByStoreId(int|string $parentId, int $limit = 20): array
    {
        return (new CustomerModel())->childrenByForeignKey(
            'store_id',
            $parentId,
            array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'first_name',
  3 => 'last_name',
  4 => 'email',
  5 => 'address_id',
  6 => 'active',
  7 => 'create_date',
  8 => 'last_update',
),
            'customer_id',
            $limit
        );
    }
    /**
     * HasMany scaffolding delegated to the Model that owns table inventory.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getInventoryByStoreId(int|string $parentId, int $limit = 20): array
    {
        return (new InventoryModel())->childrenByForeignKey(
            'store_id',
            $parentId,
            array (
  0 => 'inventory_id',
  1 => 'film_id',
  2 => 'store_id',
  3 => 'last_update',
),
            'inventory_id',
            $limit
        );
    }
    /**
     * HasMany scaffolding delegated to the Model that owns table staff.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getStaffByStoreId(int|string $parentId, int $limit = 20): array
    {
        return (new StaffModel())->childrenByForeignKey(
            'store_id',
            $parentId,
            array (
  0 => 'staff_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'address_id',
  4 => 'picture',
  5 => 'email',
  6 => 'store_id',
  7 => 'active',
  8 => 'username',
  9 => 'password',
  10 => 'last_update',
),
            'staff_id',
            $limit
        );
    }
    /** @return array<string,array<string,mixed>> */
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['customer__store_id'] = $this->getCustomerByStoreId($parentId, 20);

        $result['inventory__store_id'] = $this->getInventoryByStoreId($parentId, 20);

        $result['staff__store_id'] = $this->getStaffByStoreId($parentId, 20);
        return $result;
    }
}
