<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ContiEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per conti; tutte le query del CRUD sono centralizzate qui. */
final class ContiModel extends Model
{
    protected $table = 'conti';
    protected $primaryKey = 'conto_id';
    protected $returnType = ContiEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'foglio_id',
  2 => 'clienti_id',
  3 => 'in_conto',
  4 => 'in_conto_time',
  5 => 'out_preno',
  6 => 'out_conto',
  7 => 'preno_id',
  8 => 'camera_id',
  9 => 'numero_camera',
  10 => 'trattamento_sog',
  11 => 'tipo_camera',
  12 => 'tipologia_id',
  13 => 'prezzo',
  14 => 'nome_cliente',
  15 => 'cognome_cliente',
  16 => 'preno_agenzia',
  17 => 'mercato',
  18 => 'conti_stato_camere',
  19 => 'acconto',
  20 => 'conto_pag_modalita',
  21 => 'data_record',
  22 => 'conti_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
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
  'hotel_id' => 
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
  'foglio_id' => 
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
  'in_conto' => 
  array (
    'type' => 'date',
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
  'out_preno' => 
  array (
    'type' => 'date',
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
  'out_conto' => 
  array (
    'type' => 'date',
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
  'camera_id' => 
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
  'tipologia_id' => 
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
  'conti_stato_camere' => 
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
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'foglio_id',
  3 => 'in_conto',
  4 => 'out_preno',
  5 => 'out_conto',
  6 => 'preno_id',
  7 => 'camera_id',
  8 => 'tipologia_id',
  9 => 'conti_stato_camere',
);
    private const EXPORT_FIELDS = array (
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'foglio_id',
  3 => 'clienti_id',
  4 => 'in_conto',
  5 => 'in_conto_time',
  6 => 'out_preno',
  7 => 'out_conto',
  8 => 'preno_id',
  9 => 'camera_id',
  10 => 'numero_camera',
  11 => 'trattamento_sog',
  12 => 'tipo_camera',
  13 => 'tipologia_id',
  14 => 'prezzo',
  15 => 'nome_cliente',
  16 => 'cognome_cliente',
  17 => 'preno_agenzia',
  18 => 'mercato',
  19 => 'conti_stato_camere',
  20 => 'acconto',
  21 => 'conto_pag_modalita',
  22 => 'conti_utente_id',
);
    private const RELATION_SEARCHES = array (
  'camera_id' => 
  array (
    'table' => 'camere',
    'key' => 'camera_id',
    'label' => 'tipologia_camera',
    'mode' => 'select',
  ),
  'foglio_id' => 
  array (
    'table' => 'foglio_giorno',
    'key' => 'foglio_id',
    'label' => 'date_foglio',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('conti');
        $builder->select([
            'conti.conto_id AS conto_id',
            'conti.hotel_id AS hotel_id',
            'conti.foglio_id AS foglio_id',
            'conti.clienti_id AS clienti_id',
            'conti.in_conto AS in_conto',
            'conti.in_conto_time AS in_conto_time',
            'conti.out_preno AS out_preno',
            'conti.out_conto AS out_conto',
            'conti.preno_id AS preno_id',
            'conti.camera_id AS camera_id',
            'conti.numero_camera AS numero_camera',
            'conti.trattamento_sog AS trattamento_sog',
            'conti.tipo_camera AS tipo_camera',
            'conti.tipologia_id AS tipologia_id',
            'conti.prezzo AS prezzo',
            'conti.nome_cliente AS nome_cliente',
            'conti.cognome_cliente AS cognome_cliente',
            'conti.preno_agenzia AS preno_agenzia',
            'conti.mercato AS mercato',
            'conti.conti_stato_camere AS conti_stato_camere',
            'conti.acconto AS acconto',
            'conti.conto_pag_modalita AS conto_pag_modalita',
            'conti.data_record AS data_record',
            'conti.conti_utente_id AS conti_utente_id',
            'camere__camera_id.tipologia_camera AS camere_tipologia_camera',
            'foglio_giorno__foglio_id.date_foglio AS foglio_giorno_date_foglio'
        ]);
        $builder->join('camere AS camere__camera_id', 'camere__camera_id.camera_id = conti.camera_id', 'left');
        $builder->join('foglio_giorno AS foglio_giorno__foglio_id', 'foglio_giorno__foglio_id.foglio_id = conti.foglio_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('conti');
        $builder->select([
            'conti.conto_id AS conto_id',
            'conti.hotel_id AS hotel_id',
            'conti.foglio_id AS foglio_id',
            'conti.clienti_id AS clienti_id',
            'conti.in_conto AS in_conto',
            'conti.camera_id AS camera_id',
            'conti.tipo_camera AS tipo_camera',
            'conti.prezzo AS prezzo',
            'conti.nome_cliente AS nome_cliente',
            'conti.conti_stato_camere AS conti_stato_camere',
            'camere__camera_id.tipologia_camera AS camere_tipologia_camera',
            'foglio_giorno__foglio_id.date_foglio AS foglio_giorno_date_foglio'
        ]);
        $builder->join('camere AS camere__camera_id', 'camere__camera_id.camera_id = conti.camera_id', 'left');
        $builder->join('foglio_giorno AS foglio_giorno__foglio_id', 'foglio_giorno__foglio_id.foglio_id = conti.foglio_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('conti');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('conti.conto_id', $id)
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
        string $sort = 'conto_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'conto_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('conti.' . $sort, $direction)
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
        $builder = $this->db->table('conti');
        $builder->select([
            'conti.conto_id AS conto_id',
            'conti.hotel_id AS hotel_id',
            'conti.foglio_id AS foglio_id',
            'conti.clienti_id AS clienti_id',
            'conti.in_conto AS in_conto',
            'conti.in_conto_time AS in_conto_time',
            'conti.out_preno AS out_preno',
            'conti.out_conto AS out_conto',
            'conti.preno_id AS preno_id',
            'conti.camera_id AS camera_id',
            'conti.numero_camera AS numero_camera',
            'conti.trattamento_sog AS trattamento_sog',
            'conti.tipo_camera AS tipo_camera',
            'conti.tipologia_id AS tipologia_id',
            'conti.prezzo AS prezzo',
            'conti.nome_cliente AS nome_cliente',
            'conti.cognome_cliente AS cognome_cliente',
            'conti.preno_agenzia AS preno_agenzia',
            'conti.mercato AS mercato',
            'conti.conti_stato_camere AS conti_stato_camere',
            'conti.acconto AS acconto',
            'conti.conto_pag_modalita AS conto_pag_modalita',
            'conti.conti_utente_id AS conti_utente_id',
            'camere__camera_id.tipologia_camera AS camere_tipologia_camera',
            'foglio_giorno__foglio_id.date_foglio AS foglio_giorno_date_foglio'
        ]);
        $builder->join('camere AS camere__camera_id', 'camere__camera_id.camera_id = conti.camera_id', 'left');
        $builder->join('foglio_giorno AS foglio_giorno__foglio_id', 'foglio_giorno__foglio_id.foglio_id = conti.foglio_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('conti.conto_id >', $after);
        }

        return $builder
            ->orderBy('conti.conto_id', 'ASC')
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

            $column = $qualified ? 'conti.' . $field : $field;
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
                $builder->where('conti.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'conto_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'conto_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('conti.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione camera_id. */
    public function getCamereCameraIdOptions(): array
    {
        return $this->db->table('camere')
            ->select(['camera_id', 'tipologia_camera'])
            ->orderBy('tipologia_camera', 'ASC')
            ->get()
            ->getResult();
    }
    /** Restituisce le opzioni della relazione foglio_id. */
    public function getFoglioGiornoFoglioIdOptions(): array
    {
        return $this->db->table('foglio_giorno')
            ->select(['foglio_id', 'date_foglio'])
            ->orderBy('date_foglio', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'camera_id' => $this->toOptions($this->getCamereCameraIdOptions(), 'camera_id', 'tipologia_camera'),
            'foglio_id' => $this->toOptions($this->getFoglioGiornoFoglioIdOptions(), 'foglio_id', 'date_foglio'),
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

    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getContiNoteByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('conti_note')
            ->where('conto_id', $parentId)
            ->orderBy('conto_nota_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getModificaContiByModContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('modifica_conti')
            ->where('mod_conto_id', $parentId)
            ->orderBy('id_mod_conto', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getObmpReviewByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('obmp_review')
            ->where('conto_id', $parentId)
            ->orderBy('review_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getPuliziaByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('pulizia')
            ->where('conto_id', $parentId)
            ->orderBy('pulizia_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getPuntiSpesiByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('punti_spesi')
            ->where('conto_id', $parentId)
            ->orderBy('punti_spesi_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getReferClientiByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('refer_clienti')
            ->where('conto_id', $parentId)
            ->orderBy('conto_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getSidaeByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('sidae')
            ->where('conto_id', $parentId)
            ->orderBy('sidae_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getTaxPagamentoByContoId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('tax_pagamento')
            ->where('conto_id', $parentId)
            ->orderBy('tax_pagamento_id', 'DESC')
            ->limit($limit + 1)
            ->get()
            ->getResult();
        $hasMore = count($rows) > $limit;
        if ($hasMore) {
            array_pop($rows);
        }

        return [
            'rows' => $rows,
            'count' => count($rows),
            'hasMore' => $hasMore,
        ];
    }
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['conti_note__conto_id'] = $this->getContiNoteByContoId($parentId, 20);

        $result['modifica_conti__mod_conto_id'] = $this->getModificaContiByModContoId($parentId, 20);

        $result['obmp_review__conto_id'] = $this->getObmpReviewByContoId($parentId, 20);

        $result['pulizia__conto_id'] = $this->getPuliziaByContoId($parentId, 20);

        $result['punti_spesi__conto_id'] = $this->getPuntiSpesiByContoId($parentId, 20);

        $result['refer_clienti__conto_id'] = $this->getReferClientiByContoId($parentId, 20);

        $result['sidae__conto_id'] = $this->getSidaeByContoId($parentId, 20);

        $result['tax_pagamento__conto_id'] = $this->getTaxPagamentoByContoId($parentId, 20);
        return $result;
    }

}
