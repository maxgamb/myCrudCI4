<?php

declare(strict_types=1);

namespace App\Models;


use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/** Model per foglio_giorno; tutte le query del CRUD sono centralizzate qui. */
final class FoglioGiornoModel extends Model
{
    protected $table = 'foglio_giorno';
    protected $primaryKey = 'foglio_id';
    protected $returnType = 'object';
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
    'mode' => 'exact',
    'type' => 'int',
  ),
  'hotel_id' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'conto_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'camera_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'preno_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'tipologia_id' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
  ),
  'foglio_prezzo_camera' => 
  array (
    'mode' => 'exact',
    'type' => 'decimal',
  ),
  'date_foglio' => 
  array (
    'mode' => 'prefix',
    'type' => 'varchar',
  ),
  'in_conto' => 
  array (
    'mode' => 'range',
    'type' => 'date',
  ),
  'out_preno' => 
  array (
    'mode' => 'range',
    'type' => 'date',
  ),
  'stato_camera' => 
  array (
    'mode' => 'exact',
    'type' => 'smallint',
  ),
  'preno_agenzia' => 
  array (
    'mode' => 'exact',
    'type' => 'int',
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
            'default_full'
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

    /** Legge il CSV a blocchi usando la chiave primaria come cursore. */
    public function getCsvRows(array $filters, int $limit = 2000, int|string|null $after = null): array
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

    public function countCsvRows(array $filters): int
    {
        $builder = $this->listCountBuilder();
        $this->applyListFilters($builder, $filters, false);

        return $this->countListRows($builder, $filters);
    }

    /** @return list<string> */
    public function csvFields(): array
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
        foreach ($filters as $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    if (is_scalar($item) && trim((string) $item) !== '') {
                        return true;
                    }
                }
                continue;
            }
            if (is_scalar($value) && trim((string) $value) !== '') {
                return true;
            }
        }

        return false;
    }

    public function clearListCountCache(): void
    {
        service('cache')->delete('mycrud_list_total_' . md5($this->table));
    }

    private function applyListFilters(BaseBuilder $builder, array $filters, bool $qualified): void
    {
        foreach (self::LIST_FILTERS as $field => $definition) {
            $column = $qualified ? 'foglio_giorno.' . $field : $field;
            $mode = (string) ($definition['mode'] ?? 'exact');
            $value = $filters[$field] ?? null;

            if ($mode === 'range') {
                if (!is_array($value)) {
                    continue;
                }
                $from = trim((string) ($value['from'] ?? ''));
                $to = trim((string) ($value['to'] ?? ''));
                if ($from !== '') {
                    $builder->where($column . ' >=', $from);
                }
                if ($to !== '') {
                    $builder->where($column . ' <=', $to);
                }
                continue;
            }

            if (!is_scalar($value)) {
                continue;
            }

            $value = trim((string) $value);
            if ($value === '') {
                continue;
            }

            if ($mode === 'prefix') {
                if (strlen($value) >= 2) {
                    $builder->like($column, $value, 'after');
                }
                continue;
            }

            $builder->where($column, $value);
        }
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
    public function getAgenziePrenoAgenziumOptions(): array
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
            'preno_agenzia' => $this->toOptions($this->getAgenziePrenoAgenziumOptions(), 'agenzia_id', 'agenzia_tipologia'),
            'camera_id' => $this->toOptions($this->getCamereCameraIdOptions(), 'camera_id', 'tipologia_camera'),
            'tipologia_id' => $this->toOptions($this->getTipologiaCameraTipologiaIdOptions(), 'tipologia_id', 'nome_tipologia'),
        ];
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
