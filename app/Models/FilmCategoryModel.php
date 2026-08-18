<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\FilmCategoryEntity;
use CodeIgniter\Database\BaseBuilder;
use RuntimeException;

/**
 * Model for `film_category` with Read + Create capability. Does not generate record-level update/delete.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class FilmCategoryModel extends BaseCrudModel
{

    protected $table = 'film_category';
    protected $primaryKey = 'film_id';
    protected $returnType = FilmCategoryEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'film_id',
  1 => 'category_id',
  2 => 'last_update',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'film_id' => 'smallint',
  'category_id' => 'tinyint',
  'last_update' => 'timestamp',
);
    protected const FOREIGN_KEY_FIELDS = array (
  0 => 'category_id',
  1 => 'film_id',
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'film_id',
  1 => 'category_id',
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
  'category_id' =>
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
  1 => 'category_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'film_id',
  1 => 'category_id',
  2 => 'last_update',
);
    private const PRIMARY_KEYS = array (
  0 => 'film_id',
  1 => 'category_id',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_category');
        $builder->select([
            'film_category.film_id AS film_id',
            'film_category.category_id AS category_id',
            'film_category.last_update AS last_update',
            'category__category_id.name AS category_id__label',
            'film__film_id.title AS film_id__label'
        ]);
        $this->joinCategoryCategoryId($builder);
        $this->joinFilmFilmId($builder);
        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_category');
        $builder->select([
            'film_category.film_id AS film_id',
            'film_category.category_id AS category_id',
            'film_category.last_update AS last_update',
            'category__category_id.name AS category_id__label',
            'film__film_id.title AS film_id__label'
        ]);
        $this->joinCategoryCategoryId($builder);
        $this->joinFilmFilmId($builder);
        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_category');
        return $builder;
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
            ->orderBy('film_category.' . $sort, $direction)
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
        $builder = $this->db->table('film_category');
        $builder->select([
            'film_category.film_id AS film_id',
            'film_category.category_id AS category_id',
            'film_category.last_update AS last_update',
            'category__category_id.name AS category_id__label',
            'film__film_id.title AS film_id__label'
        ]);
        $this->joinCategoryCategoryId($builder);
        $this->joinFilmFilmId($builder);
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $cursor = json_decode((string) $after, true);
            if (is_array($cursor)) {
                $keys = self::PRIMARY_KEYS;
                $builder->groupStart();
                foreach ($keys as $position => $key) {
                    $builder->orGroupStart();
                    for ($i = 0; $i < $position; $i++) {
                        if (array_key_exists($keys[$i], $cursor)) {
                            $builder->where($this->table . '.' . $keys[$i], $cursor[$keys[$i]]);
                        }
                    }
                    if (array_key_exists($key, $cursor)) {
                        $builder->where($this->table . '.' . $key . ' >', $cursor[$key]);
                    }
                    $builder->groupEnd();
                }
                $builder->groupEnd();
            }
        }

        return $builder
            ->orderBy('film_category.film_id', 'ASC')
            ->orderBy('film_category.category_id', 'ASC')
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
    /** FK film_category.category_id -> category.category_id; risultato: category_id__label. */
    private function joinCategoryCategoryId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'category AS category__category_id',
            'category__category_id.category_id = film_category.category_id',
            'left'
        );

        return $builder;
    }
    /** FK film_category.film_id -> film.film_id; risultato: film_id__label. */
    private function joinFilmFilmId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'film AS film__film_id',
            'film__film_id.film_id = film_category.film_id',
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
                $builder->where('film_category.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'film_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'film_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('film_category.' . $sort, $direction)
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
     * Returns ready-to-render options for the explicit category_id belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function getCategoryCategoryIdOptions(): array
    {
        $rows = (new CategoryModel())->relationOptionRows(
            'category_id',
            array (
  0 => 'category_id',
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
            $options[(string) ($row['category_id'] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
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
  1 => 'title',
),
            'title'
        );
        $definition = array (
  'displayField' => 'title',
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
        return $result;
    }
    /** Searches options for explicit belongsTo relation category_id. */
    public function searchCategoryIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $rows = (new CategoryModel())->relationOptionRows(
            'category_id', array (
  0 => 'category_id',
  1 => 'name',
), 'name', $query, null, max(1, min(100, $limit)), array (
  0 => 'name',
)
        );
        $result = [];
        foreach ($rows as $row) {
            if (!is_array($row)) { continue; }
            $result[] = [
                'id' => (string) ($row['category_id'] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }
        return $result;
    }

    /** Finds one option for explicit belongsTo relation category_id. */
    public function findCategoryIdOption(int|string $id): ?array
    {
        $definition = array (
  'displayField' => 'name',
  'displayTemplate' => '',
);
        $rows = (new CategoryModel())->relationOptionRows(
            'category_id', array (
  0 => 'category_id',
  1 => 'name',
), 'name', '', (string) $id, 1, array (
  0 => 'name',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['category_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    /** Searches options for explicit belongsTo relation film_id. */
    public function searchFilmIdOptions(string $query, int $limit = 20): array
    {
        $definition = array (
  'displayField' => 'title',
  'displayTemplate' => '',
);
        $rows = (new FilmModel())->relationOptionRows(
            'film_id', array (
  0 => 'film_id',
  1 => 'title',
), 'title', $query, null, max(1, min(100, $limit)), array (
  0 => 'title',
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
  'displayField' => 'title',
  'displayTemplate' => '',
);
        $rows = (new FilmModel())->relationOptionRows(
            'film_id', array (
  0 => 'film_id',
  1 => 'title',
), 'title', '', (string) $id, 1, array (
  0 => 'title',
)
        );
        $row = $rows[0] ?? null;
        if (!is_array($row)) { return null; }
        return [
            'id' => (string) ($row['film_id'] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }
    /** @return array<string,array<string,string>> */
    public function relationOptions(): array
    {
        return [
            'category_id' => $this->getCategoryCategoryIdOptions(),
            'film_id' => $this->getFilmFilmIdOptions(),
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        switch ($field) {
            case 'category_id': return $this->searchCategoryIdOptions($query, $limit);
            case 'film_id': return $this->searchFilmIdOptions($query, $limit);
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        switch ($field) {
            case 'category_id': return $this->findCategoryIdOption($id);
            case 'film_id': return $this->findFilmIdOption($id);
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
}
