<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ClientiEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per clienti; tutte le query del CRUD sono centralizzate qui. */
final class ClientiModel extends Model
{
    protected $table = 'clienti';
    protected $primaryKey = 'clienti_id';
    protected $returnType = ClientiEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'preno_id',
  1 => 'hotel_id',
  2 => 'camera_id',
  3 => 'camera_numero',
  4 => 'camara_tipologia',
  5 => 'clienti_nome',
  6 => 'clienti_cogno',
  7 => 'cliente_nato_a',
  8 => 'cliente_nato_il',
  9 => 'cliente_nazione',
  10 => 'cliente_provincia',
  11 => 'cliente_residenza',
  12 => 'cliente_cocumento_tipo',
  13 => 'cliente_cocumento_numero',
  14 => 'cliente_cocumento_rilasciato_il',
  15 => 'cliente_sesso',
  16 => 'clienti_nome1',
  17 => 'clienti_nome2',
  18 => 'clienti_nome3',
  19 => 'clienti_nome4',
  20 => 'clienti_cogno1',
  21 => 'clienti_cogno2',
  22 => 'clienti_cogno3',
  23 => 'clienti_cogno4',
  24 => 'cliente_nato_a1',
  25 => 'cliente_nato_a2',
  26 => 'cliente_nato_a3',
  27 => 'cliente_nato_a4',
  28 => 'cliente_nato_il1',
  29 => 'cliente_nato_il2',
  30 => 'cliente_nato_il3',
  31 => 'cliente_nato_il4',
  32 => 'cliente_sesso1',
  33 => 'cliente_sesso2',
  34 => 'cliente_sesso3',
  35 => 'cliente_sesso4',
  36 => 'cliente_nazione1',
  37 => 'cliente_nazione2',
  38 => 'cliente_nazione3',
  39 => 'cliente_nazione4',
  40 => 'cliente_provincia1',
  41 => 'cliente_provincia2',
  42 => 'cliente_provincia3',
  43 => 'cliente_provincia4',
  44 => 'clienti_cc_tip',
  45 => 'clienti_cc_n',
  46 => 'clienti_cc_scad',
  47 => 'clienti_tel',
  48 => 'clienti_fax',
  49 => 'clienti_email',
  50 => 'clienti_note',
  51 => 'privacy',
  52 => 'marketing',
  53 => 'lingua',
  54 => 'password',
  55 => 'clienti_data_record',
  56 => 'clienti_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'clienti_id' => 
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
  'camera_id' => 
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
  'clienti_nome' => 
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
  'clienti_email' => 
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
  0 => 'clienti_id',
  1 => 'preno_id',
  2 => 'hotel_id',
  3 => 'camera_id',
  4 => 'clienti_nome',
  5 => 'clienti_email',
);
    private const EXPORT_FIELDS = array (
  0 => 'clienti_id',
  1 => 'preno_id',
  2 => 'hotel_id',
  3 => 'camera_id',
  4 => 'camera_numero',
  5 => 'camara_tipologia',
  6 => 'clienti_nome',
  7 => 'clienti_cogno',
  8 => 'cliente_nato_a',
  9 => 'cliente_nato_il',
  10 => 'cliente_nazione',
  11 => 'cliente_provincia',
  12 => 'cliente_residenza',
  13 => 'cliente_cocumento_tipo',
  14 => 'cliente_cocumento_numero',
  15 => 'cliente_cocumento_rilasciato_il',
  16 => 'cliente_sesso',
  17 => 'clienti_nome1',
  18 => 'clienti_nome2',
  19 => 'clienti_nome3',
  20 => 'clienti_nome4',
  21 => 'clienti_cogno1',
  22 => 'clienti_cogno2',
  23 => 'clienti_cogno3',
  24 => 'clienti_cogno4',
  25 => 'cliente_nato_a1',
  26 => 'cliente_nato_a2',
  27 => 'cliente_nato_a3',
  28 => 'cliente_nato_a4',
  29 => 'cliente_nato_il1',
  30 => 'cliente_nato_il2',
  31 => 'cliente_nato_il3',
  32 => 'cliente_nato_il4',
  33 => 'cliente_sesso1',
  34 => 'cliente_sesso2',
  35 => 'cliente_sesso3',
  36 => 'cliente_sesso4',
  37 => 'cliente_nazione1',
  38 => 'cliente_nazione2',
  39 => 'cliente_nazione3',
  40 => 'cliente_nazione4',
  41 => 'cliente_provincia1',
  42 => 'cliente_provincia2',
  43 => 'cliente_provincia3',
  44 => 'cliente_provincia4',
  45 => 'clienti_cc_tip',
  46 => 'clienti_cc_n',
  47 => 'clienti_cc_scad',
  48 => 'clienti_tel',
  49 => 'clienti_fax',
  50 => 'clienti_email',
  51 => 'clienti_note',
  52 => 'privacy',
  53 => 'marketing',
  54 => 'lingua',
  55 => 'password',
  56 => 'clienti_utente_id',
);
    private const RELATION_SEARCHES = array (
  'clienti_id' => 
  array (
    'table' => 'refer_clienti',
    'key' => 'clienti_id',
    'label' => 'conto_id',
    'mode' => 'select',
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('clienti');
        $builder->select([
            'clienti.clienti_id AS clienti_id',
            'clienti.preno_id AS preno_id',
            'clienti.hotel_id AS hotel_id',
            'clienti.camera_id AS camera_id',
            'clienti.camera_numero AS camera_numero',
            'clienti.camara_tipologia AS camara_tipologia',
            'clienti.clienti_nome AS clienti_nome',
            'clienti.clienti_cogno AS clienti_cogno',
            'clienti.cliente_nato_a AS cliente_nato_a',
            'clienti.cliente_nato_il AS cliente_nato_il',
            'clienti.cliente_nazione AS cliente_nazione',
            'clienti.cliente_provincia AS cliente_provincia',
            'clienti.cliente_residenza AS cliente_residenza',
            'clienti.cliente_cocumento_tipo AS cliente_cocumento_tipo',
            'clienti.cliente_cocumento_numero AS cliente_cocumento_numero',
            'clienti.cliente_cocumento_rilasciato_il AS cliente_cocumento_rilasciato_il',
            'clienti.cliente_sesso AS cliente_sesso',
            'clienti.clienti_nome1 AS clienti_nome1',
            'clienti.clienti_nome2 AS clienti_nome2',
            'clienti.clienti_nome3 AS clienti_nome3',
            'clienti.clienti_nome4 AS clienti_nome4',
            'clienti.clienti_cogno1 AS clienti_cogno1',
            'clienti.clienti_cogno2 AS clienti_cogno2',
            'clienti.clienti_cogno3 AS clienti_cogno3',
            'clienti.clienti_cogno4 AS clienti_cogno4',
            'clienti.cliente_nato_a1 AS cliente_nato_a1',
            'clienti.cliente_nato_a2 AS cliente_nato_a2',
            'clienti.cliente_nato_a3 AS cliente_nato_a3',
            'clienti.cliente_nato_a4 AS cliente_nato_a4',
            'clienti.cliente_nato_il1 AS cliente_nato_il1',
            'clienti.cliente_nato_il2 AS cliente_nato_il2',
            'clienti.cliente_nato_il3 AS cliente_nato_il3',
            'clienti.cliente_nato_il4 AS cliente_nato_il4',
            'clienti.cliente_sesso1 AS cliente_sesso1',
            'clienti.cliente_sesso2 AS cliente_sesso2',
            'clienti.cliente_sesso3 AS cliente_sesso3',
            'clienti.cliente_sesso4 AS cliente_sesso4',
            'clienti.cliente_nazione1 AS cliente_nazione1',
            'clienti.cliente_nazione2 AS cliente_nazione2',
            'clienti.cliente_nazione3 AS cliente_nazione3',
            'clienti.cliente_nazione4 AS cliente_nazione4',
            'clienti.cliente_provincia1 AS cliente_provincia1',
            'clienti.cliente_provincia2 AS cliente_provincia2',
            'clienti.cliente_provincia3 AS cliente_provincia3',
            'clienti.cliente_provincia4 AS cliente_provincia4',
            'clienti.clienti_cc_tip AS clienti_cc_tip',
            'clienti.clienti_cc_n AS clienti_cc_n',
            'clienti.clienti_cc_scad AS clienti_cc_scad',
            'clienti.clienti_tel AS clienti_tel',
            'clienti.clienti_fax AS clienti_fax',
            'clienti.clienti_email AS clienti_email',
            'clienti.clienti_note AS clienti_note',
            'clienti.privacy AS privacy',
            'clienti.marketing AS marketing',
            'clienti.lingua AS lingua',
            'clienti.password AS password',
            'clienti.clienti_data_record AS clienti_data_record',
            'clienti.clienti_utente_id AS clienti_utente_id',
            'refer_clienti__clienti_id.conto_id AS refer_clienti_conto_id'
        ]);
        $builder->join('refer_clienti AS refer_clienti__clienti_id', 'refer_clienti__clienti_id.clienti_id = clienti.clienti_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('clienti');
        $builder->select([
            'clienti.clienti_id AS clienti_id',
            'clienti.preno_id AS preno_id',
            'clienti.hotel_id AS hotel_id',
            'clienti.camera_id AS camera_id',
            'clienti.camera_numero AS camera_numero',
            'clienti.camara_tipologia AS camara_tipologia',
            'clienti.clienti_nome AS clienti_nome',
            'clienti.cliente_cocumento_tipo AS cliente_cocumento_tipo',
            'clienti.clienti_tel AS clienti_tel',
            'clienti.clienti_email AS clienti_email',
            'refer_clienti__clienti_id.conto_id AS refer_clienti_conto_id'
        ]);
        $builder->join('refer_clienti AS refer_clienti__clienti_id', 'refer_clienti__clienti_id.clienti_id = clienti.clienti_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('clienti');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('clienti.clienti_id', $id)
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
        string $sort = 'clienti_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'clienti_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('clienti.' . $sort, $direction)
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
        $builder = $this->db->table('clienti');
        $builder->select([
            'clienti.clienti_id AS clienti_id',
            'clienti.preno_id AS preno_id',
            'clienti.hotel_id AS hotel_id',
            'clienti.camera_id AS camera_id',
            'clienti.camera_numero AS camera_numero',
            'clienti.camara_tipologia AS camara_tipologia',
            'clienti.clienti_nome AS clienti_nome',
            'clienti.clienti_cogno AS clienti_cogno',
            'clienti.cliente_nato_a AS cliente_nato_a',
            'clienti.cliente_nato_il AS cliente_nato_il',
            'clienti.cliente_nazione AS cliente_nazione',
            'clienti.cliente_provincia AS cliente_provincia',
            'clienti.cliente_residenza AS cliente_residenza',
            'clienti.cliente_cocumento_tipo AS cliente_cocumento_tipo',
            'clienti.cliente_cocumento_numero AS cliente_cocumento_numero',
            'clienti.cliente_cocumento_rilasciato_il AS cliente_cocumento_rilasciato_il',
            'clienti.cliente_sesso AS cliente_sesso',
            'clienti.clienti_nome1 AS clienti_nome1',
            'clienti.clienti_nome2 AS clienti_nome2',
            'clienti.clienti_nome3 AS clienti_nome3',
            'clienti.clienti_nome4 AS clienti_nome4',
            'clienti.clienti_cogno1 AS clienti_cogno1',
            'clienti.clienti_cogno2 AS clienti_cogno2',
            'clienti.clienti_cogno3 AS clienti_cogno3',
            'clienti.clienti_cogno4 AS clienti_cogno4',
            'clienti.cliente_nato_a1 AS cliente_nato_a1',
            'clienti.cliente_nato_a2 AS cliente_nato_a2',
            'clienti.cliente_nato_a3 AS cliente_nato_a3',
            'clienti.cliente_nato_a4 AS cliente_nato_a4',
            'clienti.cliente_nato_il1 AS cliente_nato_il1',
            'clienti.cliente_nato_il2 AS cliente_nato_il2',
            'clienti.cliente_nato_il3 AS cliente_nato_il3',
            'clienti.cliente_nato_il4 AS cliente_nato_il4',
            'clienti.cliente_sesso1 AS cliente_sesso1',
            'clienti.cliente_sesso2 AS cliente_sesso2',
            'clienti.cliente_sesso3 AS cliente_sesso3',
            'clienti.cliente_sesso4 AS cliente_sesso4',
            'clienti.cliente_nazione1 AS cliente_nazione1',
            'clienti.cliente_nazione2 AS cliente_nazione2',
            'clienti.cliente_nazione3 AS cliente_nazione3',
            'clienti.cliente_nazione4 AS cliente_nazione4',
            'clienti.cliente_provincia1 AS cliente_provincia1',
            'clienti.cliente_provincia2 AS cliente_provincia2',
            'clienti.cliente_provincia3 AS cliente_provincia3',
            'clienti.cliente_provincia4 AS cliente_provincia4',
            'clienti.clienti_cc_tip AS clienti_cc_tip',
            'clienti.clienti_cc_n AS clienti_cc_n',
            'clienti.clienti_cc_scad AS clienti_cc_scad',
            'clienti.clienti_tel AS clienti_tel',
            'clienti.clienti_fax AS clienti_fax',
            'clienti.clienti_email AS clienti_email',
            'clienti.clienti_note AS clienti_note',
            'clienti.privacy AS privacy',
            'clienti.marketing AS marketing',
            'clienti.lingua AS lingua',
            'clienti.password AS password',
            'clienti.clienti_utente_id AS clienti_utente_id',
            'refer_clienti__clienti_id.conto_id AS refer_clienti_conto_id'
        ]);
        $builder->join('refer_clienti AS refer_clienti__clienti_id', 'refer_clienti__clienti_id.clienti_id = clienti.clienti_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('clienti.clienti_id >', $after);
        }

        return $builder
            ->orderBy('clienti.clienti_id', 'ASC')
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

            $column = $qualified ? 'clienti.' . $field : $field;
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
                $builder->where('clienti.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'clienti_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'clienti_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('clienti.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione clienti_id. */
    public function getReferClientiClientiIdOptions(): array
    {
        return $this->db->table('refer_clienti')
            ->select(['clienti_id', 'conto_id'])
            ->orderBy('conto_id', 'ASC')
            ->get()
            ->getResult();
    }
    public function relationOptions(): array
    {
        return [
            'clienti_id' => $this->toOptions($this->getReferClientiClientiIdOptions(), 'clienti_id', 'conto_id'),
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
    public function getPuntiSpesiByClienteId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('punti_spesi')
            ->where('cliente_id', $parentId)
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
    public function loadHasMany(int|string $parentId): array
    {
        $result = [];
        $result['punti_spesi__cliente_id'] = $this->getPuntiSpesiByClienteId($parentId, 20);
        return $result;
    }

}
