<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ModificaContiEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per modifica_conti; tutte le query del CRUD sono centralizzate qui. */
final class ModificaContiModel extends Model
{
    protected $table = 'modifica_conti';
    protected $primaryKey = 'id_mod_conto';
    protected $returnType = ModificaContiEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'mod_conto_id',
  1 => 'mod_hotel_id',
  2 => 'mod_foglio_id',
  3 => 'mod_clienti_id',
  4 => 'mod_in_conto',
  5 => 'mod_out_preno',
  6 => 'mod_out_conto',
  7 => 'mod_preno_id',
  8 => 'mod_camera_id',
  9 => 'mod_numero_camera',
  10 => 'mod_trattamento_sog',
  11 => 'mod_tipo_camera',
  12 => 'mod_prezzo',
  13 => 'mod_nome_cliente',
  14 => 'mod_cognome_cliente',
  15 => 'mod_preno_agenzia',
  16 => 'mod_mercato',
  17 => 'mod_conti_stato_camere',
  18 => 'mod_acconto',
  19 => 'mod_data_record',
  20 => 'modifica_conti_adebiti_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'id_mod_conto' => 
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
  'mod_conto_id' => 
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
  'mod_camera_id' => 
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
  0 => 'id_mod_conto',
  1 => 'mod_conto_id',
  2 => 'mod_camera_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'id_mod_conto',
  1 => 'mod_conto_id',
  2 => 'mod_hotel_id',
  3 => 'mod_foglio_id',
  4 => 'mod_clienti_id',
  5 => 'mod_in_conto',
  6 => 'mod_out_preno',
  7 => 'mod_out_conto',
  8 => 'mod_preno_id',
  9 => 'mod_camera_id',
  10 => 'mod_numero_camera',
  11 => 'mod_trattamento_sog',
  12 => 'mod_tipo_camera',
  13 => 'mod_prezzo',
  14 => 'mod_nome_cliente',
  15 => 'mod_cognome_cliente',
  16 => 'mod_preno_agenzia',
  17 => 'mod_mercato',
  18 => 'mod_conti_stato_camere',
  19 => 'mod_acconto',
  20 => 'modifica_conti_adebiti_utente_id',
);
    private const RELATION_SEARCHES = array (
  'mod_conto_id' => 
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
        $builder = $this->db->table('modifica_conti');
        $builder->select([
            'modifica_conti.id_mod_conto AS id_mod_conto',
            'modifica_conti.mod_conto_id AS mod_conto_id',
            'modifica_conti.mod_hotel_id AS mod_hotel_id',
            'modifica_conti.mod_foglio_id AS mod_foglio_id',
            'modifica_conti.mod_clienti_id AS mod_clienti_id',
            'modifica_conti.mod_in_conto AS mod_in_conto',
            'modifica_conti.mod_out_preno AS mod_out_preno',
            'modifica_conti.mod_out_conto AS mod_out_conto',
            'modifica_conti.mod_preno_id AS mod_preno_id',
            'modifica_conti.mod_camera_id AS mod_camera_id',
            'modifica_conti.mod_numero_camera AS mod_numero_camera',
            'modifica_conti.mod_trattamento_sog AS mod_trattamento_sog',
            'modifica_conti.mod_tipo_camera AS mod_tipo_camera',
            'modifica_conti.mod_prezzo AS mod_prezzo',
            'modifica_conti.mod_nome_cliente AS mod_nome_cliente',
            'modifica_conti.mod_cognome_cliente AS mod_cognome_cliente',
            'modifica_conti.mod_preno_agenzia AS mod_preno_agenzia',
            'modifica_conti.mod_mercato AS mod_mercato',
            'modifica_conti.mod_conti_stato_camere AS mod_conti_stato_camere',
            'modifica_conti.mod_acconto AS mod_acconto',
            'modifica_conti.mod_data_record AS mod_data_record',
            'modifica_conti.modifica_conti_adebiti_utente_id AS modifica_conti_adebiti_utente_id',
            'conti__mod_conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__mod_conto_id', 'conti__mod_conto_id.conto_id = modifica_conti.mod_conto_id', 'left');
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('modifica_conti');
        $builder->select([
            'modifica_conti.id_mod_conto AS id_mod_conto',
            'modifica_conti.mod_conto_id AS mod_conto_id',
            'modifica_conti.mod_hotel_id AS mod_hotel_id',
            'modifica_conti.mod_foglio_id AS mod_foglio_id',
            'modifica_conti.mod_clienti_id AS mod_clienti_id',
            'modifica_conti.mod_in_conto AS mod_in_conto',
            'modifica_conti.mod_tipo_camera AS mod_tipo_camera',
            'modifica_conti.mod_prezzo AS mod_prezzo',
            'modifica_conti.mod_nome_cliente AS mod_nome_cliente',
            'modifica_conti.mod_conti_stato_camere AS mod_conti_stato_camere',
            'conti__mod_conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__mod_conto_id', 'conti__mod_conto_id.conto_id = modifica_conti.mod_conto_id', 'left');
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('modifica_conti');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('modifica_conti.id_mod_conto', $id)
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
        string $sort = 'id_mod_conto',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'id_mod_conto';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('modifica_conti.' . $sort, $direction)
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
        $builder = $this->db->table('modifica_conti');
        $builder->select([
            'modifica_conti.id_mod_conto AS id_mod_conto',
            'modifica_conti.mod_conto_id AS mod_conto_id',
            'modifica_conti.mod_hotel_id AS mod_hotel_id',
            'modifica_conti.mod_foglio_id AS mod_foglio_id',
            'modifica_conti.mod_clienti_id AS mod_clienti_id',
            'modifica_conti.mod_in_conto AS mod_in_conto',
            'modifica_conti.mod_out_preno AS mod_out_preno',
            'modifica_conti.mod_out_conto AS mod_out_conto',
            'modifica_conti.mod_preno_id AS mod_preno_id',
            'modifica_conti.mod_camera_id AS mod_camera_id',
            'modifica_conti.mod_numero_camera AS mod_numero_camera',
            'modifica_conti.mod_trattamento_sog AS mod_trattamento_sog',
            'modifica_conti.mod_tipo_camera AS mod_tipo_camera',
            'modifica_conti.mod_prezzo AS mod_prezzo',
            'modifica_conti.mod_nome_cliente AS mod_nome_cliente',
            'modifica_conti.mod_cognome_cliente AS mod_cognome_cliente',
            'modifica_conti.mod_preno_agenzia AS mod_preno_agenzia',
            'modifica_conti.mod_mercato AS mod_mercato',
            'modifica_conti.mod_conti_stato_camere AS mod_conti_stato_camere',
            'modifica_conti.mod_acconto AS mod_acconto',
            'modifica_conti.modifica_conti_adebiti_utente_id AS modifica_conti_adebiti_utente_id',
            'conti__mod_conto_id.trattamento_sog AS conti_trattamento_sog'
        ]);
        $builder->join('conti AS conti__mod_conto_id', 'conti__mod_conto_id.conto_id = modifica_conti.mod_conto_id', 'left');
        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('modifica_conti.id_mod_conto >', $after);
        }

        return $builder
            ->orderBy('modifica_conti.id_mod_conto', 'ASC')
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

            $column = $qualified ? 'modifica_conti.' . $field : $field;
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
                $builder->where('modifica_conti.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'id_mod_conto');
        $sort = in_array($sort, $sortable, true) ? $sort : 'id_mod_conto';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('modifica_conti.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione mod_conto_id. */
    public function getContiModContoIdOptions(): array
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
            'mod_conto_id' => $this->toOptions($this->getContiModContoIdOptions(), 'conto_id', 'trattamento_sog'),
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
