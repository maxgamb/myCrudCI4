<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\FoglioGiornoEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per foglio_giorno; tutte le query del CRUD sono centralizzate qui. */
final class FoglioGiornoModel extends Model
{
    protected $table = 'foglio_giorno';
    protected $primaryKey = 'foglio_id';
    protected $returnType = FoglioGiornoEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'hotel_id',
  1 => 'conto_id',
  2 => 'camera_id',
  3 => 'preno_id',
  4 => 'tipologia_id',
  5 => 'numero_camera',
  6 => 'foglio_prezzo_camera',
  7 => 'date_foglio',
  8 => 'nome_cliente',
  9 => 'cognome_cliente',
  10 => 'in_conto',
  11 => 'out_preno',
  12 => 'stato_camera',
  13 => 'preno_agenzia',
  14 => 'foglio_data_record',
  15 => 'foglio_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
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
  'foglio_prezzo_camera' => 
  array (
    'type' => 'decimal',
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
  'date_foglio' => 
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
  'stato_camera' => 
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
  'preno_agenzia' => 
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
  0 => 'foglio_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'preno_id',
  5 => 'tipologia_id',
  6 => 'foglio_prezzo_camera',
  7 => 'date_foglio',
  8 => 'in_conto',
  9 => 'out_preno',
  10 => 'stato_camera',
  11 => 'preno_agenzia',
);
    private const EXPORT_FIELDS = array (
  0 => 'foglio_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'preno_id',
  5 => 'tipologia_id',
  6 => 'numero_camera',
  7 => 'foglio_prezzo_camera',
  8 => 'date_foglio',
  9 => 'nome_cliente',
  10 => 'cognome_cliente',
  11 => 'in_conto',
  12 => 'out_preno',
  13 => 'stato_camera',
  14 => 'preno_agenzia',
  15 => 'foglio_utente_id',
);
    private const RELATION_SEARCHES = array (
  'preno_id' => 
  array (
    'table' => 'agenda',
    'key' => 'preno_id',
    'label' => 'preno_arr_ore',
    'mode' => 'select',
  ),
  'preno_agenzia' => 
  array (
    'table' => 'agenzie',
    'key' => 'agenzia_id',
    'label' => 'agenzia_tipologia',
    'mode' => 'select',
  ),
  'camera_id' => 
  array (
    'table' => 'camere',
    'key' => 'camera_id',
    'label' => 'tipologia_camera',
    'mode' => 'select',
  ),
  'tipologia_id' => 
  array (
    'table' => 'tipologia_camera',
    'key' => 'tipologia_id',
    'label' => 'nome_tipologia',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('foglio_giorno');
        $builder->select([
            'foglio_giorno.foglio_id AS foglio_id',
            'foglio_giorno.hotel_id AS hotel_id',
            'foglio_giorno.conto_id AS conto_id',
            'foglio_giorno.camera_id AS camera_id',
            'foglio_giorno.preno_id AS preno_id',
            'foglio_giorno.tipologia_id AS tipologia_id',
            'foglio_giorno.numero_camera AS numero_camera',
            'foglio_giorno.foglio_prezzo_camera AS foglio_prezzo_camera',
            'foglio_giorno.date_foglio AS date_foglio',
            'foglio_giorno.nome_cliente AS nome_cliente',
            'foglio_giorno.cognome_cliente AS cognome_cliente',
            'foglio_giorno.in_conto AS in_conto',
            'foglio_giorno.out_preno AS out_preno',
            'foglio_giorno.stato_camera AS stato_camera',
            'foglio_giorno.preno_agenzia AS preno_agenzia',
            'foglio_giorno.foglio_data_record AS foglio_data_record',
            'foglio_giorno.foglio_utente_id AS foglio_utente_id',
            'agenda__preno_id.preno_arr_ore AS agenda_preno_arr_ore',
            'agenzie__preno_agenzia.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'camere__camera_id.tipologia_camera AS camere_tipologia_camera',
            'tipologia_camera__tipologia_id.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = foglio_giorno.preno_id', 'left');
        $builder->join('agenzie AS agenzie__preno_agenzia', 'agenzie__preno_agenzia.agenzia_id = foglio_giorno.preno_agenzia', 'left');
        $builder->join('camere AS camere__camera_id', 'camere__camera_id.camera_id = foglio_giorno.camera_id', 'left');
        $builder->join('tipologia_camera AS tipologia_camera__tipologia_id', 'tipologia_camera__tipologia_id.tipologia_id = foglio_giorno.tipologia_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('foglio_giorno');
        $builder->select([
            'foglio_giorno.foglio_id AS foglio_id',
            'foglio_giorno.hotel_id AS hotel_id',
            'foglio_giorno.camera_id AS camera_id',
            'foglio_giorno.preno_id AS preno_id',
            'foglio_giorno.tipologia_id AS tipologia_id',
            'foglio_giorno.foglio_prezzo_camera AS foglio_prezzo_camera',
            'foglio_giorno.date_foglio AS date_foglio',
            'foglio_giorno.nome_cliente AS nome_cliente',
            'foglio_giorno.stato_camera AS stato_camera',
            'foglio_giorno.preno_agenzia AS preno_agenzia',
            'agenda__preno_id.preno_arr_ore AS agenda_preno_arr_ore',
            'agenzie__preno_agenzia.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'camere__camera_id.tipologia_camera AS camere_tipologia_camera',
            'tipologia_camera__tipologia_id.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = foglio_giorno.preno_id', 'left');
        $builder->join('agenzie AS agenzie__preno_agenzia', 'agenzie__preno_agenzia.agenzia_id = foglio_giorno.preno_agenzia', 'left');
        $builder->join('camere AS camere__camera_id', 'camere__camera_id.camera_id = foglio_giorno.camera_id', 'left');
        $builder->join('tipologia_camera AS tipologia_camera__tipologia_id', 'tipologia_camera__tipologia_id.tipologia_id = foglio_giorno.tipologia_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('foglio_giorno');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('foglio_giorno.foglio_id', $id)
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
        string $sort = 'foglio_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'foglio_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('foglio_giorno.' . $sort, $direction)
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
        $builder = $this->db->table('foglio_giorno');
        $builder->select([
            'foglio_giorno.foglio_id AS foglio_id',
            'foglio_giorno.hotel_id AS hotel_id',
            'foglio_giorno.conto_id AS conto_id',
            'foglio_giorno.camera_id AS camera_id',
            'foglio_giorno.preno_id AS preno_id',
            'foglio_giorno.tipologia_id AS tipologia_id',
            'foglio_giorno.numero_camera AS numero_camera',
            'foglio_giorno.foglio_prezzo_camera AS foglio_prezzo_camera',
            'foglio_giorno.date_foglio AS date_foglio',
            'foglio_giorno.nome_cliente AS nome_cliente',
            'foglio_giorno.cognome_cliente AS cognome_cliente',
            'foglio_giorno.in_conto AS in_conto',
            'foglio_giorno.out_preno AS out_preno',
            'foglio_giorno.stato_camera AS stato_camera',
            'foglio_giorno.preno_agenzia AS preno_agenzia',
            'foglio_giorno.foglio_utente_id AS foglio_utente_id',
            'agenda__preno_id.preno_arr_ore AS agenda_preno_arr_ore',
            'agenzie__preno_agenzia.agenzia_tipologia AS agenzie_agenzia_tipologia',
            'camere__camera_id.tipologia_camera AS camere_tipologia_camera',
            'tipologia_camera__tipologia_id.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);
        $builder->join('agenda AS agenda__preno_id', 'agenda__preno_id.preno_id = foglio_giorno.preno_id', 'left');
        $builder->join('agenzie AS agenzie__preno_agenzia', 'agenzie__preno_agenzia.agenzia_id = foglio_giorno.preno_agenzia', 'left');
        $builder->join('camere AS camere__camera_id', 'camere__camera_id.camera_id = foglio_giorno.camera_id', 'left');
        $builder->join('tipologia_camera AS tipologia_camera__tipologia_id', 'tipologia_camera__tipologia_id.tipologia_id = foglio_giorno.tipologia_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('foglio_giorno.foglio_id >', $after);
        }

        return $builder
            ->orderBy('foglio_giorno.foglio_id', 'ASC')
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

            $column = $qualified ? 'foglio_giorno.' . $field : $field;
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
                $builder->where('foglio_giorno.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'foglio_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'foglio_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('foglio_giorno.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione preno_id. */
    public function getAgendaPrenoIdOptions(): array
    {
        return $this->db->table('agenda')
            ->select(['preno_id', 'preno_arr_ore'])
            ->orderBy('preno_arr_ore', 'ASC')
            ->get()
            ->getResult();
    }
    /** Restituisce le opzioni della relazione preno_agenzia. */
    public function getAgenziePrenoAgenziaOptions(): array
    {
        return $this->db->table('agenzie')
            ->select(['agenzia_id', 'agenzia_tipologia'])
            ->orderBy('agenzia_tipologia', 'ASC')
            ->get()
            ->getResult();
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
    /** Restituisce le opzioni della relazione tipologia_id. */
    public function getTipologiaCameraTipologiaIdOptions(): array
    {
        return $this->db->table('tipologia_camera')
            ->select(['tipologia_id', 'nome_tipologia'])
            ->orderBy('nome_tipologia', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'preno_id' => $this->toOptions($this->getAgendaPrenoIdOptions(), 'preno_id', 'preno_arr_ore'),
            'preno_agenzia' => $this->toOptions($this->getAgenziePrenoAgenziaOptions(), 'agenzia_id', 'agenzia_tipologia'),
            'camera_id' => $this->toOptions($this->getCamereCameraIdOptions(), 'camera_id', 'tipologia_camera'),
            'tipologia_id' => $this->toOptions($this->getTipologiaCameraTipologiaIdOptions(), 'tipologia_id', 'nome_tipologia'),
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
    public function getContiByFoglioId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('conti')
            ->where('foglio_id', $parentId)
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
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['conti__foglio_id'] = $this->getContiByFoglioId($parentId, 20);
        return $result;
    }

}
