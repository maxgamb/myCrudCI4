<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ObmpReviewEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per obmp_review; tutte le query del CRUD sono centralizzate qui. */
final class ObmpReviewModel extends Model
{
    protected $table = 'obmp_review';
    protected $primaryKey = 'review_id';
    protected $returnType = ObmpReviewEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'preno_id',
  2 => 'conto_id',
  3 => 'postazione_id',
  4 => 'camera_numero',
  5 => 'nome',
  6 => 'stato',
  7 => 'user_type',
  8 => 'pulizia_camera',
  9 => 'accoglienza',
  10 => 'rumore_camere',
  11 => 'spazio_camera',
  12 => 'spazi_comuni',
  13 => 'competenza_impiegati',
  14 => 'qualita_servizi',
  15 => 'dintorni',
  16 => 'colazione',
  17 => 'tariffa',
  18 => 'servizi_offerti',
  19 => 'foto',
  20 => 'indicazione_mappa',
  21 => 'giudizio_totale',
  22 => 'prezzo_qualita',
  23 => 'commento_tex',
  24 => 'risposta',
  25 => 'raccomandi',
  26 => 'ip_review',
  27 => 'data_review',
  28 => 'review_data_record',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'review_id' => 
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
  'hotel_id' => 
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
  'preno_id' => 
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
  'conto_id' => 
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
  'postazione_id' => 
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
  0 => 'review_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'conto_id',
  4 => 'postazione_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'review_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'conto_id',
  4 => 'postazione_id',
  5 => 'camera_numero',
  6 => 'nome',
  7 => 'stato',
  8 => 'user_type',
  9 => 'pulizia_camera',
  10 => 'accoglienza',
  11 => 'rumore_camere',
  12 => 'spazio_camera',
  13 => 'spazi_comuni',
  14 => 'competenza_impiegati',
  15 => 'qualita_servizi',
  16 => 'dintorni',
  17 => 'colazione',
  18 => 'tariffa',
  19 => 'servizi_offerti',
  20 => 'foto',
  21 => 'indicazione_mappa',
  22 => 'giudizio_totale',
  23 => 'prezzo_qualita',
  24 => 'commento_tex',
  25 => 'risposta',
  26 => 'raccomandi',
  27 => 'ip_review',
  28 => 'data_review',
);
    private const RELATION_SEARCHES = array (
  'conto_id' => 
  array (
    'table' => 'conti',
    'key' => 'conto_id',
    'label' => 'trattamento_sog',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_review');
        $builder->select([
            'obmp_review.review_id AS review_id',
            'obmp_review.hotel_id AS hotel_id',
            'obmp_review.preno_id AS preno_id',
            'obmp_review.conto_id AS conto_id',
            'obmp_review.postazione_id AS postazione_id',
            'obmp_review.camera_numero AS camera_numero',
            'obmp_review.nome AS nome',
            'obmp_review.stato AS stato',
            'obmp_review.user_type AS user_type',
            'obmp_review.pulizia_camera AS pulizia_camera',
            'obmp_review.accoglienza AS accoglienza',
            'obmp_review.rumore_camere AS rumore_camere',
            'obmp_review.spazio_camera AS spazio_camera',
            'obmp_review.spazi_comuni AS spazi_comuni',
            'obmp_review.competenza_impiegati AS competenza_impiegati',
            'obmp_review.qualita_servizi AS qualita_servizi',
            'obmp_review.dintorni AS dintorni',
            'obmp_review.colazione AS colazione',
            'obmp_review.tariffa AS tariffa',
            'obmp_review.servizi_offerti AS servizi_offerti',
            'obmp_review.foto AS foto',
            'obmp_review.indicazione_mappa AS indicazione_mappa',
            'obmp_review.giudizio_totale AS giudizio_totale',
            'obmp_review.prezzo_qualita AS prezzo_qualita',
            'obmp_review.commento_tex AS commento_tex',
            'obmp_review.risposta AS risposta',
            'obmp_review.raccomandi AS raccomandi',
            'obmp_review.ip_review AS ip_review',
            'obmp_review.data_review AS data_review',
            'obmp_review.review_data_record AS review_data_record',
            'conti__conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__conto_id', 'conti__conto_id.conto_id = obmp_review.conto_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_review');
        $builder->select([
            'obmp_review.review_id AS review_id',
            'obmp_review.hotel_id AS hotel_id',
            'obmp_review.preno_id AS preno_id',
            'obmp_review.conto_id AS conto_id',
            'obmp_review.postazione_id AS postazione_id',
            'obmp_review.nome AS nome',
            'obmp_review.stato AS stato',
            'obmp_review.user_type AS user_type',
            'obmp_review.prezzo_qualita AS prezzo_qualita',
            'obmp_review.data_review AS data_review',
            'conti__conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__conto_id', 'conti__conto_id.conto_id = obmp_review.conto_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('obmp_review');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('obmp_review.review_id', $id)
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
        string $sort = 'review_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'review_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('obmp_review.' . $sort, $direction)
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
        $builder = $this->db->table('obmp_review');
        $builder->select([
            'obmp_review.review_id AS review_id',
            'obmp_review.hotel_id AS hotel_id',
            'obmp_review.preno_id AS preno_id',
            'obmp_review.conto_id AS conto_id',
            'obmp_review.postazione_id AS postazione_id',
            'obmp_review.camera_numero AS camera_numero',
            'obmp_review.nome AS nome',
            'obmp_review.stato AS stato',
            'obmp_review.user_type AS user_type',
            'obmp_review.pulizia_camera AS pulizia_camera',
            'obmp_review.accoglienza AS accoglienza',
            'obmp_review.rumore_camere AS rumore_camere',
            'obmp_review.spazio_camera AS spazio_camera',
            'obmp_review.spazi_comuni AS spazi_comuni',
            'obmp_review.competenza_impiegati AS competenza_impiegati',
            'obmp_review.qualita_servizi AS qualita_servizi',
            'obmp_review.dintorni AS dintorni',
            'obmp_review.colazione AS colazione',
            'obmp_review.tariffa AS tariffa',
            'obmp_review.servizi_offerti AS servizi_offerti',
            'obmp_review.foto AS foto',
            'obmp_review.indicazione_mappa AS indicazione_mappa',
            'obmp_review.giudizio_totale AS giudizio_totale',
            'obmp_review.prezzo_qualita AS prezzo_qualita',
            'obmp_review.commento_tex AS commento_tex',
            'obmp_review.risposta AS risposta',
            'obmp_review.raccomandi AS raccomandi',
            'obmp_review.ip_review AS ip_review',
            'obmp_review.data_review AS data_review',
            'conti__conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__conto_id', 'conti__conto_id.conto_id = obmp_review.conto_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('obmp_review.review_id >', $after);
        }

        return $builder
            ->orderBy('obmp_review.review_id', 'ASC')
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

            $column = $qualified ? 'obmp_review.' . $field : $field;
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
                $builder->where('obmp_review.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'review_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'review_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('obmp_review.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione conto_id. */
    public function getContiContoIdOptions(): array
    {
        return $this->db->table('conti')
            ->select(['conto_id', 'trattamento_sog'])
            ->orderBy('trattamento_sog', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'conto_id' => $this->toOptions($this->getContiContoIdOptions(), 'conto_id', 'trattamento_sog'),
        ];
    }

    /**
     * Ricerca server-side delle opzioni per relazioni grandi.
     * Tabella, chiave e campo label arrivano solo dalla whitelist generata.
     *
     * @return list<array{id:string,text:string}>
     */
    public function searchRelationOptions(string $field, string $query, int $limit = 20): array
    {
        if (!isset(self::RELATION_SEARCHES[$field])) {
            return [];
        }

        $definition = self::RELATION_SEARCHES[$field];
        $limit = max(1, min(100, $limit));
        $builder = $this->db->table((string) $definition['table'])
            ->select([(string) $definition['key'], (string) $definition['label']])
            ->orderBy((string) $definition['label'], 'ASC')
            ->limit($limit);

        $query = trim($query);
        if ($query !== '') {
            $builder->like((string) $definition['label'], $query, 'after');
        }

        $rows = $builder->get()->getResultArray();
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => (string) ($row[(string) $definition['key']] ?? ''),
                'text' => (string) ($row[(string) $definition['label']] ?? ''),
            ];
        }

        return $result;
    }

    private function toOptions(array $rows, string $key, string $label): array
    {
        $options = [];
        foreach ($rows as $row) {
            $options[(string) $row->{$key}] = (string) $row->{$label};
        }
        return $options;
    }

    public function loadHasMany(int|string $parentId): array
    {
        $result = [];

        return $result;
    }

}
