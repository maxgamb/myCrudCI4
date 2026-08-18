<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\FilmEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `film`. Centralizes CRUD queries, filters, relations, and persistence.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class FilmModel extends BaseCrudModel
{

    protected $table = 'film';
    protected $primaryKey = 'film_id';
    protected $returnType = FilmEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
  3 => 'release_year',
  4 => 'language_id',
  5 => 'original_language_id',
  6 => 'rental_duration',
  7 => 'rental_rate',
  8 => 'length',
  9 => 'replacement_cost',
  10 => 'rating',
  11 => 'special_features',
  12 => 'last_update',
  13 => 'uploads',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'film_id' => 'smallint',
  'title' => 'varchar',
  'description' => 'text',
  'release_year' => 'year',
  'language_id' => 'tinyint',
  'original_language_id' => 'tinyint',
  'rental_duration' => 'tinyint',
  'rental_rate' => 'decimal',
  'length' => 'smallint',
  'replacement_cost' => 'decimal',
  'rating' => 'enum',
  'special_features' => 'set',
  'last_update' => 'timestamp',
  'uploads' => 'varchar',
);
    protected const FOREIGN_KEY_FIELDS = array (
  0 => 'language_id',
  1 => 'original_language_id',
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'title',
  1 => 'description',
  2 => 'release_year',
  3 => 'language_id',
  4 => 'original_language_id',
  5 => 'rental_duration',
  6 => 'rental_rate',
  7 => 'length',
  8 => 'replacement_cost',
  9 => 'rating',
  10 => 'special_features',
  11 => 'uploads',
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
  'language_id' =>
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
  'original_language_id' =>
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
  0 => 'film_id',
  1 => 'title',
  2 => 'language_id',
  3 => 'original_language_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
  3 => 'release_year',
  4 => 'language_id',
  5 => 'original_language_id',
  6 => 'rental_duration',
  7 => 'rental_rate',
  8 => 'length',
  9 => 'replacement_cost',
  10 => 'rating',
  11 => 'special_features',
  12 => 'last_update',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film');
        $builder->select([
            'film.film_id AS film_id',
            'film.title AS title',
            'film.description AS description',
            'film.release_year AS release_year',
            'film.language_id AS language_id',
            'film.original_language_id AS original_language_id',
            'film.rental_duration AS rental_duration',
            'film.rental_rate AS rental_rate',
            'film.length AS length',
            'film.replacement_cost AS replacement_cost',
            'film.rating AS rating',
            'film.special_features AS special_features',
            'film.last_update AS last_update',
            'film.uploads AS uploads',
            'language__language_id.name AS language_id__label',
            'language__original_language_id.name AS original_language_id__label'
        ]);
        $this->joinLanguageLanguageId($builder);
        $this->joinLanguageOriginalLanguageId($builder);
        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film');
        $builder->select([
            'film.film_id AS film_id',
            'film.title AS title',
            'film.description AS description',
            'film.release_year AS release_year',
            'film.language_id AS language_id',
            'film.original_language_id AS original_language_id',
            'film.rental_duration AS rental_duration',
            'film.rental_rate AS rental_rate',
            'film.length AS length',
            'film.replacement_cost AS replacement_cost',
            'film.rating AS rating',
            'film.special_features AS special_features',
            'film.last_update AS last_update',
            'language__language_id.name AS language_id__label',
            'language__original_language_id.name AS original_language_id__label'
        ]);
        $this->joinLanguageLanguageId($builder);
        $this->joinLanguageOriginalLanguageId($builder);
        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film');
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
            ->orderBy('film.' . $sort, $direction)
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
        $builder = $this->db->table('film');
        $builder->select([
            'film.film_id AS film_id',
            'film.title AS title',
            'film.description AS description',
            'film.release_year AS release_year',
            'film.language_id AS language_id',
            'film.original_language_id AS original_language_id',
            'film.rental_duration AS rental_duration',
            'film.rental_rate AS rental_rate',
            'film.length AS length',
            'film.replacement_cost AS replacement_cost',
            'film.rating AS rating',
            'film.special_features AS special_features',
            'film.last_update AS last_update',
            'language__language_id.name AS language_id__label',
            'language__original_language_id.name AS original_language_id__label'
        ]);
        $this->joinLanguageLanguageId($builder);
        $this->joinLanguageOriginalLanguageId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('film.film_id >', $after);
        }

        return $builder
            ->orderBy('film.film_id', 'ASC')
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
    /** Returns selectable actor targets for relation many__film_actor__film_id. */
    public function getActorOptionsForManyFilmActorFilmId(): array
    {
        $rows = (new ActorModel())->relationOptionRows(
            'actor_id',
            array (
  0 => 'actor_id',
  1 => 'first_name',
  2 => 'last_name',
),
            'first_name'
        );
        return array_map(static function (array $row): array {
            $parts = [];
            foreach (array (
  0 => 'first_name',
  1 => 'last_name',
) as $field) {
                $value = trim((string) ($row[$field] ?? ''));
                if ($value !== '') { $parts[] = $value; }
            }
            return [
                'id' => (string) ($row['actor_id'] ?? ''),
                'text' => $parts !== [] ? implode(' ', $parts) : (string) ($row['actor_id'] ?? ''),
            ];
        }, $rows);
    }

    /** Returns selected actor IDs from pivot film_actor. */
    public function getSelectedActorIdsForManyFilmActorFilmId(int|string $parentId): array
    {
        $rows = $this->db->table('film_actor')
            ->select('actor_id')
            ->where('film_id', $parentId)
            ->get()
            ->getResultArray();
        return array_map('strval', array_column($rows, 'actor_id'));
    }

    /** Synchronizes pivot film_actor with explicit ActorModel validation. */
    public function syncActorIdsForManyFilmActorFilmId(int|string $parentId, array $ids): void
    {
        $ids = array_values(array_unique(array_map('strval', array_filter(
            $ids,
            static fn (mixed $id): bool => is_scalar($id) && trim((string) $id) !== ''
        ))));
        if (count($ids) > 500) {
            throw new RuntimeException('Too many many-to-many associations for many__film_actor__film_id.');
        }
        if ($ids !== []) {
            $validRows = (new ActorModel())->relationRowsByIds(
                'actor_id', $ids, ['actor_id'], 'actor_id', count($ids)
            );
            $valid = array_map(static fn (object $row): string => (string) ($row->actor_id ?? ''), $validRows);
            if (count(array_unique($valid)) !== count($ids)) {
                throw new RuntimeException('One or more actor records do not exist for many__film_actor__film_id.');
            }
        }
        $existingRows = $this->db->table('film_actor')
            ->select('actor_id')
            ->where('film_id', $parentId)
            ->get()
            ->getResultArray();
        $existing = array_map('strval', array_column($existingRows, 'actor_id'));
        foreach (array_diff($ids, $existing) as $attachId) {
            if (!$this->db->table('film_actor')->insert(['film_id' => $parentId, 'actor_id' => $attachId])) {
                throw new RuntimeException('Attach pivot failed for many__film_actor__film_id.');
            }
        }
        $detach = array_values(array_diff($existing, $ids));
        if ($detach !== []) {
            $this->db->table('film_actor')->where('film_id', $parentId)->whereIn('actor_id', $detach)->delete();
        }
    }

    /** Returns selectable category targets for relation many__film_category__film_id. */
    public function getCategoryOptionsForManyFilmCategoryFilmId(): array
    {
        $rows = (new CategoryModel())->relationOptionRows(
            'category_id',
            array (
  0 => 'category_id',
  1 => 'name',
),
            'name'
        );
        return array_map(static function (array $row): array {
            $parts = [];
            foreach (array (
  0 => 'name',
) as $field) {
                $value = trim((string) ($row[$field] ?? ''));
                if ($value !== '') { $parts[] = $value; }
            }
            return [
                'id' => (string) ($row['category_id'] ?? ''),
                'text' => $parts !== [] ? implode(' ', $parts) : (string) ($row['category_id'] ?? ''),
            ];
        }, $rows);
    }

    /** Returns selected category IDs from pivot film_category. */
    public function getSelectedCategoryIdsForManyFilmCategoryFilmId(int|string $parentId): array
    {
        $rows = $this->db->table('film_category')
            ->select('category_id')
            ->where('film_id', $parentId)
            ->get()
            ->getResultArray();
        return array_map('strval', array_column($rows, 'category_id'));
    }

    /** Synchronizes pivot film_category with explicit CategoryModel validation. */
    public function syncCategoryIdsForManyFilmCategoryFilmId(int|string $parentId, array $ids): void
    {
        $ids = array_values(array_unique(array_map('strval', array_filter(
            $ids,
            static fn (mixed $id): bool => is_scalar($id) && trim((string) $id) !== ''
        ))));
        if (count($ids) > 500) {
            throw new RuntimeException('Too many many-to-many associations for many__film_category__film_id.');
        }
        if ($ids !== []) {
            $validRows = (new CategoryModel())->relationRowsByIds(
                'category_id', $ids, ['category_id'], 'category_id', count($ids)
            );
            $valid = array_map(static fn (object $row): string => (string) ($row->category_id ?? ''), $validRows);
            if (count(array_unique($valid)) !== count($ids)) {
                throw new RuntimeException('One or more category records do not exist for many__film_category__film_id.');
            }
        }
        $existingRows = $this->db->table('film_category')
            ->select('category_id')
            ->where('film_id', $parentId)
            ->get()
            ->getResultArray();
        $existing = array_map('strval', array_column($existingRows, 'category_id'));
        foreach (array_diff($ids, $existing) as $attachId) {
            if (!$this->db->table('film_category')->insert(['film_id' => $parentId, 'category_id' => $attachId])) {
                throw new RuntimeException('Attach pivot failed for many__film_category__film_id.');
            }
        }
        $detach = array_values(array_diff($existing, $ids));
        if ($detach !== []) {
            $this->db->table('film_category')->where('film_id', $parentId)->whereIn('category_id', $detach)->delete();
        }
    }
    /** @return array<string,list<array{id:string,text:string}>> */
    public function manyToManyFormOptions(): array
    {
        return [
            'many__film_actor__film_id' => $this->getActorOptionsForManyFilmActorFilmId(),
            'many__film_category__film_id' => $this->getCategoryOptionsForManyFilmCategoryFilmId(),
        ];
    }

    /** @return array<string,list<string>> */
    public function manyToManySelected(int|string $parentId): array
    {
        return [
            'many__film_actor__film_id' => $this->getSelectedActorIdsForManyFilmActorFilmId($parentId),
            'many__film_category__film_id' => $this->getSelectedCategoryIdsForManyFilmCategoryFilmId($parentId),
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
    /** FK film.language_id -> language.language_id; risultato: language_id__label. */
    private function joinLanguageLanguageId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'language AS language__language_id',
            'language__language_id.language_id = film.language_id',
            'left'
        );

        return $builder;
    }
    /** FK film.original_language_id -> language.language_id; risultato: original_language_id__label. */
    private function joinLanguageOriginalLanguageId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'language AS language__original_language_id',
            'language__original_language_id.language_id = film.original_language_id',
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
                $builder->where('film.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'film_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'film_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('film.' . $sort, $direction)
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
     * Returns ready-to-render options for the explicit language_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getLanguageLanguageIdOptions(): array
    {
        $rows = (new LanguageModel())->relationOptionRows(
            'language_id',
            array (
  0 => 'language_id',
  1 => 'name',
),
            'name'
        );
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['language_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }
    /**
     * Returns ready-to-render options for the explicit original_language_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getLanguageOriginalLanguageIdOptions(): array
    {
        $rows = (new LanguageModel())->relationOptionRows(
            'language_id',
            array (
  0 => 'language_id',
  1 => 'name',
),
            'name'
        );
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row['language_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
    }
    /** Searches options for explicit belongsTo relation language_id. */
    public function searchLanguageIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $rows = (new LanguageModel())->relationOptionRows(
            'language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name', $query, null, max(1, min(100, $limit)), array (
  0 => 'name',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['language_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation language_id. */
    public function findLanguageIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $rows = (new LanguageModel())->relationOptionRows(
            'language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name', '', (string) $id, 1, array (
  0 => 'name',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['language_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    /** Searches options for explicit belongsTo relation original_language_id. */
    public function searchOriginalLanguageIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $rows = (new LanguageModel())->relationOptionRows(
            'language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name', $query, null, max(1, min(100, $limit)), array (
  0 => 'name',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['language_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation original_language_id. */
    public function findOriginalLanguageIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $rows = (new LanguageModel())->relationOptionRows(
            'language_id', array (
  0 => 'language_id',
  1 => 'name',
), 'name', '', (string) $id, 1, array (
  0 => 'name',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['language_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }
    /** @return array<string,array<string,string>> */
    public function relationOptions(): array
    {
        return [
            'language_id' => $this->getLanguageLanguageIdOptions(),
            'original_language_id' => $this->getLanguageOriginalLanguageIdOptions(),
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        switch ($field) {
            case 'language_id': return $this->searchLanguageIdOptions($query, $limit);
            case 'original_language_id': return $this->searchOriginalLanguageIdOptions($query, $limit);
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        switch ($field) {
            case 'language_id': return $this->findLanguageIdOption($id);
            case 'original_language_id': return $this->findOriginalLanguageIdOption($id);
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
     * HasMany scaffolding delegated to the Model that owns table film_actor.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getFilmActorByFilmId(int|string $parentId, int $limit = 20): array
    {
        return (new FilmActorModel())->childrenByForeignKey(
            'film_id',
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
     * HasMany scaffolding delegated to the Model that owns table film_category.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getFilmCategoryByFilmId(int|string $parentId, int $limit = 20): array
    {
        return (new FilmCategoryModel())->childrenByForeignKey(
            'film_id',
            $parentId,
            array (
  0 => 'film_id',
  1 => 'category_id',
  2 => 'last_update',
),
            'film_id',
            $limit
        );
    }
    /**
     * HasMany scaffolding delegated to the Model that owns table inventory.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function getInventoryByFilmId(int|string $parentId, int $limit = 20): array
    {
        return (new InventoryModel())->childrenByForeignKey(
            'film_id',
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
     * Reads the film_actor pivot owned by this Model, then delegates target rows
     * to ActorModel. No target-table SQL is composed here.
     */
    public function getActorViaFilmActor(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $pivotRows = $this->db->table('film_actor')
            ->select('actor_id')
            ->where('film_id', $parentId)
            ->limit($limit + 1)
            ->get()
            ->getResultArray();
        $hasMore = count($pivotRows) > $limit;
        if ($hasMore) {
            array_pop($pivotRows);
        }
        $relatedIds = array_values(array_unique(array_map('strval', array_column($pivotRows, 'actor_id'))));
        $rows = $relatedIds === []
            ? []
            : (new ActorModel())->relationRowsByIds(
                'actor_id',
                $relatedIds,
                array (
  0 => 'actor_id',
  1 => 'first_name',
  2 => 'last_name',
),
                'first_name',
                $limit
            );
        return ['rows' => $rows, 'count' => count($rows), 'hasMore' => $hasMore];
    }
    /**
     * Reads the film_category pivot owned by this Model, then delegates target rows
     * to CategoryModel. No target-table SQL is composed here.
     */
    public function getCategoryViaFilmCategory(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $pivotRows = $this->db->table('film_category')
            ->select('category_id')
            ->where('film_id', $parentId)
            ->limit($limit + 1)
            ->get()
            ->getResultArray();
        $hasMore = count($pivotRows) > $limit;
        if ($hasMore) {
            array_pop($pivotRows);
        }
        $relatedIds = array_values(array_unique(array_map('strval', array_column($pivotRows, 'category_id'))));
        $rows = $relatedIds === []
            ? []
            : (new CategoryModel())->relationRowsByIds(
                'category_id',
                $relatedIds,
                array (
  0 => 'category_id',
  1 => 'name',
),
                'name',
                $limit
            );
        return ['rows' => $rows, 'count' => count($rows), 'hasMore' => $hasMore];
    }
    /** @return array<string,array<string,mixed>> */
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['film_actor__film_id'] = $this->getFilmActorByFilmId($parentId, 20);

        $result['film_category__film_id'] = $this->getFilmCategoryByFilmId($parentId, 20);

        $result['inventory__film_id'] = $this->getInventoryByFilmId($parentId, 20);

        $result['many__film_actor__film_id'] = $this->getActorViaFilmActor($parentId, 20);

        $result['many__film_category__film_id'] = $this->getCategoryViaFilmCategory($parentId, 20);
        return $result;
    }
}
