<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\InventoryEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `inventory`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class InventoryModel extends BaseCrudModel
{

    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';
    protected $returnType = InventoryEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'inventory_id',
  1 => 'film_id',
  2 => 'store_id',
  3 => 'last_update',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'inventory_id' => 'mediumint',
  'film_id' => 'smallint',
  'store_id' => 'tinyint',
  'last_update' => 'timestamp',
);
    protected const FOREIGN_KEY_FIELDS = array (
  0 => 'film_id',
  1 => 'store_id',
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'film_id',
  1 => 'store_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
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
  'film_id' =>
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'inventory_id',
  1 => 'film_id',
  2 => 'store_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'inventory_id',
  1 => 'film_id',
  2 => 'store_id',
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
        $builder = $this->db->table('inventory');
        $builder->select([
            'inventory.inventory_id AS inventory_id',
            'inventory.film_id AS film_id',
            'inventory.store_id AS store_id',
            'inventory.last_update AS last_update',
            'film__film_id.film_id AS film_id__label',
            'store__store_id.store_id AS store_id__label'
        ]);
        $this->joinFilmFilmId($builder);
        $this->joinStoreStoreId($builder);
        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('inventory');
        $builder->select([
            'inventory.inventory_id AS inventory_id',
            'inventory.film_id AS film_id',
            'inventory.store_id AS store_id',
            'inventory.last_update AS last_update',
            'film__film_id.film_id AS film_id__label',
            'store__store_id.store_id AS store_id__label'
        ]);
        $this->joinFilmFilmId($builder);
        $this->joinStoreStoreId($builder);
        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('inventory');
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
        string $sort = 'inventory_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'inventory_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('inventory.' . $sort, $direction)
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
        $builder = $this->db->table('inventory');
        $builder->select([
            'inventory.inventory_id AS inventory_id',
            'inventory.film_id AS film_id',
            'inventory.store_id AS store_id',
            'inventory.last_update AS last_update',
            'film__film_id.film_id AS film_id__label',
            'store__store_id.store_id AS store_id__label'
        ]);
        $this->joinFilmFilmId($builder);
        $this->joinStoreStoreId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('inventory.inventory_id >', $after);
        }

        return $builder
            ->orderBy('inventory.inventory_id', 'ASC')
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
    /** FK inventory.film_id -> film.film_id; risultato: film_id__label. */
    private function joinFilmFilmId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'film AS film__film_id',
            'film__film_id.film_id = inventory.film_id',
            'left'
        );

        return $builder;
    }
    /** FK inventory.store_id -> store.store_id; risultato: store_id__label. */
    private function joinStoreStoreId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'store AS store__store_id',
            'store__store_id.store_id = inventory.store_id',
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
                $builder->where('inventory.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'inventory_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'inventory_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('inventory.' . $sort, $direction)
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
     * Returns ready-to-render options for the explicit film_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getFilmFilmIdOptions(): array
    {
        $rows = (new FilmModel())->relationOptionRows(
            'film_id',
            array (
  0 => 'film_id',
),
            'film_id'
        );
        $definition = array (
  'displayField' => 'film_id',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['film_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
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
        $rowsFilmIdLanguageId = (new LanguageModel())->relationOptionRows('language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name');
        foreach ($rowsFilmIdLanguageId as $row) { $result['film_id']['language_id'][] = ['id' => (string) ($row['language_id'] ?? ''), 'text' => (string) ($row['name'] ?? $row['language_id'] ?? '')]; }
        $rowsFilmIdOriginalLanguageId = (new LanguageModel())->relationOptionRows('language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name');
        foreach ($rowsFilmIdOriginalLanguageId as $row) { $result['film_id']['original_language_id'][] = ['id' => (string) ($row['language_id'] ?? ''), 'text' => (string) ($row['name'] ?? $row['language_id'] ?? '')]; }
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
    /** Searches options for explicit belongsTo relation film_id. */
    public function searchFilmIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'film_id',
  'displayTemplate' => '',
);
        $rows = (new FilmModel())->relationOptionRows(
            'film_id', array (
  0 => 'film_id',
), 'film_id', $query, null, max(1, min(100, $limit)), array (
  0 => 'film_id',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['film_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation film_id. */
    public function findFilmIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'film_id',
  'displayTemplate' => '',
);
        $rows = (new FilmModel())->relationOptionRows(
            'film_id', array (
  0 => 'film_id',
), 'film_id', '', (string) $id, 1, array (
  0 => 'film_id',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['film_id'] ?? ''),
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
            'film_id' => $this->getFilmFilmIdOptions(),
            'store_id' => $this->getStoreStoreIdOptions(),
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        switch ($field) {
            case 'film_id': return $this->searchFilmIdOptions($query, $limit);
            case 'store_id': return $this->searchStoreIdOptions($query, $limit);
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        switch ($field) {
            case 'film_id': return $this->findFilmIdOption($id);
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
     * HasMany scaffolding delegated to the Model that owns table rental.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getRentalByInventoryId(int|string $parentId, int $limit = 20): array
    {
        return (new RentalModel())->childrenByForeignKey(
            'inventory_id',
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
        $result['rental__inventory_id'] = $this->getRentalByInventoryId($parentId, 20);
        return $result;
    }
}
