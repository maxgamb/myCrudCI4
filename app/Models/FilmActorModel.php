<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\FilmActorEntity;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use RuntimeException;
use Throwable;

/** Model per film_actor; tutte le query del CRUD sono centralizzate qui. */
final class FilmActorModel extends Model
{
    protected $table = 'film_actor';
    protected $primaryKey = 'actor_id';
    protected $returnType = FilmActorEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'actor_id',
  1 => 'film_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    private const LIST_FILTERS = array (
  'actor_id' => 
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
);
    private const SORTABLE_FIELDS = array (
  0 => 'actor_id',
  1 => 'film_id',
);
    private const EXPORT_FIELDS = array (
  0 => 'actor_id',
  1 => 'film_id',
  2 => 'last_update',
);
    private const PRIMARY_KEYS = array (
  0 => 'actor_id',
  1 => 'film_id',
);
    private const RELATION_SEARCHES = array (
  'actor_id' => 
  array (
    'table' => 'actor',
    'key' => 'actor_id',
    'displayField' => 'last_name',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'last_name',
    ),
    'mode' => 'select',
  ),
  'film_id' => 
  array (
    'table' => 'film',
    'key' => 'film_id',
    'displayField' => 'title',
    'displayTemplate' => '',
    'displayFields' => 
    array (
      0 => 'title',
    ),
    'mode' => 'select',
  ),
);
    private const RELATED_CREATES = array (
  'actor_id' => 
  array (
    'table' => 'actor',
    'key' => 'actor_id',
    'keyAutoIncrement' => true,
    'fields' => 
    array (
      0 => 'first_name',
      1 => 'last_name',
    ),
    'nullableFields' => 
    array (
    ),
    'defaultedFields' => 
    array (
    ),
    'dateTimeFields' => 
    array (
    ),
  ),
  'film_id' => 
  array (
    'table' => 'film',
    'key' => 'film_id',
    'keyAutoIncrement' => true,
    'fields' => 
    array (
      0 => 'title',
      1 => 'description',
      2 => 'release_year',
      3 => 'language_id',
      4 => 'original_language_id',
      5 => 'rental_duration',
      6 => 'rental_rate',
      7 => 'length',
      8 => 'replacement_cost',
      9 => 'rating',
      10 => 'special_features',
    ),
    'nullableFields' => 
    array (
      0 => 'description',
      1 => 'release_year',
      2 => 'original_language_id',
      3 => 'length',
      4 => 'rating',
      5 => 'special_features',
    ),
    'defaultedFields' => 
    array (
      0 => 'rental_duration',
      1 => 'rental_rate',
      2 => 'replacement_cost',
      3 => 'rating',
    ),
    'dateTimeFields' => 
    array (
    ),
  ),
);
    private const COUNT_CACHE_SECONDS = 60;

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_actor');
        $builder->select([
            'film_actor.actor_id AS actor_id',
            'film_actor.film_id AS film_id',
            'film_actor.last_update AS last_update',
            'actor__actor_id.last_name AS actor_id__label',
            'film__film_id.title AS film_id__label'
        ]);
        $this->joinActorActorId($builder);
        $this->joinFilmFilmId($builder);
        return $builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_actor');
        $builder->select([
            'film_actor.actor_id AS actor_id',
            'film_actor.film_id AS film_id',
            'film_actor.last_update AS last_update',
            'actor__actor_id.last_name AS actor_id__label',
            'film__film_id.title AS film_id__label'
        ]);
        $this->joinActorActorId($builder);
        $this->joinFilmFilmId($builder);
        return $builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        $builder = $this->db->table('film_actor');
        return $builder;
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where('film_actor.actor_id', $id)
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
        string $sort = 'actor_id',
        string $direction = 'desc'
    ): array {
        $page = max(1, $page);
        $perPage = max(25, min(100, $perPage));
        $sort = in_array($sort, self::SORTABLE_FIELDS, true) ? $sort : 'actor_id';
        $direction = strtolower($direction) === 'asc' ? 'ASC' : 'DESC';

        $dataBuilder = $this->listBuilder();
        $countBuilder = $this->listCountBuilder();
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyListFilters($countBuilder, $filters, false);

        $total = $this->countListRows($countBuilder, $filters);
        $rows = $dataBuilder
            ->orderBy('film_actor.' . $sort, $direction)
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
        $builder = $this->db->table('film_actor');
        $builder->select([
            'film_actor.actor_id AS actor_id',
            'film_actor.film_id AS film_id',
            'film_actor.last_update AS last_update',
            'actor__actor_id.last_name AS actor_id__label',
            'film__film_id.title AS film_id__label'
        ]);
        $this->joinActorActorId($builder);
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
            ->orderBy('film_actor.actor_id', 'ASC')
            ->orderBy('film_actor.film_id', 'ASC')
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

            $column = $qualified ? 'film_actor.' . $field : $field;
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

    /**
     * Inserisce il record corrente e, se richiesto dal form, crea prima i
     * record padre nella stessa transazione usando la PK generata come FK.
     */
    public function createRecord(array $data, array $related = []): int|string
    {
        $transactional = $related !== [];
        if ($transactional) {
            $this->db->transBegin();
        }

        try {
            foreach ($related as $field => $payload) {
                if (!is_array($payload) || !isset(self::RELATED_CREATES[$field])) {
                    continue;
                }
                $data[$field] = $this->createRelatedRecord((string) $field, $payload);
            }

            $id = $this->insert($data, true);
            if ($id === false) {
                throw new RuntimeException(implode(' ', $this->errors()) ?: 'Inserimento non riuscito.');
            }

            if ($transactional) {
                if (!$this->db->transStatus()) {
                    throw new RuntimeException('Transazione di inserimento non riuscita.');
                }
                $this->db->transCommit();
            }
        } catch (Throwable $e) {
            if ($transactional) {
                $this->db->transRollback();
            }
            throw $e;
        }

        $this->clearListCountCache();
        if (array_key_exists('actor_id', $data) && (is_int($data['actor_id']) || is_string($data['actor_id']))) {
            return $data['actor_id'];
        }
        return is_int($id) ? $id : (string) $id;
    }

    /** Crea un singolo record padre autorizzato dalla configurazione generata. */
    private function createRelatedRecord(string $field, array $data): int|string
    {
        $definition = self::RELATED_CREATES[$field] ?? null;
        if (!is_array($definition)) {
            throw new RuntimeException('Creazione record collegato non autorizzata per ' . $field . '.');
        }

        $allowed = array_fill_keys((array) ($definition['fields'] ?? []), true);
        $payload = array_intersect_key($data, $allowed);

        // I form HTML inviano stringa vuota anche per campi opzionali. Per i
        // nullable usiamo NULL; per colonne con DEFAULT omettiamo il valore e
        // lasciamo che sia il database ad applicare la propria policy.
        $nullable = array_fill_keys((array) ($definition['nullableFields'] ?? []), true);
        $defaulted = array_fill_keys((array) ($definition['defaultedFields'] ?? []), true);
        foreach ($payload as $payloadField => $payloadValue) {
            if (!is_string($payloadValue) || trim($payloadValue) !== '') {
                continue;
            }
            if (isset($defaulted[$payloadField])) {
                unset($payload[$payloadField]);
                continue;
            }
            if (isset($nullable[$payloadField])) {
                $payload[$payloadField] = null;
            }
        }

        // datetime-local usa il separatore T; normalizziamo al formato SQL
        // prima dell'insert generico del record collegato.
        foreach ((array) ($definition['dateTimeFields'] ?? []) as $dateTimeField) {
            if (isset($payload[$dateTimeField]) && is_string($payload[$dateTimeField])) {
                $payload[$dateTimeField] = str_replace('T', ' ', $payload[$dateTimeField]);
            }
        }

        $table = (string) ($definition['table'] ?? '');
        $key = (string) ($definition['key'] ?? '');
        if ($table === '' || $key === '') {
            throw new RuntimeException('Configurazione record collegato incompleta.');
        }

        if (!$this->db->table($table)->insert($payload)) {
            throw new RuntimeException('Inserimento record collegato non riuscito: ' . $table . '.');
        }

        if (!empty($definition['keyAutoIncrement'])) {
            $id = $this->db->insertID();
            if ($id === 0 || $id === '0' || $id === '') {
                throw new RuntimeException('Chiave generata non disponibile per ' . $table . '.');
            }
            return is_int($id) ? $id : (string) $id;
        }

        $id = $payload[$key] ?? null;
        if (!is_int($id) && !is_string($id)) {
            throw new RuntimeException('La chiave del record collegato deve essere valorizzata: ' . $key . '.');
        }

        return $id;
    }
    /** FK film_actor.actor_id -> actor.actor_id; risultato: actor_id__label. */
    private function joinActorActorId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'actor AS actor__actor_id',
            'actor__actor_id.actor_id = film_actor.actor_id',
            'left'
        );

        return $builder;
    }
    /** FK film_actor.film_id -> film.film_id; risultato: film_id__label. */
    private function joinFilmFilmId(BaseBuilder $builder): BaseBuilder
    {
        $builder->join(
            'film AS film__film_id',
            'film__film_id.film_id = film_actor.film_id',
            'left'
        );

        return $builder;
    }
    /** Elenco REST paginato con whitelist di filtri e ordinamento. */
    public function apiList(array $query, array $filterable, array $sortable): array
    {
        $page = max(1, (int) ($query['page'] ?? 1));
        $perPage = max(1, min(100, (int) ($query['perPage'] ?? 25)));
        $builder = $this->baseBuilder();

        foreach ((array) ($query['filter'] ?? []) as $field => $value) {
            if (is_scalar($value) && in_array($field, $filterable, true) && (string) $value !== '') {
                $builder->where('film_actor.' . $field, $value);
            }
        }

        $sort = (string) ($query['sort'] ?? 'actor_id');
        $sort = in_array($sort, $sortable, true) ? $sort : 'actor_id';
        $direction = strtolower((string) ($query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        $total = (clone $builder)->countAllResults(false);
        $rows = $builder->orderBy('film_actor.' . $sort, $direction)
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
    /** Restituisce le opzioni della relazione actor_id. */
    public function getActorActorIdOptions(): array
    {
        return $this->db->table('actor')
            ->select(array (
  0 => 'actor_id',
  1 => 'last_name',
))
            ->orderBy('last_name', 'ASC')
            ->get()
            ->getResultArray();
    }
    /** Restituisce le opzioni della relazione film_id. */
    public function getFilmFilmIdOptions(): array
    {
        return $this->db->table('film')
            ->select(array (
  0 => 'film_id',
  1 => 'title',
))
            ->orderBy('title', 'ASC')
            ->get()
            ->getResultArray();
    }
    public function relationOptions(): array
    {
        return [
            'actor_id' => $this->toRelationOptions($this->getActorActorIdOptions(), 'actor_id'),
            'film_id' => $this->toRelationOptions($this->getFilmFilmIdOptions(), 'film_id'),
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
