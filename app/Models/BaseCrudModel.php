<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/**
 * Shared infrastructure for all generated CRUD Models.
 *
 * Responsibilities kept here are deliberately generic and table-owned:
 * - list filter execution against the current Model whitelist;
 * - cached unfiltered row counts;
 * - reusable relation reads against the current Model's own table only;
 * - transaction primitives used by generated Services;
 * - common API pagination-link composition.
 *
 * Relation ownership remains explicit in generated Models. This class never
 * chooses another Model or another table at runtime: callers such as FilmModel
 * still instantiate ActorModel, CategoryModel, LanguageModel, and so on
 * explicitly at generation time.
 *
 * Every generated child Model must provide these protected constants:
 * - RESOURCE_FIELDS: complete schema field whitelist;
 * - RESOURCE_FIELD_TYPES: schema types used for spatial serialization;
 * - FOREIGN_KEY_FIELDS: real FK columns owned by the Model;
 * - LIST_FILTERS: allowed filter fields/operators;
 * - COUNT_CACHE_SECONDS: cache TTL for unfiltered list counts.
 */
abstract class BaseCrudModel extends Model
{
    /** Opens a transaction on the database connection owned by this Model. */
    public function beginWriteTransaction(): void
    {
        $this->db->transBegin();
    }

    /** Returns whether the active write transaction is still valid. */
    public function writeTransactionStatus(): bool
    {
        return $this->db->transStatus();
    }

    /** Commits the active Service-orchestrated transaction. */
    public function commitWriteTransaction(): void
    {
        $this->db->transCommit();
    }

    /** Rolls back the active Service-orchestrated transaction. */
    public function rollbackWriteTransaction(): void
    {
        $this->db->transRollback();
    }

    /**
     * Counts list rows, caching only the unfiltered total.
     *
     * @param array<int,array<string,mixed>> $filters Normalized list filters.
     */
    protected function countListRows(BaseBuilder $builder, array $filters): int
    {
        if ($this->hasActiveFilters($filters) || static::COUNT_CACHE_SECONDS === 0) {
            return $builder->countAllResults();
        }

        $cacheKey = 'mycrud_list_total_' . md5($this->table);
        $cache = service('cache');
        $cached = $cache->get($cacheKey);
        if (is_int($cached) || (is_string($cached) && ctype_digit($cached))) {
            return (int) $cached;
        }

        $total = $builder->countAllResults();
        $cache->save($cacheKey, $total, static::COUNT_CACHE_SECONDS);

        return $total;
    }

    /**
     * Returns true when at least one normalized list filter targets a field.
     *
     * @param array<int,array<string,mixed>> $filters
     */
    protected function hasActiveFilters(array $filters): bool
    {
        foreach ($filters as $filter) {
            if (is_array($filter) && trim((string) ($filter['field'] ?? '')) !== '') {
                return true;
            }
        }

        return false;
    }

    /** Invalidates the cached unfiltered row count after a write. */
    public function clearListCountCache(): void
    {
        service('cache')->delete('mycrud_list_total_' . md5($this->table));
    }

    /**
     * Applies normalized list filters to a builder for this Model's own table.
     *
     * Field names and operators are accepted only when declared in the child
     * Model's LIST_FILTERS whitelist. No foreign table is selected here.
     *
     * @param array<int,array<string,mixed>> $filters
     */
    protected function applyListFilters(BaseBuilder $builder, array $filters, bool $qualified): void
    {
        $applied = 0;
        $nextLogic = 'and';

        foreach (array_values($filters) as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $field = trim((string) ($filter['field'] ?? ''));
            $operator = trim((string) ($filter['operator'] ?? ''));
            if ($field === '' || !isset(static::LIST_FILTERS[$field])) {
                continue;
            }

            $definition = static::LIST_FILTERS[$field];
            $allowedOperators = (array) ($definition['operators'] ?? ['eq']);
            if (!in_array($operator, $allowedOperators, true)) {
                continue;
            }

            $column = $qualified ? $this->table . '.' . $field : $field;
            $value = is_scalar($filter['value'] ?? null) ? trim((string) $filter['value']) : '';
            $valueTo = is_scalar($filter['value_to'] ?? null) ? trim((string) $filter['value_to']) : '';
            $logic = $applied > 0 ? $nextLogic : 'and';

            if (!in_array($operator, ['is_null', 'not_null'], true) && $value === '') {
                continue;
            }
            if ($operator === 'between' && $valueTo === '') {
                continue;
            }

            $logic === 'or' ? $builder->orGroupStart() : $builder->groupStart();

            switch ($operator) {
                case 'neq':
                    $builder->where($column . ' !=', $value);
                    break;
                case 'gt':
                    $builder->where($column . ' >', $value);
                    break;
                case 'gte':
                    $builder->where($column . ' >=', $value);
                    break;
                case 'lt':
                    $builder->where($column . ' <', $value);
                    break;
                case 'lte':
                    $builder->where($column . ' <=', $value);
                    break;
                case 'between':
                    $builder->where($column . ' >=', $value)
                        ->where($column . ' <=', $valueTo);
                    break;
                case 'starts_with':
                    $builder->like($column, $value, 'after');
                    break;
                case 'contains':
                    $builder->like($column, $value, 'both');
                    break;
                case 'ends_with':
                    $builder->like($column, $value, 'before');
                    break;
                case 'is_null':
                    $builder->where($column, null);
                    break;
                case 'not_null':
                    $builder->where($column . ' IS NOT NULL', null, false);
                    break;
                case 'eq':
                default:
                    $builder->where($column, $value);
                    break;
            }

            $builder->groupEnd();
            $applied++;
            $nextLogic = strtolower((string) ($filter['logic'] ?? 'and')) === 'or' ? 'or' : 'and';
        }
    }

    /**
     * Returns selectable/searchable rows from this Model's own table.
     *
     * @param string $key Whitelisted identifier column.
     * @param list<string> $selectFields Columns returned to the caller.
     * @param string $orderBy Whitelisted ordering column.
     * @param string $query Optional prefix search text.
     * @param string|null $id Optional exact identifier lookup.
     * @param int $limit Maximum number of rows.
     * @param list<string> $searchFields Columns used by prefix search.
     * @return list<array<string,mixed>>
     */
    public function relationOptionRows(
        string $key,
        array $selectFields,
        string $orderBy,
        string $query = '',
        ?string $id = null,
        int $limit = 500,
        array $searchFields = []
    ): array {
        $allowed = array_fill_keys(static::RESOURCE_FIELDS, true);
        if (!isset($allowed[$key], $allowed[$orderBy])) {
            return [];
        }

        $selectFields = array_values(array_filter(
            array_unique(array_map('strval', $selectFields)),
            static fn (string $field): bool => isset($allowed[$field])
        ));
        if ($selectFields === []) {
            $selectFields = [$key, $orderBy];
        }

        $searchFields = array_values(array_filter(
            array_unique(array_map('strval', $searchFields)),
            static fn (string $field): bool => isset($allowed[$field])
        ));
        if ($searchFields === []) {
            $searchFields = [$orderBy];
        }

        $builder = $this->db->table($this->table)
            ->select($selectFields)
            ->orderBy($orderBy, 'ASC')
            ->limit(max(1, min(5000, $limit)));

        if ($id !== null && $id !== '') {
            $builder->where($key, $id);
        } elseif (trim($query) !== '') {
            $builder->groupStart();
            foreach ($searchFields as $index => $searchField) {
                $index === 0
                    ? $builder->like($searchField, trim($query), 'after')
                    : $builder->orLike($searchField, trim($query), 'after');
            }
            $builder->groupEnd();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Loads rows from this Model's own table by already-resolved IDs.
     *
     * @param string $key Whitelisted identifier column.
     * @param list<int|string> $ids Identifiers to load.
     * @param list<string> $selectFields Columns returned to the caller.
     * @param string $orderBy Whitelisted ordering column.
     * @param int $limit Maximum number of rows.
     * @return array<int,object>
     */
    public function relationRowsByIds(
        string $key,
        array $ids,
        array $selectFields,
        string $orderBy,
        int $limit = 500
    ): array {
        $allowed = array_fill_keys(static::RESOURCE_FIELDS, true);
        if (!isset($allowed[$key], $allowed[$orderBy])) {
            return [];
        }

        $ids = array_values(array_unique(array_map('strval', array_filter(
            $ids,
            static fn ($id): bool => is_scalar($id) && trim((string) $id) !== ''
        ))));
        if ($ids === []) {
            return [];
        }

        $selectFields = array_values(array_filter(
            array_unique(array_map('strval', $selectFields)),
            static fn (string $field): bool => isset($allowed[$field])
        ));
        if ($selectFields === []) {
            $selectFields = [$key, $orderBy];
        }

        return $this->db->table($this->table)
            ->select($selectFields)
            ->whereIn($key, $ids)
            ->orderBy($orderBy, 'ASC')
            ->limit(max(1, min(5000, $limit)))
            ->get()
            ->getResult();
    }

    /**
     * Loads child rows through one of this Model's real FK columns.
     *
     * @param string $foreignKey Real FK column owned by this Model.
     * @param int|string $parentId Parent identifier.
     * @param list<string> $selectFields Child columns returned to the caller.
     * @param string $orderBy Whitelisted child ordering column.
     * @param int $limit Maximum visible children before hasMore is true.
     * @return array{rows:array<int,object>,count:int,hasMore:bool}
     */
    public function childrenByForeignKey(
        string $foreignKey,
        int|string $parentId,
        array $selectFields,
        string $orderBy,
        int $limit = 20
    ): array {
        $allowedFields = array_fill_keys(static::RESOURCE_FIELDS, true);
        $allowedForeignKeys = array_fill_keys(static::FOREIGN_KEY_FIELDS, true);
        if (!isset($allowedForeignKeys[$foreignKey], $allowedFields[$orderBy])) {
            return ['rows' => [], 'count' => 0, 'hasMore' => false];
        }

        $selectFields = array_values(array_filter(
            array_unique(array_map('strval', $selectFields)),
            static fn (string $field): bool => isset($allowedFields[$field])
        ));
        if ($selectFields === []) {
            $selectFields = static::RESOURCE_FIELDS;
        }

        $selectExpressions = [];
        foreach ($selectFields as $field) {
            $type = strtolower((string) (static::RESOURCE_FIELD_TYPES[$field] ?? ''));
            if (in_array($type, ['point', 'geometry', 'linestring', 'polygon', 'multipoint', 'multilinestring', 'multipolygon', 'geometrycollection'], true)) {
                $selectExpressions[] = 'ST_AsText(' . $this->db->protectIdentifiers($field) . ') AS ' . $this->db->protectIdentifiers($field);
            } else {
                $selectExpressions[] = $field;
            }
        }

        $limit = max(1, min(200, $limit));
        $rows = $this->db->table($this->table)
            ->select($selectExpressions, false)
            ->where($foreignKey, $parentId)
            ->orderBy($orderBy, 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();

        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return ['rows' => $rows, 'count' => count($rows), 'hasMore' => $hasMore];
    }

    /**
     * Default Related Create relation options.
     *
     * Generated child Models override this only when the inline-created parent
     * really contains nested foreign-key fields that require selectable options.
     *
     * @return array<string,array<string,list<array{id:string,text:string}>>>
     */
    public function relatedCreateRelationOptions(): array
    {
        return [];
    }

    /**
     * Default many-to-many Related Create relation options.
     *
     * Generated child Models override this only when an inline-created N:N target
     * contains nested foreign-key fields. Keeping the empty contract here avoids
     * feature-specific no-op methods in every generated Model.
     *
     * @return array<string,array<string,list<array{id:string,text:string}>>>
     */
    public function manyToManyRelatedCreateRelationOptions(): array
    {
        return [];
    }

    /** Builds a page-specific API link while preserving the current query. */
    protected function apiLink(array $query, int $page): string
    {
        $query['page'] = $page;
        return current_url() . '?' . http_build_query($query);
    }
}
