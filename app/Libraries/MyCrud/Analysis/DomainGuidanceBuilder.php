<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Analysis;

use App\Libraries\MyCrud\Core\Naming;

/**
 * Builds schema-aware, business-neutral development comments for generated code.
 *
 * DomainAnalyzer supplies only structural evidence. This builder converts that
 * evidence into commented examples for Entity, Model, Service and Controller
 * files without turning schema names into inferred business operations.
 */
final class DomainGuidanceBuilder
{
    /** @var array<string,mixed>|null */
    private static ?array $analysisCache = null;

    public function __construct(private readonly ?DomainAnalyzer $analyzer = null)
    {
    }

    /**
     * @return array<string,string>
     */
    public function forTable(string $table): array
    {
        $table = trim($table);
        if ($table === '') {
            return [];
        }

        if (self::$analysisCache === null) {
            self::$analysisCache = ($this->analyzer ?? new DomainAnalyzer())->analyze();
        }

        return $this->fromAnalysis(self::$analysisCache, $table);
    }

    /**
     * @param array<string,mixed> $analysis
     * @return array<string,string>
     */
    public function fromAnalysis(array $analysis, string $table): array
    {
        $resources = (array) ($analysis['resources'] ?? []);
        $resource = isset($resources[$table]) && is_array($resources[$table])
            ? $resources[$table]
            : null;

        if ($resource === null) {
            return [];
        }

        $relations = (array) ($analysis['relations'] ?? []);
        $roots = (array) ($analysis['rootCandidates'] ?? []);
        $rootCandidatesByTable = [];
        foreach ($roots as $candidate) {
            if (!is_array($candidate)) {
                continue;
            }
            $candidateTable = (string) ($candidate['table'] ?? '');
            if ($candidateTable !== '') {
                $rootCandidatesByTable[$candidateTable] = (int) ($candidate['score'] ?? 0);
            }
        }

        $classification = (string) ($resource['classification'] ?? 'unknown');
        $role = strtoupper($classification);
        $isRoot = array_key_exists($table, $rootCandidatesByTable) || !empty($resource['rootCandidate']);
        $rootScore = $rootCandidatesByTable[$table] ?? (int) ($resource['rootScore'] ?? 0);
        $parents = array_values((array) ($resource['parents'] ?? []));
        $children = array_values((array) ($resource['children'] ?? []));
        $lifecycleFields = array_values((array) ($resource['lifecycleFields'] ?? []));
        $stateFields = array_values((array) ($resource['stateFields'] ?? []));
        $meaningfulFields = array_values((array) ($resource['meaningfulColumns'] ?? []));

        [$outgoing, $incoming] = $this->relationDetails($table, $relations);
        $firstParentRelation = $outgoing[0] ?? null;
        $sampleField = (string) ($meaningfulFields[0] ?? '');
        $stateField = (string) ($stateFields[0] ?? '');
        $lifecycleQueryField = $stateField !== ''
            ? $stateField
            : (string) ($lifecycleFields[0] ?? '');
        $parentFk = is_array($firstParentRelation) ? (string) ($firstParentRelation['childColumn'] ?? '') : '';
        $parentTable = is_array($firstParentRelation) ? (string) ($firstParentRelation['parentTable'] ?? '') : '';
        $class = Naming::tableClass($table);

        $headerLines = [
            '========================================================================',
            'MYCRUD DOMAIN DEVELOPMENT EXAMPLE',
            '========================================================================',
            'Resource: ' . $table,
            'Structural role: ' . $role,
            'Structural root: ' . ($isRoot ? 'YES (' . $rootScore . '/20)' : 'NO'),
            'Parents: ' . ($parents !== [] ? implode(', ', $parents) : 'none'),
            'Children: ' . ($children !== [] ? implode(', ', $children) : 'none'),
            'Lifecycle/event signals: ' . ($lifecycleFields !== [] ? implode(', ', $lifecycleFields) : 'none'),
            'Explicit state fields: ' . ($stateFields !== [] ? implode(', ', $stateFields) : 'none'),
            'PHP types: ' . $class . 'Entity | ' . $class . 'Model | ' . $class . 'Service | ' . $class . 'Controller',
            'Full API boundary: ' . $class . 'ApiController',
        ];

        foreach ($outgoing as $relation) {
            $headerLines[] = sprintf(
                'FK OUT: %s.%s -> %s.%s | %sService',
                (string) ($relation['childTable'] ?? ''),
                (string) ($relation['childColumn'] ?? ''),
                (string) ($relation['parentTable'] ?? ''),
                (string) ($relation['parentColumn'] ?? ''),
                Naming::tableClass((string) ($relation['parentTable'] ?? ''))
            );
        }

        foreach ($incoming as $relation) {
            $headerLines[] = sprintf(
                'FK IN : %s.%s -> %s.%s | %sService',
                (string) ($relation['childTable'] ?? ''),
                (string) ($relation['childColumn'] ?? ''),
                (string) ($relation['parentTable'] ?? ''),
                (string) ($relation['parentColumn'] ?? ''),
                Naming::tableClass((string) ($relation['childTable'] ?? ''))
            );
        }

        if ($outgoing === [] && $incoming === []) {
            $headerLines[] = 'FK context: no relations detected for this resource.';
        }

        $headerLines[] = '';
        $headerLines[] = 'Schema-aware example only. Names come from the real database.';
        $headerLines[] = 'Their presence does NOT imply a business rule or operation.';
        $headerLines[] = 'Copy/adapt only what an explicit application requirement needs.';
        $headerLines[] = $isRoot
            ? 'Root guidance: candidate entry point for use-cases centered on this resource.'
            : 'Root guidance: keep responsibility local unless the requirement says otherwise.';
        $headerLines[] = '========================================================================';

        $header = $this->lineComment($headerLines);
        $entityLocal = $this->localEntityExample($table, $sampleField);
        $modelExample = $this->modelExample(
            $table,
            $sampleField,
            $lifecycleQueryField,
            $firstParentRelation
        );

        $childServiceNames = array_values(array_unique(array_filter(array_map(
            static fn (array $relation): string => Naming::tableClass((string) ($relation['childTable'] ?? '')) . 'Service',
            $incoming
        ))));
        $childServiceText = $childServiceNames !== [] ? implode(', ', $childServiceNames) : 'none detected';

        $examples = match ($classification) {
            'master' => $this->masterExamples($table, $class, $isRoot, $childServiceText, $entityLocal, $modelExample),
            'transactional' => $this->transactionalExamples(
                $table,
                $class,
                $isRoot,
                $childServiceText,
                $stateField,
                $entityLocal,
                $modelExample
            ),
            'dependent' => $this->dependentExamples(
                $table,
                $class,
                $parentFk,
                $parentTable,
                $firstParentRelation,
                $entityLocal,
                $modelExample
            ),
            'lookup' => $this->lookupExamples($table, $class, $sampleField, $modelExample),
            'pivot' => $this->pivotExamples($table, $outgoing),
            'view' => $this->viewExamples($table, $class, $modelExample),
            default => $this->defaultExamples($table, $class, $entityLocal, $modelExample),
        };

        $examples['apiController'] = $this->apiControllerExample(
            $table,
            $class,
            $classification
        );

        if (isset($examples['service'])) {
            $examples['serviceExtension'] = $this->blockComment([
                'ServiceExtension customization point for `' . $table . '`.',
                '',
                'The generated Service example below is reference code only.',
                'Move/adapt a real rule into this protected extension only when needed.',
                'Keep SQL/read queries in the Model and cross-resource writes in concrete Services.',
            ]) . "\n\n" . $examples['service'];
        }

        $result = [];
        foreach ($examples as $layer => $example) {
            $result[$layer] = rtrim($header . "\n\n" . $example) . "\n";
        }

        return $result;
    }

    /** @param list<mixed> $relations @return array{0:list<array<string,mixed>>,1:list<array<string,mixed>>} */
    private function relationDetails(string $table, array $relations): array
    {
        $outgoing = [];
        $incoming = [];

        foreach ($relations as $relation) {
            if (!is_array($relation)) {
                continue;
            }
            if ((string) ($relation['childTable'] ?? '') === $table) {
                $outgoing[] = $relation;
            }
            if ((string) ($relation['parentTable'] ?? '') === $table) {
                $incoming[] = $relation;
            }
        }

        return [$outgoing, $incoming];
    }

    private function localEntityExample(string $table, string $sampleField): string
    {
        if ($sampleField === '') {
            return $this->blockComment([
                'No safe record-local field example is emitted for this resource.',
                'Add Entity behavior only when the application defines a real local rule.',
            ]);
        }

        return $this->blockComment([
            'Example: syntax for a record-local rule using a real field.',
            'The field ' . $table . '.' . $sampleField . ' is used only to make the example concrete.',
            '',
            'public function hasLocalValue(): bool',
            '{',
            "    return array_key_exists('{$sampleField}', \$this->attributes);",
            '}',
            '',
            'Do not infer a business rule merely because this column exists.',
        ]);
    }

    /** @param array<string,mixed>|null $firstParentRelation */
    private function modelExample(
        string $table,
        string $sampleField,
        string $lifecycleQueryField,
        ?array $firstParentRelation
    ): string {
        $parentFk = $firstParentRelation !== null ? (string) ($firstParentRelation['childColumn'] ?? '') : '';
        if ($parentFk !== '') {
            $parentTable = (string) ($firstParentRelation['parentTable'] ?? '');
            $parentColumn = (string) ($firstParentRelation['parentColumn'] ?? '');
            $method = 'findBy' . Naming::studly($parentFk);
            $variable = lcfirst(Naming::studly($parentFk));

            return $this->blockComment([
                'Example: real FK-scoped query.',
                'Relation: ' . $table . '.' . $parentFk . ' -> ' . $parentTable . '.' . $parentColumn,
                '',
                'public function ' . $method . '(int|string $' . $variable . '): array',
                '{',
                '    return $this',
                "        ->where('{$parentFk}', \${$variable})",
                '        ->findAll();',
                '}',
            ]);
        }

        if ($lifecycleQueryField !== '') {
            $method = 'findBy' . Naming::studly($lifecycleQueryField);
            $variable = lcfirst(Naming::studly($lifecycleQueryField));

            return $this->blockComment([
                'Example: query using detected lifecycle/event field ' . $table . '.' . $lifecycleQueryField . '.',
                'This does not imply that the field is a business state.',
                '',
                'public function ' . $method . '(string $' . $variable . '): array',
                '{',
                "    return \$this->where('{$lifecycleQueryField}', \${$variable})->findAll();",
                '}',
            ]);
        }

        if ($sampleField !== '') {
            $method = 'findBy' . Naming::studly($sampleField);
            $variable = lcfirst(Naming::studly($sampleField));

            return $this->blockComment([
                'Example: query syntax using real field ' . $table . '.' . $sampleField . '.',
                'Add this only if the application really searches by this field.',
                '',
                'public function ' . $method . '(mixed $' . $variable . '): array',
                '{',
                "    return \$this->where('{$sampleField}', \${$variable})->findAll();",
                '}',
            ]);
        }

        return $this->blockComment([
            'No schema-backed filter example is emitted here.',
            'Add a Model method only for a real resource-specific read requirement.',
        ]);
    }

    /** @return array<string,string> */
    private function masterExamples(
        string $table,
        string $class,
        bool $isRoot,
        string $childServiceText,
        string $entityLocal,
        string $modelExample
    ): array {
        $serviceLines = [
            $isRoot
                ? 'Example: operation centered on potential structural root `' . $table . '`.'
                : 'Example: local operation on `' . $table . '`.',
            'Detected child Services: ' . $childServiceText . '.',
            '',
            'public function performAction(int|string $id, array $data = []): void',
            '{',
            '    $record = $this->model->find($id);',
            '    if ($record === null) {',
            "        throw new \\RuntimeException('{$table} record not found.');",
            '    }',
            '',
            $isRoot
                ? '    // Coordinate a detected child Service only when the approved use-case requires it.'
                : '    // Keep the rule local unless the approved use-case explicitly says otherwise.',
            '    // Never write directly to another resource Model from this Service.',
            '',
            '    $this->update($id, $data);',
            '}',
        ];

        return [
            'entity' => $entityLocal,
            'service' => $this->blockComment($serviceLines),
            'model' => $modelExample,
            'controller' => $this->blockComment([
                'Example: thin HTTP action for ' . $class . 'Service.',
                '',
                'public function performAction(int|string $id)',
                '{',
                '    $this->service->performAction($id, (array) $this->request->getPost());',
                '    return redirect()->back();',
                '}',
                '',
                'Cross-resource orchestration, if required, remains in ' . $class . 'Service.',
            ]),
        ];
    }

    /** @return array<string,string> */
    private function transactionalExamples(
        string $table,
        string $class,
        bool $isRoot,
        string $childServiceText,
        string $stateField,
        string $entityLocal,
        string $modelExample
    ): array {
        $entity = $stateField !== ''
            ? $this->blockComment([
                'Example: transition eligibility using explicit state field `' . $table . '.' . $stateField . '`.',
                '',
                'public function canTransitionTo(string $nextState): bool',
                '{',
                "    \$currentState = (string) (\$this->attributes['{$stateField}'] ?? '');",
                '    // Replace this with the real application transition rule.',
                "    return \$currentState !== '' && \$nextState !== '';",
                '}',
            ])
            : $entityLocal;

        if ($stateField === '') {
            $service = $this->blockComment([
                'This table is structurally transactional, but no explicit state field was detected.',
                'Detected date/time/event columns may describe lifecycle timing without defining a state machine.',
                'Do not invent a `status` column, transition API or next-state semantics.',
                'Add lifecycle behavior only from an explicit application requirement.',
            ]);
            $controller = $this->blockComment([
                'No state-transition Controller action is suggested because no explicit state field was detected.',
                'Date/time/event fields remain request data only when the approved use-case explicitly uses them.',
            ]);
        } else {
            $service = $this->blockComment([
                'Example: state operation using explicit state field `' . $stateField . '`.',
                $isRoot ? '`' . $table . '` is also a potential structural root.' : '`' . $table . '` is not a structural-root candidate.',
                'Detected child Services: ' . $childServiceText . '.',
                '',
                'public function transition(int|string $id, string $nextState): void',
                '{',
                '    $record = $this->model->find($id);',
                '    if ($record === null) {',
                "        throw new \\RuntimeException('{$table} record not found.');",
                '    }',
                '',
                $isRoot
                    ? '    // Coordinate dependent Services only when atomic writes are explicitly required.'
                    : '    // Keep this transition local unless broader coordination is explicitly assigned here.',
                "    \$this->update(\$id, ['{$stateField}' => \$nextState]);",
                '}',
            ]);
            $controller = $this->blockComment([
                'Example: thin HTTP action using explicit state field `' . $stateField . '`.',
                '',
                'public function transition(int|string $id)',
                '{',
                "    \$nextState = (string) \$this->request->getPost('{$stateField}');",
                '    $this->service->transition($id, $nextState);',
                '    return redirect()->back();',
                '}',
            ]);
        }

        return [
            'entity' => $entity,
            'service' => $service,
            'model' => $modelExample,
            'controller' => $controller,
        ];
    }

    /** @param array<string,mixed>|null $firstParentRelation @return array<string,string> */
    private function dependentExamples(
        string $table,
        string $class,
        string $parentFk,
        string $parentTable,
        ?array $firstParentRelation,
        string $entityLocal,
        string $modelExample
    ): array {
        if ($parentFk === '') {
            return [
                'entity' => $entityLocal,
                'service' => $this->blockComment(['No concrete parent FK was detected; no createForParent example is emitted.']),
                'model' => $modelExample,
                'controller' => $this->blockComment(['Keep custom HTTP actions minimal; no concrete parent-scoped action is suggested.']),
            ];
        }

        $parentColumn = (string) ($firstParentRelation['parentColumn'] ?? '');
        $parentClass = Naming::tableClass($parentTable);

        return [
            'entity' => $this->blockComment([
                'Example: local presence check for real parent FK `' . $table . '.' . $parentFk . '`.',
                '',
                'public function hasParentReference(): bool',
                '{',
                "    return !empty(\$this->attributes['{$parentFk}']);",
                '}',
                '',
                'Cross-resource rules remain in the Service.',
            ]),
            'service' => $this->blockComment([
                'Example: operation scoped by real parent relation',
                $table . '.' . $parentFk . ' -> ' . $parentTable . '.' . $parentColumn . '.',
                '',
                'public function createFor' . $parentClass . '(int|string $parentId, array $data): int|string',
                '{',
                '    // Verify the parent through its concrete Service only if a real cross-resource rule requires it.',
                "    \$data['{$parentFk}'] = \$parentId;",
                '    return $this->create($data);',
                '}',
            ]),
            'model' => $modelExample,
            'controller' => $this->blockComment([
                'Example: preserve real parent context `' . $parentTable . '` at the HTTP boundary.',
                '',
                'public function createFor' . $parentClass . '(int|string $parentId)',
                '{',
                '    $data = (array) $this->request->getPost();',
                '    $this->service->createFor' . $parentClass . '($parentId, $data);',
                '    return redirect()->back();',
                '}',
            ]),
        ];
    }

    /** @return array<string,string> */
    private function lookupExamples(string $table, string $class, string $sampleField, string $modelExample): array
    {
        $entity = $sampleField !== ''
            ? $this->blockComment([
                'Example: display representation using real field `' . $table . '.' . $sampleField . '`.',
                '',
                'public function displayValue(): string',
                '{',
                "    return trim((string) (\$this->attributes['{$sampleField}'] ?? ''));",
                '}',
                '',
                'Add this only if this field is really the application display value.',
            ])
            : $this->blockComment(['Lookup Entity behavior is normally unnecessary for this resource.']);

        return [
            'entity' => $entity,
            'service' => $this->blockComment([
                'Example: explicit reference-data operation on `' . $table . '`.',
                'Ordinary generated CRUD is normally sufficient.',
                '',
                'public function changeReferenceData(int|string $id, array $data): void',
                '{',
                '    $this->update($id, $data);',
                '}',
            ]),
            'model' => $modelExample,
            'controller' => $this->blockComment([
                'Usually no custom ' . $class . 'Controller action is required for lookup maintenance.',
            ]),
        ];
    }

    /** @param list<array<string,mixed>> $outgoing @return array<string,string> */
    private function pivotExamples(string $table, array $outgoing): array
    {
        $left = $outgoing[0] ?? null;
        $right = $outgoing[1] ?? null;
        if (!is_array($left) || !is_array($right)) {
            return [
                'entity' => $this->blockComment(['Pivot detected, but two concrete FK sides are not available.']),
                'service' => $this->blockComment(['Prefer generated relation APIs; no invented FK column names are emitted.']),
                'model' => $this->blockComment(['Add a relation query only when a real FK side is available.']),
                'controller' => $this->blockComment(['No custom relation action is suggested without two concrete FK sides.']),
            ];
        }

        $leftFk = (string) ($left['childColumn'] ?? '');
        $rightFk = (string) ($right['childColumn'] ?? '');
        $leftTable = (string) ($left['parentTable'] ?? '');
        $rightTable = (string) ($right['parentTable'] ?? '');
        $leftVar = lcfirst(Naming::studly($leftFk));
        $rightVar = lcfirst(Naming::studly($rightFk));
        $leftMethod = 'findBy' . Naming::studly($leftFk);

        return [
            'entity' => $this->blockComment([
                'Example: both real pivot sides are present.',
                $table . '.' . $leftFk . ' -> ' . $leftTable . '; ' . $table . '.' . $rightFk . ' -> ' . $rightTable . '.',
                '',
                'public function hasBothSides(): bool',
                '{',
                "    return !empty(\$this->attributes['{$leftFk}'])",
                "        && !empty(\$this->attributes['{$rightFk}']);",
                '}',
            ]),
            'service' => $this->blockComment([
                'Example: explicit relation operation using the real pivot FKs.',
                'Prefer generated many-to-many APIs when they already cover the use-case.',
                '',
                'public function link(int|string $' . $leftVar . ', int|string $' . $rightVar . '): int|string',
                '{',
                '    return $this->create([',
                "        '{$leftFk}' => \${$leftVar},",
                "        '{$rightFk}' => \${$rightVar},",
                '    ]);',
                '}',
            ]),
            'model' => $this->blockComment([
                'Example: real pivot-side query.',
                '',
                'public function ' . $leftMethod . '(int|string $' . $leftVar . '): array',
                '{',
                "    return \$this->where('{$leftFk}', \${$leftVar})->findAll();",
                '}',
            ]),
            'controller' => $this->blockComment([
                'Example: expose a custom relation action only when needed.',
                '',
                'public function link()',
                '{',
                "    \${$leftVar} = (string) \$this->request->getPost('{$leftFk}');",
                "    \${$rightVar} = (string) \$this->request->getPost('{$rightFk}');",
                '    $this->service->link($' . $leftVar . ', $' . $rightVar . ');',
                '    return redirect()->back();',
                '}',
            ]),
        ];
    }

    /** @return array<string,string> */
    private function viewExamples(string $table, string $class, string $modelExample): array
    {
        return [
            'entity' => $this->blockComment([
                'SQL VIEW projection: keep Entity behavior read-only and record-local.',
                'Do not add mutation semantics merely because an Entity class is generated.',
            ]),
            'model' => $modelExample,
            'controller' => $this->blockComment([
                'SQL VIEW controller guidance for `' . $table . '`.',
                'Keep custom actions read-only and delegate queries to ' . $class . 'Model.',
                'Apply writes to the underlying real resources, never to the projection.',
            ]),
        ];
    }

    private function apiControllerExample(
        string $table,
        string $class,
        string $classification
    ): string {
        if ($classification === 'view') {
            return $this->blockComment([
                'API boundary guidance for SQL VIEW `' . $table . '`.',
                '',
                'Reads -> ' . $class . 'Model.',
                'Writes -> none: this projection is read-only.',
                '',
                'Keep request parsing, HTTP status codes and serialization in this API Controller.',
                'Do not add SQL, persistence or business transitions here.',
                'Apply mutations to the underlying real resources instead.',
            ]);
        }

        return $this->blockComment([
            'API boundary guidance for `' . $table . '`.',
            '',
            'Reads -> ' . $class . 'Model.',
            'Writes -> ' . $class . 'Service when generated API capabilities permit writes.',
            '',
            'Keep request parsing, HTTP status codes and serialization in this API Controller.',
            'Do not place SQL, cross-resource persistence or business rules here.',
            'See the generated Model/Service comments and Tools > Domain Analyzer for resource-specific guidance.',
        ]);
    }

    /** @return array<string,string> */
    private function defaultExamples(string $table, string $class, string $entityLocal, string $modelExample): array
    {
        return [
            'entity' => $entityLocal,
            'service' => $this->blockComment([
                'Example: business operation on `' . $table . '`.',
                '',
                'public function performAction(int|string $id, array $data = []): void',
                '{',
                '    $this->update($id, $data);',
                '}',
            ]),
            'model' => $modelExample,
            'controller' => $this->blockComment([
                'Example: thin HTTP action backed by ' . $class . 'Service.',
            ]),
        ];
    }

    /** @param list<string> $lines */
    private function lineComment(array $lines): string
    {
        return implode("\n", array_map(
            static fn (string $line): string => $line === '' ? '//' : '// ' . $line,
            $lines
        ));
    }

    /** @param list<string> $lines */
    private function blockComment(array $lines): string
    {
        $body = array_map(
            static fn (string $line): string => $line === '' ? ' *' : ' * ' . $line,
            $lines
        );

        return "/*\n" . implode("\n", $body) . "\n */";
    }
}
