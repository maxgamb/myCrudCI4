<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Analysis;

use App\Libraries\MyCrud\Schema\DbSchema;
use App\Libraries\MyCrud\Schema\TableFilter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Config\MyCrud;

/**
 * Deterministic structural domain analysis derived from the database schema.
 *
 * V2 separates hard structural shape from the probable domain role:
 *
 * 1. structural shape: view / pivot / ordinary table / satellite-like table;
 * 2. probable role: master / transactional / dependent / lookup.
 *
 * It never invents application use-cases or business operations.
 */
final class DomainAnalyzer
{
    private const TECHNICAL_COLUMNS = [
        'created_at', 'updated_at', 'deleted_at', 'last_update',
        'created_on', 'updated_on', 'deleted_on', 'created', 'updated', 'create_date',
    ];

    private BaseConnection $db;
    private MyCrud $config;
    private DbSchema $schema;

    public function __construct(?BaseConnection $db = null, ?MyCrud $config = null)
    {
        $this->db = $db ?? Database::connect();
        $this->config = $config ?? config('MyCrud');
        $this->schema = new DbSchema($this->db, $this->config);
    }

    /**
     * @return array{
     *   summary: array<string,int>,
     *   resources: array<string,array<string,mixed>>,
     *   relations: list<array<string,mixed>>,
     *   rootCandidates: list<array<string,mixed>>
     * }
     */
    public function analyze(): array
    {
        $tables = TableFilter::validTables($this->db, $this->config);
        $tableSet = array_fill_keys($tables, true);
        $tableInfo = [];

        foreach ($tables as $table) {
            $tableInfo[$table] = $this->schema->getTableInfo($table);
        }

        $relations = $this->relations($tableSet);
        $incoming = array_fill_keys($tables, []);
        $outgoing = array_fill_keys($tables, []);

        foreach ($relations as $relation) {
            $child = (string) $relation['childTable'];
            $parent = (string) $relation['parentTable'];
            $outgoing[$child][] = $relation;
            $incoming[$parent][] = $relation;
        }

        $resources = [];
        foreach ($tables as $table) {
            $resources[$table] = $this->classify(
                $tableInfo[$table],
                $outgoing[$table],
                $incoming[$table]
            );
        }

        uasort($resources, static function (array $a, array $b): int {
            $root = ($b['rootScore'] <=> $a['rootScore']);
            return $root !== 0 ? $root : strcasecmp((string) $a['table'], (string) $b['table']);
        });

        $summary = [
            'total' => count($resources),
            'master' => 0,
            'transactional' => 0,
            'dependent' => 0,
            'lookup' => 0,
            'pivot' => 0,
            'view' => 0,
        ];

        foreach ($resources as $resource) {
            $key = (string) $resource['classification'];
            if (isset($summary[$key])) {
                $summary[$key]++;
            }
        }

        $rootCandidates = [];
        foreach ($resources as $resource) {
            if (!(bool) $resource['rootCandidate']) {
                continue;
            }

            $rootCandidates[] = [
                'table' => $resource['table'],
                'classification' => $resource['classification'],
                'score' => $resource['rootScore'],
                'confidence' => $resource['confidence'],
            ];
        }

        usort($rootCandidates, static fn (array $a, array $b): int =>
            ($b['score'] <=> $a['score']) ?: strcasecmp((string) $a['table'], (string) $b['table'])
        );

        return [
            'summary' => $summary,
            'resources' => $resources,
            'relations' => $relations,
            'rootCandidates' => array_slice($rootCandidates, 0, 12),
        ];
    }

    /** @param array<string,bool> $tableSet */
    private function relations(array $tableSet): array
    {
        $rows = $this->db->query(
            'SELECT kcu.TABLE_NAME AS childTable,
                    kcu.COLUMN_NAME AS childColumn,
                    kcu.REFERENCED_TABLE_NAME AS parentTable,
                    kcu.REFERENCED_COLUMN_NAME AS parentColumn,
                    kcu.CONSTRAINT_NAME AS constraintName,
                    rc.DELETE_RULE AS deleteRule,
                    rc.UPDATE_RULE AS updateRule
             FROM information_schema.KEY_COLUMN_USAGE kcu
             LEFT JOIN information_schema.REFERENTIAL_CONSTRAINTS rc
               ON rc.CONSTRAINT_SCHEMA = kcu.CONSTRAINT_SCHEMA
              AND rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
              AND rc.TABLE_NAME = kcu.TABLE_NAME
             WHERE kcu.TABLE_SCHEMA = DATABASE()
               AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
             ORDER BY kcu.TABLE_NAME, kcu.CONSTRAINT_NAME, kcu.ORDINAL_POSITION'
        )->getResultArray();

        $relations = [];
        foreach ($rows as $row) {
            $child = (string) ($row['childTable'] ?? '');
            $parent = (string) ($row['parentTable'] ?? '');
            if (!isset($tableSet[$child], $tableSet[$parent])) {
                continue;
            }

            $relations[] = [
                'childTable' => $child,
                'childColumn' => (string) ($row['childColumn'] ?? ''),
                'parentTable' => $parent,
                'parentColumn' => (string) ($row['parentColumn'] ?? ''),
                'constraintName' => (string) ($row['constraintName'] ?? ''),
                'deleteRule' => strtoupper((string) ($row['deleteRule'] ?? '')),
                'updateRule' => strtoupper((string) ($row['updateRule'] ?? '')),
            ];
        }

        return $relations;
    }

    /**
     * @param array<string,mixed> $info
     * @param list<array<string,mixed>> $outgoing
     * @param list<array<string,mixed>> $incoming
     * @return array<string,mixed>
     */
    private function classify(array $info, array $outgoing, array $incoming): array
    {
        $table = (string) $info['name'];
        $columns = (array) ($info['columns'] ?? []);
        $columnNames = array_map(
            static fn (array $column): string => strtolower((string) ($column['name'] ?? '')),
            $columns
        );
        $pkColumns = array_map('strtolower', (array) ($info['primaryKeys'] ?? []));
        $fkColumns = array_map(
            static fn (array $fk): string => strtolower((string) ($fk['childColumn'] ?? '')),
            $outgoing
        );

        $parentTables = array_values(array_unique(array_map(
            static fn (array $fk): string => (string) $fk['parentTable'],
            $outgoing
        )));
        $childTables = array_values(array_unique(array_map(
            static fn (array $fk): string => (string) $fk['childTable'],
            $incoming
        )));
        sort($parentTables, SORT_NATURAL | SORT_FLAG_CASE);
        sort($childTables, SORT_NATURAL | SORT_FLAG_CASE);

        $outCount = count($outgoing);
        $inCount = count($incoming);
        $distinctParents = count($parentTables);

        $lifecycle = $this->lifecycleColumns($columnNames);
        $technical = array_values(array_intersect($columnNames, self::TECHNICAL_COLUMNS));
        $nonStructural = array_values(array_diff($columnNames, $pkColumns, $fkColumns, $technical));
        $meaningfulCount = count($nonStructural);

        $autoIncrementPk = $this->hasAutoIncrementPrimaryKey($columns, $pkColumns);
        $cascadeIncoming = count(array_filter(
            $incoming,
            static fn (array $r): bool => ($r['deleteRule'] ?? '') === 'CASCADE'
        ));
        $cascadeOutgoing = count(array_filter(
            $outgoing,
            static fn (array $r): bool => ($r['deleteRule'] ?? '') === 'CASCADE'
        ));

        $scores = [
            'master' => 0,
            'transactional' => 0,
            'dependent' => 0,
            'lookup' => 0,
            'pivot' => 0,
            'view' => 0,
        ];
        $evidence = [];

        if ((bool) ($info['isView'] ?? false)) {
            $scores['view'] = 100;
            $evidence[] = 'Database object is a SQL VIEW, therefore it is classified separately from writable resources.';
        } else {
            /*
             * STAGE A — structural shape.
             *
             * Strong shapes are handled before softer business-role heuristics.
             */
            $keyDominatedByForeignKeys = (bool) ($info['compositePrimaryKey'] ?? false)
                || ($pkColumns !== [] && array_diff($pkColumns, $fkColumns) === []);

            if ($distinctParents >= 2 && $keyDominatedByForeignKeys) {
                $scores['pivot'] += 10;
                $evidence[] = sprintf('References %d distinct parent resources and its key is dominated by foreign keys.', $distinctParents);

                if ($meaningfulCount <= 1) {
                    $scores['pivot'] += 4;
                    $evidence[] = 'Contains almost no autonomous business columns beyond PK/FK/technical fields.';
                }

                if ((bool) ($info['compositePrimaryKey'] ?? false)) {
                    $scores['pivot'] += 2;
                    $evidence[] = 'Uses a composite primary key, a strong relation-table signal.';
                }
            }

            /*
             * Autonomy: own identity + own state + being referenced by others.
             * This prevents "many FKs = transaction" from dominating resources
             * such as catalog/master tables.
             */
            $autonomyScore = 0;
            $autonomyScore += $autoIncrementPk ? 2 : 0;
            $autonomyScore += $meaningfulCount >= 5 ? 4 : ($meaningfulCount >= 3 ? 3 : ($meaningfulCount >= 2 ? 2 : ($meaningfulCount === 1 ? 1 : 0)));
            $autonomyScore += $inCount >= 3 ? 3 : ($inCount >= 1 ? 2 : 0);
            $autonomyScore -= $cascadeOutgoing > 0 ? 1 : 0;
            $autonomyScore = max(0, min(10, $autonomyScore));

            /*
             * Transactional resource:
             * - several parents;
             * - true lifecycle/event columns;
             * - often children of its own.
             *
             * V2 intentionally does NOT treat words such as "rental_rate" or
             * "rental_duration" as lifecycle evidence. Only temporal/status
             * shaped fields count.
             */
            if ($outCount >= 2) {
                $scores['transactional'] += 3;
            }
            if (count($lifecycle) >= 1) {
                $scores['transactional'] += 4;
                $evidence[] = 'Contains lifecycle/event fields: ' . implode(', ', $lifecycle) . '.';
            }
            if ($inCount >= 1 && $outCount >= 2) {
                $scores['transactional'] += 2;
            }
            if ($meaningfulCount >= 1) {
                $scores['transactional'] += 1;
            }
            if ($outCount >= 2 && count($lifecycle) >= 1 && $scores['pivot'] < 10) {
                $scores['transactional'] += 4;
                $evidence[] = 'Combines multiple parent relations with explicit lifecycle/event state.';
            }

            /*
             * Master / autonomous business resource.
             */
            if ($inCount >= 3) {
                $scores['master'] += 6;
                $evidence[] = sprintf('Is referenced by %d foreign-key relations.', $inCount);
            } elseif ($inCount >= 1) {
                $scores['master'] += 3;
            }

            if ($meaningfulCount >= 5) {
                $scores['master'] += 6;
                $evidence[] = sprintf('Owns %d autonomous descriptive/business columns.', $meaningfulCount);
            } elseif ($meaningfulCount >= 3) {
                $scores['master'] += 4;
                $evidence[] = sprintf('Owns %d autonomous descriptive/business columns.', $meaningfulCount);
            } elseif ($meaningfulCount === 2) {
                $scores['master'] += 2;
            }

            if ($autoIncrementPk) {
                $scores['master'] += 2;
            }
            if ($autonomyScore >= 7) {
                $scores['master'] += 3;
                $evidence[] = sprintf('High structural autonomy score: %d/10.', $autonomyScore);
            }

            /*
             * Lookup/reference:
             * compact dictionary-like tables should normally have no more than
             * one parent. Two or more parent references are a strong signal
             * against a simple lookup classification.
             */
            if ($inCount >= 1 && $distinctParents <= 1 && count($columns) <= 6 && $meaningfulCount <= 1) {
                $scores['lookup'] += 8;
                $evidence[] = 'Compact reference-shaped table with one-or-zero parent dependencies and very little autonomous state.';
            } elseif ($inCount >= 1 && $distinctParents <= 1 && count($columns) <= 6 && $meaningfulCount === 2) {
                $scores['lookup'] += 4;
            }
            if ($distinctParents <= 1 && count($lifecycle) === 0) {
                $scores['lookup'] += 2;
            }
            if ($distinctParents >= 2) {
                $scores['lookup'] = max(0, $scores['lookup'] - 5);
            }

            /*
             * Dependent resource:
             * own row identity exists, but most of its meaning comes from
             * parent resources. Multiple parents with almost no autonomous
             * columns are especially strong dependency evidence.
             */
            if ($outCount >= 1) {
                $scores['dependent'] += 3;
            }
            if ($distinctParents >= 2 && $meaningfulCount <= 1 && $scores['pivot'] < 10) {
                $scores['dependent'] += 7;
                $evidence[] = 'Depends on multiple parent resources while owning very little autonomous business state.';
            } elseif ($outCount >= $inCount && $outCount > 0) {
                $scores['dependent'] += 2;
            }
            if ($cascadeOutgoing > 0) {
                $scores['dependent'] += 3;
                $evidence[] = sprintf('%d outgoing FK(s) use ON DELETE CASCADE.', $cascadeOutgoing);
            }
            if ($meaningfulCount <= 2) {
                $scores['dependent'] += 2;
            }

            /*
             * Satellite-like table:
             * no FK is declared, no other table references it, the PK is not
             * auto-generated, and only a small payload is stored. This is a
             * general signal for auxiliary/search/text extension tables.
             */
            if (
                $outCount === 0
                && $inCount === 0
                && !$autoIncrementPk
                && $pkColumns !== []
                && $meaningfulCount <= 3
                && count($columns) <= 5
            ) {
                $scores['dependent'] += 6;
                $scores['master'] = max(0, $scores['master'] - 2);
                $evidence[] = 'Looks satellite-like: non-generated primary key, no graph ownership, and a small auxiliary payload.';
            }

            /*
             * Guard rails between competing roles.
             */
            if ($scores['pivot'] >= 10) {
                $scores['transactional'] = max(0, $scores['transactional'] - 7);
                $scores['dependent'] = max(0, $scores['dependent'] - 3);
                $scores['master'] = max(0, $scores['master'] - 3);
            }

            if ($autonomyScore >= 7 && count($lifecycle) === 0 && $meaningfulCount >= 3) {
                $scores['transactional'] = max(0, $scores['transactional'] - 3);
            }

            if ($distinctParents >= 2 && $meaningfulCount <= 1 && count($lifecycle) === 0 && $scores['pivot'] < 10) {
                $scores['master'] = max(0, $scores['master'] - 2);
            }
        }

        arsort($scores);
        $classification = (string) array_key_first($scores);
        $topScore = (int) reset($scores);
        $nextScore = (int) (array_values($scores)[1] ?? 0);
        $gap = $topScore - $nextScore;

        $confidence = match (true) {
            $classification === 'view' => 'high',
            $topScore >= 12 && $gap >= 4 => 'high',
            $topScore >= 8 && $gap >= 2 => 'medium',
            default => 'low',
        };

        $rootScore = $this->rootScore(
            $classification,
            count($incoming),
            count($outgoing),
            count($lifecycle),
            count($nonStructural),
            (bool) ($info['hasPrimaryKey'] ?? false),
            $autoIncrementPk,
            $cascadeIncoming
        );

        $rootCandidate = !in_array($classification, ['pivot', 'lookup', 'dependent', 'view'], true)
            && $rootScore >= 8;

        $evidence = array_values(array_unique($evidence));
        $evidence[] = sprintf('Structural score: %s.', $this->scoreText($scores));

        return [
            'table' => $table,
            'classification' => $classification,
            'classificationLabel' => $this->label($classification),
            'confidence' => $confidence,
            'rootCandidate' => $rootCandidate,
            'rootScore' => $rootScore,
            'parents' => $parentTables,
            'children' => $childTables,
            'outgoingCount' => count($outgoing),
            'incomingCount' => count($incoming),
            'lifecycleFields' => $lifecycle,
            'meaningfulColumns' => $nonStructural,
            'rowEstimate' => (int) ($info['rowEstimate'] ?? 0),
            'evidence' => $evidence,
            'scores' => $scores,
        ];
    }

    /** @param list<string> $columnNames */
    private function lifecycleColumns(array $columnNames): array
    {
        $matches = [];

        foreach ($columnNames as $column) {
            if (in_array($column, self::TECHNICAL_COLUMNS, true)) {
                continue;
            }

            /*
             * Lifecycle means state transition / event time, not every column
             * containing a domain word. Examples that DO match:
             *   rental_date, return_date, payment_date, closed_at, status
             * Examples that DO NOT match:
             *   rental_rate, rental_duration, replacement_cost
             */
            if (
                preg_match('/(^|_)(status|state)($|_)/i', $column) === 1
                || preg_match('/(^|_)(closed|cancelled|canceled|returned|return|started|ended|completed|paid|approved|rejected)(_|$)/i', $column) === 1
                || preg_match('/(^|_)(date|datetime|timestamp|time)$/i', $column) === 1
                || preg_match('/_(date|datetime|timestamp|time|at|on)$/i', $column) === 1
            ) {
                $matches[] = $column;
            }
        }

        return array_values(array_unique($matches));
    }

    /**
     * @param list<array<string,mixed>> $columns
     * @param list<string> $pkColumns
     */
    private function hasAutoIncrementPrimaryKey(array $columns, array $pkColumns): bool
    {
        if ($pkColumns === []) {
            return false;
        }

        foreach ($columns as $column) {
            $name = strtolower((string) ($column['name'] ?? ''));
            if (!in_array($name, $pkColumns, true)) {
                continue;
            }

            $extra = strtolower((string) ($column['extra'] ?? ''));
            if (str_contains($extra, 'auto_increment')) {
                return true;
            }
        }

        return false;
    }

    private function rootScore(
        string $classification,
        int $incoming,
        int $outgoing,
        int $lifecycleCount,
        int $meaningfulCount,
        bool $hasPrimaryKey,
        bool $autoIncrementPk,
        int $cascadeIncoming
    ): int {
        if (in_array($classification, ['pivot', 'lookup', 'dependent', 'view'], true)) {
            return 0;
        }

        $score = 0;

        // Root candidacy is deliberately different from graph centrality.
        $score += min(5, $incoming);
        $score += $hasPrimaryKey ? 2 : 0;
        $score += $autoIncrementPk ? 2 : 0;
        $score += min(5, $meaningfulCount);
        $score += $lifecycleCount > 0 ? 2 : 0;
        $score += $classification === 'master' ? 2 : 3;

        // Too many parent dependencies reduce root autonomy.
        $score -= max(0, $outgoing - 1);
        $score += min(1, $cascadeIncoming);

        return max(0, min(20, $score));
    }

    /** @param array<string,int> $scores */
    private function scoreText(array $scores): string
    {
        $parts = [];
        foreach ($scores as $type => $score) {
            if ($score <= 0) {
                continue;
            }
            $parts[] = $type . '=' . $score;
        }

        return implode(', ', $parts);
    }

    private function label(string $classification): string
    {
        return match ($classification) {
            'master' => 'Master resource',
            'transactional' => 'Transactional resource',
            'dependent' => 'Dependent resource',
            'lookup' => 'Lookup / reference',
            'pivot' => 'Pivot / relation',
            'view' => 'SQL view',
            default => ucfirst($classification),
        };
    }
}
