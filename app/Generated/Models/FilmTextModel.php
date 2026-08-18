<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\FilmTextEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `film_text`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class FilmTextModel extends BaseCrudModel
{

    protected $table = 'film_text';
    protected $primaryKey = 'film_id';
    protected $returnType = FilmTextEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'film_id' => 'smallint',
  'title' => 'varchar',
  'description' => 'text',
);
    protected const FOREIGN_KEY_FIELDS = array (
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
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
  'title' =>
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'film_id',
  1 => 'title',
);
    private const EXPORT_FIELDS = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_text');
        $builder->select([
            'film_text.film_id AS film_id',
            'film_text.title AS title',
            'film_text.description AS description'
        ]);

        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_text');
        $builder->select([
            'film_text.film_id AS film_id',
            'film_text.title AS title',
            'film_text.description AS description'
        ]);

        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_text');
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
        string $sort = 'film_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'film_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('film_text.' . $sort, $direction)
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
        $builder = $this->db->table('film_text');
        $builder->select([
            'film_text.film_id AS film_id',
            'film_text.title AS title',
            'film_text.description AS description'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('film_text.film_id >', $after);
        }

        return $builder
            ->orderBy('film_text.film_id', 'ASC')
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
        if (array_key_exists('film_id', $data) && (is_int($data['film_id']) || is_string($data['film_id']))) {
            return $data['film_id'];
        }
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
    /** Paginated REST list with filter and sorting whitelists. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('film_text.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'film_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'film_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('film_text.' . $sort, $direction)
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
}
