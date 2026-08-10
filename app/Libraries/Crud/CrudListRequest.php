<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * Normalizza i parametri comuni dell'elenco CRUD.
 *
 * Lato sito: Controller diversi condividono la stessa lettura di filtri,
 * pagina, righe per pagina e ordinamento. La whitelist effettiva di campi e
 * operatori resta nel Model, che è l'unico livello autorizzato a comporre query.
 */
final class CrudListRequest
{
    /** @param list<array{field:string,operator:string,value:mixed,value_to:mixed,logic:string}> $filters */
    private function __construct(
        public readonly array $filters,
        public readonly int $page,
        public readonly int $perPage,
        public readonly string $sort,
        public readonly string $direction,
        public readonly array $query,
    ) {
    }

    /** @param list<int> $allowedPerPage */
    public static function fromRequest(
        IncomingRequest $request,
        string $defaultSort,
        array $allowedPerPage = [25, 50, 100],
        array $simpleFilterFields = []
    ): self {
        $allowedPerPage = array_values(array_unique(array_map('intval', $allowedPerPage)));
        $allowedPerPage = array_values(array_filter(
            $allowedPerPage,
            static fn (int $value): bool => $value > 0 && $value <= 500
        ));
        if ($allowedPerPage === []) {
            $allowedPerPage = [25, 50, 100];
        }

        $requestedPerPage = (int) ($request->getGet('perPage') ?? $allowedPerPage[0]);
        $perPage = in_array($requestedPerPage, $allowedPerPage, true)
            ? $requestedPerPage
            : $allowedPerPage[0];

        $direction = strtolower((string) ($request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $query = (array) $request->getGet();
        $filters = self::normalizeFilters((array) ($query['filters'] ?? []));
        $filters = array_merge($filters, self::normalizeSimpleFilters($query, $simpleFilterFields));

        return new self(
            filters: $filters,
            page: max(1, (int) ($query['page'] ?? 1)),
            perPage: $perPage,
            sort: trim((string) ($query['sort'] ?? $defaultSort)) ?: $defaultSort,
            direction: $direction,
            query: $query,
        );
    }

    /**
     * Converte la forma corta `?campo=valore` nello stesso filtro `eq` usato
     * dal motore dinamico. La whitelist viene generata dal CRUD e comprende
     * solo campi realmente filtrabili; i parametri vuoti vengono ignorati.
     *
     * @param array<string,mixed> $query
     * @param list<string> $allowedFields
     * @return list<array{field:string,operator:string,value:mixed,value_to:mixed,logic:string}>
     */
    private static function normalizeSimpleFilters(array $query, array $allowedFields): array
    {
        $allowed = array_fill_keys(array_values(array_unique(array_map('strval', $allowedFields))), true);
        if ($allowed === []) {
            return [];
        }

        $normalized = [];
        foreach ($query as $field => $value) {
            $field = (string) $field;
            if (!isset($allowed[$field]) || is_array($value) || $value === null) {
                continue;
            }

            $value = (string) $value;
            if ($value === '') {
                continue;
            }

            $normalized[] = [
                'field' => $field,
                'operator' => 'eq',
                'value' => $value,
                'value_to' => null,
                'logic' => 'and',
            ];
        }

        return $normalized;
    }

    /**
     * Mantiene solo la forma strutturale dei filtri. Non considera attendibili
     * campo e operatore: la validazione semantica viene eseguita dal Model.
     *
     * @return list<array{field:string,operator:string,value:mixed,value_to:mixed,logic:string}>
     */
    private static function normalizeFilters(array $filters): array
    {
        $normalized = [];

        foreach ($filters as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $field = trim((string) ($filter['field'] ?? ''));
            $operator = trim((string) ($filter['operator'] ?? ''));
            if ($field === '' || $operator === '') {
                continue;
            }

            $normalized[] = [
                'field' => $field,
                'operator' => $operator,
                'value' => $filter['value'] ?? null,
                'value_to' => $filter['value_to'] ?? null,
                'logic' => strtolower((string) ($filter['logic'] ?? 'and')) === 'or' ? 'or' : 'and',
            ];
        }

        return $normalized;
    }
}