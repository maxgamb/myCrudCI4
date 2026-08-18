<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\NicerButSlowerFilmListEntity;
use CodeIgniter\Database\BaseBuilder;

/**
 * Read-only Model for SQL VIEW `nicer_but_slower_film_list`. Centralizes read queries, filters, and export.
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class NicerButSlowerFilmListModel extends BaseCrudModel
{

    protected $table = 'nicer_but_slower_film_list';
    protected $primaryKey = 'FID';
    protected $returnType = NicerButSlowerFilmListEntity::class;

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = array (
  0 => 'FID',
  1 => 'title',
  2 => 'description',
  3 => 'category',
  4 => 'price',
  5 => 'length',
  6 => 'rating',
  7 => 'actors',
);
    protected const RESOURCE_FIELD_TYPES = array (
  'FID' => 'smallint',
  'title' => 'varchar',
  'description' => 'text',
  'category' => 'varchar',
  'price' => 'decimal',
  'length' => 'smallint',
  'rating' => 'enum',
  'actors' => 'text',
);
    protected const FOREIGN_KEY_FIELDS = array (
);
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    protected const LIST_FILTERS = array (
  'FID' =>
  array (
    'type' => 'primary',
    'operators' =>
    array (
      0 => 'eq',
      1 => 'neq',
      2 => 'gt',
      3 => 'gte',
      4 => 'lt',
      5 => 'lte',
      6 => 'between',
    ),
  ),
);
    private const SORTABLE_FIELDS = array (
  0 => 'FID',
);
    private const EXPORT_FIELDS = array (
  0 => 'FID',
  1 => 'title',
  2 => 'description',
  3 => 'category',
  4 => 'price',
  5 => 'length',
  6 => 'rating',
  7 => 'actors',
);
    protected const COUNT_CACHE_SECONDS = 60;

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('nicer_but_slower_film_list');
        $builder->select([
            'nicer_but_slower_film_list.FID AS FID',
            'nicer_but_slower_film_list.title AS title',
            'nicer_but_slower_film_list.description AS description',
            'nicer_but_slower_film_list.category AS category',
            'nicer_but_slower_film_list.price AS price',
            'nicer_but_slower_film_list.length AS length',
            'nicer_but_slower_film_list.rating AS rating',
            'nicer_but_slower_film_list.actors AS actors'
        ]);

        return $builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('nicer_but_slower_film_list');
        $builder->select([
            'nicer_but_slower_film_list.FID AS FID',
            'nicer_but_slower_film_list.title AS title',
            'nicer_but_slower_film_list.description AS description',
            'nicer_but_slower_film_list.category AS category',
            'nicer_but_slower_film_list.price AS price',
            'nicer_but_slower_film_list.length AS length',
            'nicer_but_slower_film_list.rating AS rating',
            'nicer_but_slower_film_list.actors AS actors'
        ]);

        return $builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('nicer_but_slower_film_list');
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
        string $sort = 'FID',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'FID';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('nicer_but_slower_film_list.' . $sort, $direction)
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
        $builder = $this->db->table('nicer_but_slower_film_list');
        $builder->select([
            'nicer_but_slower_film_list.FID AS FID',
            'nicer_but_slower_film_list.title AS title',
            'nicer_but_slower_film_list.description AS description',
            'nicer_but_slower_film_list.category AS category',
            'nicer_but_slower_film_list.price AS price',
            'nicer_but_slower_film_list.length AS length',
            'nicer_but_slower_film_list.rating AS rating',
            'nicer_but_slower_film_list.actors AS actors'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('nicer_but_slower_film_list.FID >', $after);
        }

        return $builder
            ->orderBy('nicer_but_slower_film_list.FID', 'ASC')
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

    /** Paginated REST list with filter and sorting whitelists. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('nicer_but_slower_film_list.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'FID');
        $sort = in_array($sort, $sortable, true) ? $sort : 'FID';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('nicer_but_slower_film_list.' . $sort, $direction)
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
