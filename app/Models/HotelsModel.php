<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\HotelsEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per hotels; tutte le query del CRUD sono centralizzate qui. */
final class HotelsModel extends Model
{
    protected $table = 'hotels';
    protected $primaryKey = 'hotel_id';
    protected $returnType = HotelsEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'nome_hotel',
  1 => 'hotel_tipologia',
  2 => 'hotel_categoria',
  3 => 'hotel_citta',
  4 => 'hotel_via',
  5 => 'hotel_tel',
  6 => 'hotel_fax',
  7 => 'hotel_email',
  8 => 'hotel_stato',
  9 => 'hotel_cap',
  10 => 'hotel_piva',
  11 => 'hotel_numero_camere',
  12 => 'hotel_data_record',
  13 => 'hotels_utente_id',
  14 => 'hotel_web',
  15 => 'hotel_logo',
  16 => 'hotel_mappa',
  17 => 'hotel_reach_by_car',
  18 => 'hotel_reach_by_treno',
  19 => 'hotel_reach_aereo',
  20 => 'hotel_reach_nave',
  21 => 'hotel_foto_piccola',
  22 => 'hotel_foto_grande',
  23 => 'hotel_testo_en',
  24 => 'hotel_testo_it',
  25 => 'hotel_disp_modo',
  26 => 'hotel_limite_vendite_web',
  27 => 'hotel_limite_vendite_xml',
  28 => 'hotel_incremento_prezzo_xml',
  29 => 'hotel_booking_attivazione',
  30 => 'hotel_booking_url',
  31 => 'hotel_booking_agenzia',
  32 => 'hotel_tarif_cambia_gg',
  33 => 'hotel_tarif_listino_nome_id',
  34 => 'hotel_agenzia_attivazione',
  35 => 'hotel_type_booking',
  36 => 'hotel_check_in',
  37 => 'hotel_check_out',
  38 => 'hotel_serv_inclusi',
  39 => 'hotel_cancel_pol',
  40 => 'facebook',
  41 => 'google',
  42 => 'instagram',
  43 => 'twitter',
  44 => 'linkedin',
  45 => 'analytics',
  46 => 'email_desk',
  47 => 'tripadvisor',
  48 => 'trip_rec_url',
  49 => 'pec',
  50 => 'sdi',
  51 => 'ae_user',
  52 => 'ae_password',
  53 => 'ae_pin',
  54 => 'ae_codice_fiscale',
  55 => 'sa_nome',
  56 => 'sa_chiave',
  57 => 'ae_test',
  58 => 'citytax',
  59 => 'wifi_network',
  60 => 'wifi_password',
  61 => 'chek_email',
  62 => 'chek_tel',
  63 => 'nexi_alias',
  64 => 'nexi_key',
  65 => 'nexi_url',
  66 => 'cir_bdsr',
  67 => 'cin_bdsr',
  68 => 'catastale_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'hotel_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'hotel_id',
  1 => 'nome_hotel',
  2 => 'hotel_tipologia',
  3 => 'hotel_categoria',
  4 => 'hotel_citta',
  5 => 'hotel_via',
  6 => 'hotel_tel',
  7 => 'hotel_fax',
  8 => 'hotel_email',
  9 => 'hotel_stato',
  10 => 'hotel_cap',
  11 => 'hotel_piva',
  12 => 'hotel_numero_camere',
  13 => 'hotels_utente_id',
  14 => 'hotel_web',
  15 => 'hotel_logo',
  16 => 'hotel_mappa',
  17 => 'hotel_reach_by_car',
  18 => 'hotel_reach_by_treno',
  19 => 'hotel_reach_aereo',
  20 => 'hotel_reach_nave',
  21 => 'hotel_foto_piccola',
  22 => 'hotel_foto_grande',
  23 => 'hotel_testo_en',
  24 => 'hotel_testo_it',
  25 => 'hotel_disp_modo',
  26 => 'hotel_limite_vendite_web',
  27 => 'hotel_limite_vendite_xml',
  28 => 'hotel_incremento_prezzo_xml',
  29 => 'hotel_booking_attivazione',
  30 => 'hotel_booking_url',
  31 => 'hotel_booking_agenzia',
  32 => 'hotel_tarif_cambia_gg',
  33 => 'hotel_tarif_listino_nome_id',
  34 => 'hotel_agenzia_attivazione',
  35 => 'hotel_type_booking',
  36 => 'hotel_check_in',
  37 => 'hotel_check_out',
  38 => 'hotel_serv_inclusi',
  39 => 'hotel_cancel_pol',
  40 => 'facebook',
  41 => 'google',
  42 => 'instagram',
  43 => 'twitter',
  44 => 'linkedin',
  45 => 'analytics',
  46 => 'email_desk',
  47 => 'tripadvisor',
  48 => 'trip_rec_url',
  49 => 'pec',
  50 => 'sdi',
  51 => 'ae_user',
  52 => 'ae_password',
  53 => 'ae_pin',
  54 => 'ae_codice_fiscale',
  55 => 'sa_nome',
  56 => 'sa_chiave',
  57 => 'ae_test',
  58 => 'citytax',
  59 => 'wifi_network',
  60 => 'wifi_password',
  61 => 'chek_email',
  62 => 'chek_tel',
  63 => 'nexi_alias',
  64 => 'nexi_key',
  65 => 'nexi_url',
  66 => 'cir_bdsr',
  67 => 'cin_bdsr',
  68 => 'catastale_id',
);
    private const RELATION_SEARCHES = array (
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('hotels');
        $builder->select([
            'hotels.hotel_id AS hotel_id',
            'hotels.nome_hotel AS nome_hotel',
            'hotels.hotel_tipologia AS hotel_tipologia',
            'hotels.hotel_categoria AS hotel_categoria',
            'hotels.hotel_citta AS hotel_citta',
            'hotels.hotel_via AS hotel_via',
            'hotels.hotel_tel AS hotel_tel',
            'hotels.hotel_fax AS hotel_fax',
            'hotels.hotel_email AS hotel_email',
            'hotels.hotel_stato AS hotel_stato',
            'hotels.hotel_cap AS hotel_cap',
            'hotels.hotel_piva AS hotel_piva',
            'hotels.hotel_numero_camere AS hotel_numero_camere',
            'hotels.hotel_data_record AS hotel_data_record',
            'hotels.hotels_utente_id AS hotels_utente_id',
            'hotels.hotel_web AS hotel_web',
            'hotels.hotel_logo AS hotel_logo',
            'hotels.hotel_mappa AS hotel_mappa',
            'hotels.hotel_reach_by_car AS hotel_reach_by_car',
            'hotels.hotel_reach_by_treno AS hotel_reach_by_treno',
            'hotels.hotel_reach_aereo AS hotel_reach_aereo',
            'hotels.hotel_reach_nave AS hotel_reach_nave',
            'hotels.hotel_foto_piccola AS hotel_foto_piccola',
            'hotels.hotel_foto_grande AS hotel_foto_grande',
            'hotels.hotel_testo_en AS hotel_testo_en',
            'hotels.hotel_testo_it AS hotel_testo_it',
            'hotels.hotel_disp_modo AS hotel_disp_modo',
            'hotels.hotel_limite_vendite_web AS hotel_limite_vendite_web',
            'hotels.hotel_limite_vendite_xml AS hotel_limite_vendite_xml',
            'hotels.hotel_incremento_prezzo_xml AS hotel_incremento_prezzo_xml',
            'hotels.hotel_booking_attivazione AS hotel_booking_attivazione',
            'hotels.hotel_booking_url AS hotel_booking_url',
            'hotels.hotel_booking_agenzia AS hotel_booking_agenzia',
            'hotels.hotel_tarif_cambia_gg AS hotel_tarif_cambia_gg',
            'hotels.hotel_tarif_listino_nome_id AS hotel_tarif_listino_nome_id',
            'hotels.hotel_agenzia_attivazione AS hotel_agenzia_attivazione',
            'hotels.hotel_type_booking AS hotel_type_booking',
            'hotels.hotel_check_in AS hotel_check_in',
            'hotels.hotel_check_out AS hotel_check_out',
            'hotels.hotel_serv_inclusi AS hotel_serv_inclusi',
            'hotels.hotel_cancel_pol AS hotel_cancel_pol',
            'hotels.facebook AS facebook',
            'hotels.google AS google',
            'hotels.instagram AS instagram',
            'hotels.twitter AS twitter',
            'hotels.linkedin AS linkedin',
            'hotels.analytics AS analytics',
            'hotels.email_desk AS email_desk',
            'hotels.tripadvisor AS tripadvisor',
            'hotels.trip_rec_url AS trip_rec_url',
            'hotels.pec AS pec',
            'hotels.sdi AS sdi',
            'hotels.ae_user AS ae_user',
            'hotels.ae_password AS ae_password',
            'hotels.ae_pin AS ae_pin',
            'hotels.ae_codice_fiscale AS ae_codice_fiscale',
            'hotels.sa_nome AS sa_nome',
            'hotels.sa_chiave AS sa_chiave',
            'hotels.ae_test AS ae_test',
            'hotels.citytax AS citytax',
            'hotels.wifi_network AS wifi_network',
            'hotels.wifi_password AS wifi_password',
            'hotels.chek_email AS chek_email',
            'hotels.chek_tel AS chek_tel',
            'hotels.nexi_alias AS nexi_alias',
            'hotels.nexi_key AS nexi_key',
            'hotels.nexi_url AS nexi_url',
            'hotels.cir_bdsr AS cir_bdsr',
            'hotels.cin_bdsr AS cin_bdsr',
            'hotels.catastale_id AS catastale_id'
        ]);

        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('hotels');
        $builder->select([
            'hotels.hotel_id AS hotel_id',
            'hotels.nome_hotel AS nome_hotel',
            'hotels.hotel_tel AS hotel_tel',
            'hotels.hotel_email AS hotel_email',
            'hotels.hotel_stato AS hotel_stato',
            'hotels.hotel_incremento_prezzo_xml AS hotel_incremento_prezzo_xml',
            'hotels.hotel_tarif_listino_nome_id AS hotel_tarif_listino_nome_id',
            'hotels.hotel_type_booking AS hotel_type_booking',
            'hotels.email_desk AS email_desk',
            'hotels.ae_codice_fiscale AS ae_codice_fiscale'
        ]);

        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('hotels');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('hotels.hotel_id', $id)
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
        string $sort = 'hotel_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'hotel_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('hotels.' . $sort, $direction)
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
        $builder = $this->db->table('hotels');
        $builder->select([
            'hotels.hotel_id AS hotel_id',
            'hotels.nome_hotel AS nome_hotel',
            'hotels.hotel_tipologia AS hotel_tipologia',
            'hotels.hotel_categoria AS hotel_categoria',
            'hotels.hotel_citta AS hotel_citta',
            'hotels.hotel_via AS hotel_via',
            'hotels.hotel_tel AS hotel_tel',
            'hotels.hotel_fax AS hotel_fax',
            'hotels.hotel_email AS hotel_email',
            'hotels.hotel_stato AS hotel_stato',
            'hotels.hotel_cap AS hotel_cap',
            'hotels.hotel_piva AS hotel_piva',
            'hotels.hotel_numero_camere AS hotel_numero_camere',
            'hotels.hotels_utente_id AS hotels_utente_id',
            'hotels.hotel_web AS hotel_web',
            'hotels.hotel_logo AS hotel_logo',
            'hotels.hotel_mappa AS hotel_mappa',
            'hotels.hotel_reach_by_car AS hotel_reach_by_car',
            'hotels.hotel_reach_by_treno AS hotel_reach_by_treno',
            'hotels.hotel_reach_aereo AS hotel_reach_aereo',
            'hotels.hotel_reach_nave AS hotel_reach_nave',
            'hotels.hotel_foto_piccola AS hotel_foto_piccola',
            'hotels.hotel_foto_grande AS hotel_foto_grande',
            'hotels.hotel_testo_en AS hotel_testo_en',
            'hotels.hotel_testo_it AS hotel_testo_it',
            'hotels.hotel_disp_modo AS hotel_disp_modo',
            'hotels.hotel_limite_vendite_web AS hotel_limite_vendite_web',
            'hotels.hotel_limite_vendite_xml AS hotel_limite_vendite_xml',
            'hotels.hotel_incremento_prezzo_xml AS hotel_incremento_prezzo_xml',
            'hotels.hotel_booking_attivazione AS hotel_booking_attivazione',
            'hotels.hotel_booking_url AS hotel_booking_url',
            'hotels.hotel_booking_agenzia AS hotel_booking_agenzia',
            'hotels.hotel_tarif_cambia_gg AS hotel_tarif_cambia_gg',
            'hotels.hotel_tarif_listino_nome_id AS hotel_tarif_listino_nome_id',
            'hotels.hotel_agenzia_attivazione AS hotel_agenzia_attivazione',
            'hotels.hotel_type_booking AS hotel_type_booking',
            'hotels.hotel_check_in AS hotel_check_in',
            'hotels.hotel_check_out AS hotel_check_out',
            'hotels.hotel_serv_inclusi AS hotel_serv_inclusi',
            'hotels.hotel_cancel_pol AS hotel_cancel_pol',
            'hotels.facebook AS facebook',
            'hotels.google AS google',
            'hotels.instagram AS instagram',
            'hotels.twitter AS twitter',
            'hotels.linkedin AS linkedin',
            'hotels.analytics AS analytics',
            'hotels.email_desk AS email_desk',
            'hotels.tripadvisor AS tripadvisor',
            'hotels.trip_rec_url AS trip_rec_url',
            'hotels.pec AS pec',
            'hotels.sdi AS sdi',
            'hotels.ae_user AS ae_user',
            'hotels.ae_password AS ae_password',
            'hotels.ae_pin AS ae_pin',
            'hotels.ae_codice_fiscale AS ae_codice_fiscale',
            'hotels.sa_nome AS sa_nome',
            'hotels.sa_chiave AS sa_chiave',
            'hotels.ae_test AS ae_test',
            'hotels.citytax AS citytax',
            'hotels.wifi_network AS wifi_network',
            'hotels.wifi_password AS wifi_password',
            'hotels.chek_email AS chek_email',
            'hotels.chek_tel AS chek_tel',
            'hotels.nexi_alias AS nexi_alias',
            'hotels.nexi_key AS nexi_key',
            'hotels.nexi_url AS nexi_url',
            'hotels.cir_bdsr AS cir_bdsr',
            'hotels.cin_bdsr AS cin_bdsr',
            'hotels.catastale_id AS catastale_id'
        ]);

        $this->applyListFilters($builder, $filters, true);

        if ($after !== null && $after !== '') {
            $builder->where('hotels.hotel_id >', $after);
        }

        return $builder
            ->orderBy('hotels.hotel_id', 'ASC')
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

            $column = $qualified ? 'hotels.' . $field : $field;
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
                $builder->where('hotels.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'hotel_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'hotel_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('hotels.' . $sort, $direction)
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

    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function getDocFileByHotelId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('doc_file')
            ->where('hotel_id', $parentId)
            ->orderBy('doc_files_id', 'DESC')
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
    public function getGuastiByHotelId(int|string $parentId, int $limit = 20): array
    {
        $limit = max(1, min(200, $limit));
        $rows = $this->db->table('guasti')
            ->where('hotel_id', $parentId)
            ->orderBy('guasto_id', 'DESC')
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
        $result['doc_file__hotel_id'] = $this->getDocFileByHotelId($parentId, 20);

        $result['guasti__hotel_id'] = $this->getGuastiByHotelId($parentId, 20);
        return $result;
    }

}
