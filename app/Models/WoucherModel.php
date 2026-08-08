<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\WoucherEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per woucher; tutte le query del CRUD sono centralizzate qui. */
final class WoucherModel extends Model
{
    protected $table = 'woucher';
    protected $primaryKey = 'woucher_id';
    protected $returnType = WoucherEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'woucher_agenzia_id',
  1 => 'woucher_preno_id',
  2 => 'woucher_hotel_id',
  3 => 'woucher_in',
  4 => 'woucher_notti',
  5 => 'woucher_out',
  6 => 'woucher_numero',
  7 => 'woucher_serie',
  8 => 'woucher_singole',
  9 => 'woucher_singole_staff',
  10 => 'woucher_doppia',
  11 => 'woucher_tripla',
  12 => 'woucher_quadrupla',
  13 => 'woucher_cildren_n',
  14 => 'woucher_doppia_studenti',
  15 => 'woucher_tripla_studenti',
  16 => 'woucher_quadrupla_studenti',
  17 => 'woucher_quintupla_studenti',
  18 => 'woucher_tot_pax',
  19 => 'woucher_tot_adulti',
  20 => 'woucher_tot_studenti',
  21 => 'woucher_note',
  22 => 'woucher_data_record',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'woucher_id' => 
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'woucher_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'woucher_id',
  1 => 'woucher_agenzia_id',
  2 => 'woucher_preno_id',
  3 => 'woucher_hotel_id',
  4 => 'woucher_in',
  5 => 'woucher_notti',
  6 => 'woucher_out',
  7 => 'woucher_numero',
  8 => 'woucher_serie',
  9 => 'woucher_singole',
  10 => 'woucher_singole_staff',
  11 => 'woucher_doppia',
  12 => 'woucher_tripla',
  13 => 'woucher_quadrupla',
  14 => 'woucher_cildren_n',
  15 => 'woucher_doppia_studenti',
  16 => 'woucher_tripla_studenti',
  17 => 'woucher_quadrupla_studenti',
  18 => 'woucher_quintupla_studenti',
  19 => 'woucher_tot_pax',
  20 => 'woucher_tot_adulti',
  21 => 'woucher_tot_studenti',
  22 => 'woucher_note',
);
    private const RELATION_SEARCHES = array (
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('woucher');
        $builder->select([
            'woucher.woucher_id AS woucher_id',
            'woucher.woucher_agenzia_id AS woucher_agenzia_id',
            'woucher.woucher_preno_id AS woucher_preno_id',
            'woucher.woucher_hotel_id AS woucher_hotel_id',
            'woucher.woucher_in AS woucher_in',
            'woucher.woucher_notti AS woucher_notti',
            'woucher.woucher_out AS woucher_out',
            'woucher.woucher_numero AS woucher_numero',
            'woucher.woucher_serie AS woucher_serie',
            'woucher.woucher_singole AS woucher_singole',
            'woucher.woucher_singole_staff AS woucher_singole_staff',
            'woucher.woucher_doppia AS woucher_doppia',
            'woucher.woucher_tripla AS woucher_tripla',
            'woucher.woucher_quadrupla AS woucher_quadrupla',
            'woucher.woucher_cildren_n AS woucher_cildren_n',
            'woucher.woucher_doppia_studenti AS woucher_doppia_studenti',
            'woucher.woucher_tripla_studenti AS woucher_tripla_studenti',
            'woucher.woucher_quadrupla_studenti AS woucher_quadrupla_studenti',
            'woucher.woucher_quintupla_studenti AS woucher_quintupla_studenti',
            'woucher.woucher_tot_pax AS woucher_tot_pax',
            'woucher.woucher_tot_adulti AS woucher_tot_adulti',
            'woucher.woucher_tot_studenti AS woucher_tot_studenti',
            'woucher.woucher_note AS woucher_note',
            'woucher.woucher_data_record AS woucher_data_record'
        ]);

        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('woucher');
        $builder->select([
            'woucher.woucher_id AS woucher_id',
            'woucher.woucher_agenzia_id AS woucher_agenzia_id',
            'woucher.woucher_preno_id AS woucher_preno_id',
            'woucher.woucher_hotel_id AS woucher_hotel_id',
            'woucher.woucher_in AS woucher_in',
            'woucher.woucher_notti AS woucher_notti',
            'woucher.woucher_out AS woucher_out',
            'woucher.woucher_numero AS woucher_numero',
            'woucher.woucher_serie AS woucher_serie',
            'woucher.woucher_singole AS woucher_singole'
        ]);

        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('woucher');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('woucher.woucher_id', $id)
            ->get()
            ->getRow();
    }

    /**
     * Restituisce una pagina HTML-ready con Pager CI4.
     *
     * @return array{rows: array, total: int, page: int, perPage: int, pagerLinks: string, sort: string, direction: string}
     */
    public function getListPage(
        array $filters,
        int $page = 1,
        int $perPage = 25,
        string $sort = 'woucher_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'woucher_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('woucher.' . $sort, $direction)
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

    /** Legge i record di export a blocchi usando la chiave primaria come cursore. */
    public function getExportRows(array $filters, int $limit = 2000, int|string|null $after = null): array
    {
        $builder = $this->db->table('woucher');
        $builder->select([
            'woucher.woucher_id AS woucher_id',
            'woucher.woucher_agenzia_id AS woucher_agenzia_id',
            'woucher.woucher_preno_id AS woucher_preno_id',
            'woucher.woucher_hotel_id AS woucher_hotel_id',
            'woucher.woucher_in AS woucher_in',
            'woucher.woucher_notti AS woucher_notti',
            'woucher.woucher_out AS woucher_out',
            'woucher.woucher_numero AS woucher_numero',
            'woucher.woucher_serie AS woucher_serie',
            'woucher.woucher_singole AS woucher_singole',
            'woucher.woucher_singole_staff AS woucher_singole_staff',
            'woucher.woucher_doppia AS woucher_doppia',
            'woucher.woucher_tripla AS woucher_tripla',
            'woucher.woucher_quadrupla AS woucher_quadrupla',
            'woucher.woucher_cildren_n AS woucher_cildren_n',
            'woucher.woucher_doppia_studenti AS woucher_doppia_studenti',
            'woucher.woucher_tripla_studenti AS woucher_tripla_studenti',
            'woucher.woucher_quadrupla_studenti AS woucher_quadrupla_studenti',
            'woucher.woucher_quintupla_studenti AS woucher_quintupla_studenti',
            'woucher.woucher_tot_pax AS woucher_tot_pax',
            'woucher.woucher_tot_adulti AS woucher_tot_adulti',
            'woucher.woucher_tot_studenti AS woucher_tot_studenti',
            'woucher.woucher_note AS woucher_note'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('woucher.woucher_id >', $after);
        }

        return $builder
            ->orderBy('woucher.woucher_id', 'ASC')
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

    private function countListRows(BaseBuilder $builder, array $filters): int
    {
        if ($this->hasActiveFilters($filters) || self::COUNT_CACHE_SECONDS === 0) {
            return $builder->countAllResults();
        }

        $cacheKey = 'mycrud_list_total_' . md5($this->table);
        $cache = service('cache');
        $cached = $cache->get($cacheKey);
        if (is_int($cached) || (is_string($cached) && ctype_digit($cached))) {
            return (int) $cached;
        }

        $total = $builder->countAllResults();
        $cache->save($cacheKey, $total, self::COUNT_CACHE_SECONDS);

        return $total;
    }

    private function hasActiveFilters(array $filters): bool
    {
        foreach ($filters as $filter) {
            if (is_array($filter) && trim((string) ($filter['field'] ?? '')) !== '') {
                return true;
            }
        }

        return false;
    }

    public function clearListCountCache(): void
    {
        service('cache')->delete('mycrud_list_total_' . md5($this->table));
    }

    /**
     * Applica il filtro dinamico costruito dall'interfaccia del sito.
     * Campo e operatore vengono sempre verificati contro LIST_FILTERS.
     */
    private function applyListFilters(BaseBuilder $builder, array $filters, bool $qualified): void
    {
        $applied = 0;
        $nextLogic = 'and';
        foreach (array_values($filters) as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $field = trim((string) ($filter['field'] ?? ''));
            $operator = trim((string) ($filter['operator'] ?? ''));
            if ($field === '' || !isset(self::LIST_FILTERS[$field])) {
                continue;
            }

            $definition = self::LIST_FILTERS[$field];
            $allowedOperators = (array) ($definition['operators'] ?? ['eq']);
            if (!in_array($operator, $allowedOperators, true)) {
                continue;
            }

            $column = $qualified ? 'woucher.' . $field : $field;
            $value = is_scalar($filter['value'] ?? null) ? trim((string) $filter['value']) : '';
            $valueTo = is_scalar($filter['value_to'] ?? null) ? trim((string) $filter['value_to']) : '';
            // La logica appartiene alla riga precedente e collega la
            // condizione appena applicata a quella successiva nell'interfaccia.
            $logic = $applied > 0 ? $nextLogic : 'and';

            if (!in_array($operator, ['is_null', 'not_null'], true) && $value === '') {
                continue;
            }
            if ($operator === 'between' && $valueTo === '') {
                continue;
            }

            // Ogni condizione è raggruppata: AND/OR resta prevedibile anche
            // per operatori composti come BETWEEN.
            if ($logic === 'or') {
                $builder->orGroupStart();
            } else {
                $builder->groupStart();
            }

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

    /** Elenco REST paginato con whitelist di filtri e ordinamento. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('woucher.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'woucher_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'woucher_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('woucher.' . $sort, $direction)
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

    private function apiLink(array $query, int $page): string
    {
        $query['page'] = $page;
        return current_url() . '?' . http_build_query($query);
    }
    public function relationOptions(): array
    {
        return [

        ];
    }

    /**
     * Ricerca server-side delle opzioni per relazioni grandi.
     * Tabella, chiave e campi descrittivi arrivano solo dalla whitelist generata.
     *
     * @return list<array{id:string,text:string}>
     */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return [];
        }

        $definition = self::RELATION_SEARCHES[$field];
        $key = (string) $definition['key'];
        $displayFields = array_values((array) ($definition['displayFields'] ?? []));
        $selectFields = array_values(array_unique(array_merge([$key], $displayFields)));
        $limit = max(1, min(100, $limit));
        $builder = $this->db->table((string) $definition['table'])
            ->select($selectFields)
            ->orderBy((string) $definition['displayField'], 'ASC')
            ->limit($limit);

        $query = trim($query);
        if ($query !== '' && $displayFields !== []) {
            $builder->groupStart();
            foreach ($displayFields as $index => $displayColumn) {
                if ($index === 0) {
                    $builder->like((string) $displayColumn, $query, 'after');
                } else {
                    $builder->orLike((string) $displayColumn, $query, 'after');
                }
            }
            $builder->groupEnd();
        }

        $rows = $builder->get()->getResultArray();
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => (string) ($row[$key] ?? ''),
                'text' => $this->formatRelationLabel($row, $definition),
            ];
        }

        return $result;
    }

    /** Restituisce una FK valida e la sua descrizione; usato dal Create contestuale. */
    public function relationOptionById(string $field, int|string $id): ?array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return null;
        }

        $definition = self::RELATION_SEARCHES[$field];
        $key = (string) $definition['key'];
        $displayFields = array_values((array) ($definition['displayFields'] ?? []));
        $selectFields = array_values(array_unique(array_merge([$key], $displayFields)));
        $row = $this->db->table((string) $definition['table'])
            ->select($selectFields)
            ->where($key, $id)
            ->limit(1)
            ->get()
            ->getRowArray();

        if (!is_array($row)) {
            return null;
        }

        return [
            'id' => (string) ($row[$key] ?? ''),
            'text' => $this->formatRelationLabel($row, $definition),
        ];
    }

    private function toRelationOptions(array $rows, string $field): array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return [];
        }

        $definition = self::RELATION_SEARCHES[$field];
        $key = (string) $definition['key'];
        $options = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $options[(string) ($row[$key] ?? '')] = $this->formatRelationLabel($row, $definition);
        }
        return $options;
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

    public function loadHasMany(int|string $parentId): array
    {
        $result = [];

        return $result;
    }

}
