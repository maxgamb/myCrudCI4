<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ActorEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `actor`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class ActorModel extends BaseCrudModel
{

    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    protected $returnType = ActorEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'actor_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'last_update',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'actor_id' => 'smallint',
  'first_name' => 'varchar',
  'last_name' => 'varchar',
  'last_update' => 'timestamp',
);
    protected const FOREIGN_KEY_FIELDS = array (
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'first_name',
  1 => 'last_name',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
  'actor_id' =>
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'actor_id',
  1 => 'last_name',
);
    private const EXPORT_FIELDS = array (
  0 => 'actor_id',
  1 => 'first_name',
  2 => 'last_name',
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
        $builder = $this->db->table('actor');
        $builder->select([
            'actor.actor_id AS actor_id',
            'actor.first_name AS first_name',
            'actor.last_name AS last_name',
            'actor.last_update AS last_update'
        ]);

        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('actor');
        $builder->select([
            'actor.actor_id AS actor_id',
            'actor.first_name AS first_name',
            'actor.last_name AS last_name',
            'actor.last_update AS last_update'
        ]);

        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('actor');
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
        string $sort = 'actor_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'actor_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('actor.' . $sort, $direction)
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
        $builder = $this->db->table('actor');
        $builder->select([
            'actor.actor_id AS actor_id',
            'actor.first_name AS first_name',
            'actor.last_name AS last_name',
            'actor.last_update AS last_update'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('actor.actor_id >', $after);
        }

        return $builder
            ->orderBy('actor.actor_id', 'ASC')
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
    /** Returns selectable film targets for relation many__film_actor__actor_id. */
    public function getFilmOptionsForManyFilmActorActorId(): array
    {
        $rows = (new FilmModel())->relationOptionRows(
            'film_id',
            array (
  0 => 'film_id',
  1 => 'title',
),
            'title'
        );
        return array_map(static function (array $row): array {
            $parts = [];
            foreach (array (
  0 => 'title',
) as $field) {
                $value = trim((string) ($row[$field] ?? ''));
                if ($value !== '') { $parts[] = $value; }
            }
            return [
                'id' => (string) ($row['film_id'] ?? ''),
                'text' => $parts !== [] ? implode(' ', $parts) : (string) ($row['film_id'] ?? ''),
            ];
        }, $rows);
    }

    /** Returns selected film IDs from pivot film_actor. */
    public function getSelectedFilmIdsForManyFilmActorActorId(int|string $parentId): array
    {
        $rows = $this->db->table('film_actor')
            ->select('film_id')
            ->where('actor_id', $parentId)
            ->get()
            ->getResultArray();
        return array_map('strval', array_column($rows, 'film_id'));
    }

    /** Synchronizes pivot film_actor with explicit FilmModel validation. */
    public function syncFilmIdsForManyFilmActorActorId(int|string $parentId, array $ids): void
    {
        $ids = array_values(array_unique(array_map('strval', array_filter(
            $ids,
            static fn (mixed $id): bool => is_scalar($id) && trim((string) $id) !== ''
        ))));
        if (count($ids) > 500) {
            throw new RuntimeException('Too many many-to-many associations for many__film_actor__actor_id.');
        }
        if ($ids !== []) {
            $validRows = (new FilmModel())->relationRowsByIds(
                'film_id', $ids, ['film_id'], 'film_id', count($ids)
            );
            $valid = array_map(static fn (object $row): string => (string) ($row->film_id ?? ''), $validRows);
            if (count(array_unique($valid)) !== count($ids)) {
                throw new RuntimeException('One or more film records do not exist for many__film_actor__actor_id.');
            }
        }
        $existingRows = $this->db->table('film_actor')
            ->select('film_id')
            ->where('actor_id', $parentId)
            ->get()
            ->getResultArray();
        $existing = array_map('strval', array_column($existingRows, 'film_id'));
        foreach (array_diff($ids, $existing) as $attachId) {
            if (!$this->db->table('film_actor')->insert(['actor_id' => $parentId, 'film_id' => $attachId])) {
                throw new RuntimeException('Attach pivot failed for many__film_actor__actor_id.');
            }
        }
        $detach = array_values(array_diff($existing, $ids));
        if ($detach !== []) {
            $this->db->table('film_actor')->where('actor_id', $parentId)->whereIn('film_id', $detach)->delete();
        }
    }
    /** @return array<string,list<array{id:string,text:string}>> */
    public function manyToManyFormOptions(): array
    {
        return [
            'many__film_actor__actor_id' => $this->getFilmOptionsForManyFilmActorActorId(),
        ];
    }

    /**
     * Options for foreign keys inside inline-created many-to-many targets.
     * Each target lookup is delegated statically to the owning Model.
     *
     * @return array<string,array<string,list<array{id:string,text:string}>>>
     */
    public function manyToManyRelatedCreateRelationOptions(): array
    {
        $result = [];
        $rowsM2MManyFilmActorActorIdLanguageId = (new LanguageModel())->relationOptionRows('language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name');
        foreach ($rowsM2MManyFilmActorActorIdLanguageId as $row) { $result['many__film_actor__actor_id']['language_id'][] = ['id' => (string) ($row['language_id'] ?? ''), 'text' => (string) ($row['name'] ?? $row['language_id'] ?? '')]; }
        $rowsM2MManyFilmActorActorIdOriginalLanguageId = (new LanguageModel())->relationOptionRows('language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name');
        foreach ($rowsM2MManyFilmActorActorIdOriginalLanguageId as $row) { $result['many__film_actor__actor_id']['original_language_id'][] = ['id' => (string) ($row['language_id'] ?? ''), 'text' => (string) ($row['name'] ?? $row['language_id'] ?? '')]; }
        return $result;
    }
    /** @return array<string,list<string>> */
    public function manyToManySelected(int|string $parentId): array
    {
        return [
            'many__film_actor__actor_id' => $this->getSelectedFilmIdsForManyFilmActorActorId($parentId),
        ];
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
                $builder->where('actor.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'actor_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'actor_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('actor.' . $sort, $direction)
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
     * HasMany scaffolding delegated to the Model that owns table film_actor.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getFilmActorByActorId(int|string $parentId, int $limit = 20): array
    {
        return (new FilmActorModel())->childrenByForeignKey(
            'actor_id',
            $parentId,
            array (
  0 => 'actor_id',
  1 => 'film_id',
  2 => 'last_update',
),
            'actor_id',
            $limit
        );
    }
    /**
     * Reads the film_actor pivot owned by this Model, then delegates target rows
     * to FilmModel. No target-table SQL is composed here.
     */
    public function getFilmViaFilmActor(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $pivotRows = $this->db->table('film_actor')
            ->select('film_id')
            ->where('actor_id', $parentId)
            ->limit($limit + 1)
            ->get()
            ->getResultArray();
        $hasMore = count($pivotRows) > $limit;
        if ($hasMore) {
            array_pop($pivotRows);
        }
        $relatedIds = array_values(array_unique(array_map('strval', array_column($pivotRows, 'film_id'))));
        $rows = $relatedIds === []
            ? []
            : (new FilmModel())->relationRowsByIds(
                'film_id',
                $relatedIds,
                array (
  0 => 'film_id',
  1 => 'title',
),
                'title',
                $limit
            );
        return ['rows' => $rows, 'count' => count($rows), 'hasMore' => $hasMore];
    }
    /** @return array<string,array<string,mixed>> */
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['film_actor__actor_id'] = $this->getFilmActorByActorId($parentId, 20);

        $result['many__film_actor__actor_id'] = $this->getFilmViaFilmActor($parentId, 20);
        return $result;
    }
}
