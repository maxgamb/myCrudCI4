<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>
<?php
$summary = (array) ($analysis['summary'] ?? []);
$resources = (array) ($analysis['resources'] ?? []);
$relations = (array) ($analysis['relations'] ?? []);
$roots = (array) ($analysis['rootCandidates'] ?? []);
$rootCandidatesByTable = [];
foreach ($roots as $candidate) {
    $candidateTable = (string) ($candidate['table'] ?? '');
    if ($candidateTable !== '') {
        $rootCandidatesByTable[$candidateTable] = (int) ($candidate['score'] ?? 0);
    }
}

$isPotentialRoot = static function (array $resource) use ($rootCandidatesByTable): bool {
    $table = (string) ($resource['table'] ?? '');
    return array_key_exists($table, $rootCandidatesByTable) || !empty($resource['rootCandidate']);
};
$potentialRootScore = static function (array $resource) use ($rootCandidatesByTable): int {
    $table = (string) ($resource['table'] ?? '');
    return $rootCandidatesByTable[$table] ?? (int) ($resource['rootScore'] ?? 0);
};

$badgeClass = static fn (string $type): string => match ($type) {
    'master' => 'text-bg-primary',
    'transactional' => 'text-bg-success',
    'dependent' => 'text-bg-warning',
    'lookup' => 'text-bg-info',
    'pivot' => 'text-bg-secondary',
    'view' => 'text-bg-dark',
    default => 'text-bg-light',
};
$confidenceClass = static fn (string $confidence): string => match ($confidence) {
    'high' => 'text-bg-success',
    'medium' => 'text-bg-warning',
    default => 'text-bg-secondary',
};

$classBase = static function (string $table): string {
    $parts = preg_split('/[^a-zA-Z0-9]+/', $table) ?: [$table];
    return implode('', array_map(static fn (string $part): string => ucfirst(strtolower($part)), $parts));
};

$relationDetailsFor = static function (string $table) use ($relations): array {
    $outgoing = [];
    $incoming = [];

    foreach ($relations as $relation) {
        if ((string) ($relation['childTable'] ?? '') === $table) {
            $outgoing[] = $relation;
        }
        if ((string) ($relation['parentTable'] ?? '') === $table) {
            $incoming[] = $relation;
        }
    }

    return [
        'outgoing' => $outgoing,
        'incoming' => $incoming,
    ];
};

$commentedCodePreview = static function (array $resource) use (
    $isPotentialRoot,
    $potentialRootScore,
    $classBase,
    $relationDetailsFor
): array {
    $table = (string) ($resource['table'] ?? 'resource');
    $classification = (string) ($resource['classification'] ?? 'unknown');
    $role = strtoupper($classification);
    $isRoot = $isPotentialRoot($resource);
    $rootScore = $potentialRootScore($resource);
    $root = $isRoot ? 'YES (' . $rootScore . '/20)' : 'NO';
    $parents = implode(', ', (array) ($resource['parents'] ?? [])) ?: 'none';
    $children = implode(', ', (array) ($resource['children'] ?? [])) ?: 'none';
    $lifecycleFields = array_values((array) ($resource['lifecycleFields'] ?? []));
    $lifecycle = implode(', ', $lifecycleFields) ?: 'none';
    $meaningfulFields = array_values((array) ($resource['meaningfulColumns'] ?? []));

    $class = $classBase($table);
    $relationDetails = $relationDetailsFor($table);
    $outgoing = (array) ($relationDetails['outgoing'] ?? []);
    $incoming = (array) ($relationDetails['incoming'] ?? []);
    $firstParentRelation = $outgoing[0] ?? null;
    $firstChildRelation = $incoming[0] ?? null;

    $sampleField = (string) ($meaningfulFields[0] ?? '');
    $stateField = (string) ($lifecycleFields[0] ?? '');
    $parentFk = is_array($firstParentRelation) ? (string) ($firstParentRelation['childColumn'] ?? '') : '';
    $parentTable = is_array($firstParentRelation) ? (string) ($firstParentRelation['parentTable'] ?? '') : '';

    $fieldSuffix = static fn (string $field): string => $field === '' ? '' : $classBase($field);
    $fieldVariable = static fn (string $field): string => $field === '' ? 'value' : lcfirst($classBase($field));

    $schemaLines = [
        "// PHP types: {$class}Entity | {$class}Model | {$class}Service | {$class}Controller",
    ];

    foreach ($outgoing as $relation) {
        $childTable = (string) ($relation['childTable'] ?? '');
        $childColumn = (string) ($relation['childColumn'] ?? '');
        $parentTableName = (string) ($relation['parentTable'] ?? '');
        $parentColumn = (string) ($relation['parentColumn'] ?? '');
        $relatedService = $classBase($parentTableName) . 'Service';
        $schemaLines[] = "// FK OUT: {$childTable}.{$childColumn} -> {$parentTableName}.{$parentColumn} | {$relatedService}";
    }

    foreach ($incoming as $relation) {
        $childTableName = (string) ($relation['childTable'] ?? '');
        $childColumn = (string) ($relation['childColumn'] ?? '');
        $parentTableName = (string) ($relation['parentTable'] ?? '');
        $parentColumn = (string) ($relation['parentColumn'] ?? '');
        $relatedService = $classBase($childTableName) . 'Service';
        $schemaLines[] = "// FK IN : {$childTableName}.{$childColumn} -> {$parentTableName}.{$parentColumn} | {$relatedService}";
    }

    if ($outgoing === [] && $incoming === []) {
        $schemaLines[] = '// FK context: no relations detected for this resource.';
    }

    $header = "// ========================================================================\n"
        . "// MYCRUD DOMAIN DEVELOPMENT EXAMPLE\n"
        . "// ========================================================================\n"
        . "// Resource: {$table}\n"
        . "// Structural role: {$role}\n"
        . "// Structural root: {$root}\n"
        . "// Parents: {$parents}\n"
        . "// Children: {$children}\n"
        . "// Lifecycle: {$lifecycle}\n"
        . implode("\n", $schemaLines) . "\n"
        . "//\n"
        . "// Schema-aware example only. The names above come from the real database.\n"
        . "// Their presence does NOT imply a business rule or an operation.\n"
        . "// Copy/adapt only the parts required by the application requirement.\n"
        . "// Domain Analyzer does not infer business semantics from table/field names.\n"
        . ($isRoot
            ? "// Root guidance: candidate entry point for use-cases centered on this resource.\n"
            : "// Root guidance: keep responsibility local unless the requirement says otherwise.\n")
        . "// ========================================================================\n";

    $localFieldEntityExample = $sampleField !== ''
        ? "/*\n"
            . " * Example: syntax for a record-local rule using a real field.\n"
            . " * The field {$table}.{$sampleField} is used only to make the example concrete.\n"
            . " *\n"
            . " * public function hasLocalValue(): bool\n"
            . " * {\n"
            . " *     return array_key_exists('{$sampleField}', \$this->attributes);\n"
            . " * }\n"
            . " *\n"
            . " * Do not infer a business rule merely because this column exists.\n"
            . " */"
        : "/*\n"
            . " * No safe record-local field example is emitted for this resource.\n"
            . " * Add Entity behavior only when the application defines a real local rule.\n"
            . " */";

    if ($parentFk !== '') {
        $parentMethod = 'findBy' . $fieldSuffix($parentFk);
        $parentVar = $fieldVariable($parentFk);
        $relationModelExample = "/*\n"
            . " * Example: real FK-scoped query.\n"
            . " * Relation: {$table}.{$parentFk} -> {$parentTable}."
            . (string) ($firstParentRelation['parentColumn'] ?? '') . "\n"
            . " *\n"
            . " * public function {$parentMethod}(int|string $" . $parentVar . "): array\n"
            . " * {\n"
            . " *     return \$this\n"
            . " *         ->where('{$parentFk}', $" . $parentVar . ")\n"
            . " *         ->findAll();\n"
            . " * }\n"
            . " */";
    } elseif ($stateField !== '') {
        $stateMethod = 'findBy' . $fieldSuffix($stateField);
        $stateVar = $fieldVariable($stateField);
        $relationModelExample = "/*\n"
            . " * Example: query using detected lifecycle field {$table}.{$stateField}.\n"
            . " *\n"
            . " * public function {$stateMethod}(string $" . $stateVar . "): array\n"
            . " * {\n"
            . " *     return \$this->where('{$stateField}', $" . $stateVar . ")->findAll();\n"
            . " * }\n"
            . " */";
    } elseif ($sampleField !== '') {
        $sampleMethod = 'findBy' . $fieldSuffix($sampleField);
        $sampleVar = $fieldVariable($sampleField);
        $relationModelExample = "/*\n"
            . " * Example: query syntax using real field {$table}.{$sampleField}.\n"
            . " * Add this only if the application really searches by this field.\n"
            . " *\n"
            . " * public function {$sampleMethod}(mixed $" . $sampleVar . "): array\n"
            . " * {\n"
            . " *     return \$this->where('{$sampleField}', $" . $sampleVar . ")->findAll();\n"
            . " * }\n"
            . " */";
    } else {
        $relationModelExample = "/*\n"
            . " * No schema-backed filter example is emitted here.\n"
            . " * Add a Model method only for a real resource-specific read requirement.\n"
            . " */";
    }

    $childServiceNames = array_values(array_unique(array_map(
        static fn (array $relation): string => $classBase((string) ($relation['childTable'] ?? '')) . 'Service',
        $incoming
    )));
    $childServiceText = $childServiceNames !== []
        ? implode(', ', $childServiceNames)
        : 'none detected';

    $examples = match ($classification) {
        'master' => [
            'entity' => $localFieldEntityExample,
            'service' => $isRoot
                ? "/*\n"
                    . " * Example: operation centered on potential structural root `{$table}`.\n"
                    . " * Detected child Services: {$childServiceText}.\n"
                    . " *\n"
                    . " * public function performAction(int|string \$id, array \$data = []): void\n"
                    . " * {\n"
                    . " *     \$record = \$this->model->find(\$id);\n"
                    . " *     if (\$record === null) {\n"
                    . " *         throw new \\RuntimeException('{$table} record not found.');\n"
                    . " *     }\n"
                    . " *\n"
                    . " *     // `{$table}` is structurally a possible use-case entry point.\n"
                    . " *     // Coordinate one of the detected child Services only if the\n"
                    . " *     // approved business requirement actually crosses that relation.\n"
                    . " *     // Never write directly to another resource Model from here.\n"
                    . " *\n"
                    . " *     \$this->update(\$id, \$data);\n"
                    . " * }\n"
                    . " */"
                : "/*\n"
                    . " * Example: local operation on `{$table}`.\n"
                    . " *\n"
                    . " * public function performAction(int|string \$id, array \$data = []): void\n"
                    . " * {\n"
                    . " *     \$record = \$this->model->find(\$id);\n"
                    . " *     if (\$record === null) {\n"
                    . " *         throw new \\RuntimeException('{$table} record not found.');\n"
                    . " *     }\n"
                    . " *\n"
                    . " *     // Keep the rule local: `{$table}` is not a structural-root candidate.\n"
                    . " *     \$this->update(\$id, \$data);\n"
                    . " * }\n"
                    . " */",
            'model' => $relationModelExample,
            'controller' => "/*\n"
                . " * Example: thin HTTP action for {$class}Service.\n"
                . " *\n"
                . " * public function performAction(int|string \$id)\n"
                . " * {\n"
                . " *     \$this->service->performAction(\$id, (array) \$this->request->getPost());\n"
                . " *     return redirect()->back();\n"
                . " * }\n"
                . " *\n"
                . " * Cross-resource orchestration, if required, remains in {$class}Service.\n"
                . " */",
        ],
        'transactional' => [
            'entity' => $stateField !== ''
                ? "/*\n"
                    . " * Example: transition eligibility using detected lifecycle field `{$table}.{$stateField}`.\n"
                    . " *\n"
                    . " * public function canTransitionTo(string \$nextState): bool\n"
                    . " * {\n"
                    . " *     \$currentState = (string) (\$this->attributes['{$stateField}'] ?? '');\n"
                    . " *     // Replace this with the real application transition rule.\n"
                    . " *     return \$currentState !== '' && \$nextState !== '';\n"
                    . " * }\n"
                    . " */"
                : $localFieldEntityExample,
            'service' => $stateField !== ''
                ? "/*\n"
                    . " * Example: state operation using real lifecycle field `{$stateField}`.\n"
                    . ($isRoot ? " * `{$table}` is also a potential structural root.\n" : " * `{$table}` is not a structural-root candidate.\n")
                    . " * Detected child Services: {$childServiceText}.\n"
                    . " *\n"
                    . " * public function transition(int|string \$id, string \$nextState): void\n"
                    . " * {\n"
                    . " *     \$record = \$this->model->find(\$id);\n"
                    . " *     if (\$record === null) {\n"
                    . " *         throw new \\RuntimeException('{$table} record not found.');\n"
                    . " *     }\n"
                    . " *\n"
                    . ($isRoot
                        ? " *     // Coordinate detected dependent Services only when the approved\n *     // use-case requires atomic writes across those real relations.\n"
                        : " *     // Keep this transition local unless the application explicitly\n *     // assigns broader process coordination to this resource.\n")
                    . " *     \$this->update(\$id, ['{$stateField}' => \$nextState]);\n"
                    . " * }\n"
                    . " */"
                : "/*\n"
                    . " * This table is structurally transactional, but no concrete lifecycle\n"
                    . " * field was detected. Do not invent a `status` column or transition API.\n"
                    . " * Add an operation only from an explicit application requirement.\n"
                    . " */",
            'model' => $relationModelExample,
            'controller' => $stateField !== ''
                ? "/*\n"
                    . " * Example: thin HTTP action using real field `{$stateField}`.\n"
                    . " *\n"
                    . " * public function transition(int|string \$id)\n"
                    . " * {\n"
                    . " *     \$nextState = (string) \$this->request->getPost('{$stateField}');\n"
                    . " *     \$this->service->transition(\$id, \$nextState);\n"
                    . " *     return redirect()->back();\n"
                    . " * }\n"
                    . " */"
                : "/*\n * No lifecycle-specific Controller action is suggested because no real lifecycle field was detected.\n */",
        ],
        'dependent' => [
            'entity' => $parentFk !== ''
                ? "/*\n"
                    . " * Example: local presence check for real parent FK `{$table}.{$parentFk}`.\n"
                    . " *\n"
                    . " * public function hasParentReference(): bool\n"
                    . " * {\n"
                    . " *     return !empty(\$this->attributes['{$parentFk}']);\n"
                    . " * }\n"
                    . " *\n"
                    . " * Cross-resource rules remain in the Service.\n"
                    . " */"
                : $localFieldEntityExample,
            'service' => $parentFk !== ''
                ? "/*\n"
                    . " * Example: operation scoped by real parent relation\n"
                    . " * {$table}.{$parentFk} -> {$parentTable}."
                    . (string) ($firstParentRelation['parentColumn'] ?? '') . ".\n"
                    . " *\n"
                    . " * public function createFor{$classBase($parentTable)}(int|string \$parentId, array \$data): int|string\n"
                    . " * {\n"
                    . " *     // Verify the {$parentTable} resource through its concrete Service\n"
                    . " *     // if the application defines a cross-resource rule.\n"
                    . " *     \$data['{$parentFk}'] = \$parentId;\n"
                    . " *     return \$this->create(\$data);\n"
                    . " * }\n"
                    . " */"
                : "/*\n * No concrete parent FK was detected; no createForParent example is emitted.\n */",
            'model' => $relationModelExample,
            'controller' => $parentFk !== ''
                ? "/*\n"
                    . " * Example: preserve real parent context `{$parentTable}` at the HTTP boundary.\n"
                    . " *\n"
                    . " * public function createFor{$classBase($parentTable)}(int|string \$parentId)\n"
                    . " * {\n"
                    . " *     \$data = (array) \$this->request->getPost();\n"
                    . " *     \$this->service->createFor{$classBase($parentTable)}(\$parentId, \$data);\n"
                    . " *     return redirect()->back();\n"
                    . " * }\n"
                    . " */"
                : "/*\n * Keep custom HTTP actions minimal; no concrete parent-scoped action is suggested.\n */",
        ],
        'lookup' => [
            'entity' => $sampleField !== ''
                ? "/*\n"
                    . " * Example: display representation using real field `{$table}.{$sampleField}`.\n"
                    . " *\n"
                    . " * public function displayValue(): string\n"
                    . " * {\n"
                    . " *     return trim((string) (\$this->attributes['{$sampleField}'] ?? ''));\n"
                    . " * }\n"
                    . " *\n"
                    . " * Add this only if this field is really the application's display value.\n"
                    . " */"
                : "/*\n * Lookup Entity behavior is normally unnecessary for this resource.\n */",
            'service' => "/*\n"
                . " * Example: explicit reference-data operation on `{$table}`.\n"
                . " * Ordinary generated CRUD is normally sufficient.\n"
                . " *\n"
                . " * public function changeReferenceData(int|string \$id, array \$data): void\n"
                . " * {\n"
                . " *     \$this->update(\$id, \$data);\n"
                . " * }\n"
                . " */",
            'model' => $relationModelExample,
            'controller' => "/*\n"
                . " * Usually no custom {$class}Controller action is required for lookup maintenance.\n"
                . " */",
        ],
        'pivot' => (static function () use ($outgoing, $table, $classBase): array {
            $left = $outgoing[0] ?? null;
            $right = $outgoing[1] ?? null;
            if (!is_array($left) || !is_array($right)) {
                return [
                    'entity' => "/*\n * Pivot detected, but two concrete FK sides are not available.\n */",
                    'service' => "/*\n * Prefer generated relation APIs; no invented left_id/right_id fields are emitted.\n */",
                    'model' => "/*\n * Add a relation query only when a real FK side is available.\n */",
                    'controller' => "/*\n * No custom relation action is suggested without two concrete FK sides.\n */",
                ];
            }

            $leftFk = (string) ($left['childColumn'] ?? '');
            $rightFk = (string) ($right['childColumn'] ?? '');
            $leftTable = (string) ($left['parentTable'] ?? '');
            $rightTable = (string) ($right['parentTable'] ?? '');
            $leftVar = lcfirst($classBase($leftFk));
            $rightVar = lcfirst($classBase($rightFk));
            $leftMethod = 'findBy' . $classBase($leftFk);

            return [
                'entity' => "/*\n"
                    . " * Example: both real pivot sides are present.\n"
                    . " * {$table}.{$leftFk} -> {$leftTable}; {$table}.{$rightFk} -> {$rightTable}.\n"
                    . " *\n"
                    . " * public function hasBothSides(): bool\n"
                    . " * {\n"
                    . " *     return !empty(\$this->attributes['{$leftFk}'])\n"
                    . " *         && !empty(\$this->attributes['{$rightFk}']);\n"
                    . " * }\n"
                    . " */",
                'service' => "/*\n"
                    . " * Example: explicit relation operation using the real pivot FKs.\n"
                    . " * Prefer generated many-to-many APIs when they already cover the use-case.\n"
                    . " *\n"
                    . " * public function link(int|string $" . $leftVar . ", int|string $" . $rightVar . "): int|string\n"
                    . " * {\n"
                    . " *     return \$this->create([\n"
                    . " *         '{$leftFk}' => $" . $leftVar . ",\n"
                    . " *         '{$rightFk}' => $" . $rightVar . ",\n"
                    . " *     ]);\n"
                    . " * }\n"
                    . " */",
                'model' => "/*\n"
                    . " * Example: real pivot-side query.\n"
                    . " *\n"
                    . " * public function {$leftMethod}(int|string $" . $leftVar . "): array\n"
                    . " * {\n"
                    . " *     return \$this->where('{$leftFk}', $" . $leftVar . ")->findAll();\n"
                    . " * }\n"
                    . " */",
                'controller' => "/*\n"
                    . " * Example: expose a custom relation action only when needed.\n"
                    . " *\n"
                    . " * public function link()\n"
                    . " * {\n"
                    . " *     $" . $leftVar . " = (string) \$this->request->getPost('{$leftFk}');\n"
                    . " *     $" . $rightVar . " = (string) \$this->request->getPost('{$rightFk}');\n"
                    . " *     \$this->service->link($" . $leftVar . ", $" . $rightVar . ");\n"
                    . " *     return redirect()->back();\n"
                    . " * }\n"
                    . " */",
            ];
        })(),
        'view' => [
            'model' => $relationModelExample,
        ],
        default => [
            'entity' => $localFieldEntityExample,
            'service' => "/*\n"
                . " * Example: business operation on `{$table}`.\n"
                . " *\n"
                . " * public function performAction(int|string \$id, array \$data = []): void\n"
                . " * {\n"
                . " *     \$this->update(\$id, \$data);\n"
                . " * }\n"
                . " */",
            'model' => $relationModelExample,
            'controller' => "/*\n"
                . " * Example: thin HTTP action backed by {$class}Service.\n"
                . " */",
        ],
    };

    return array_map(
        static fn (string $example): string => $header . "\n" . $example . "\n",
        $examples
    );
};


$developmentGuidance = static function (array $resource) use ($isPotentialRoot): array {
    $role = (string) ($resource['classification'] ?? '');
    $isRoot = $isPotentialRoot($resource);
    $parents = (array) ($resource['parents'] ?? []);
    $children = (array) ($resource['children'] ?? []);
    $lifecycle = (array) ($resource['lifecycleFields'] ?? []);

    $base = match ($role) {
        'master' => [
            'focus' => 'Autonomous/master data and resource-specific behavior.',
            'entity' => 'Record-local invariants, derived values and domain representation.',
            'service' => 'Business operations on this resource; reuse ordinary CRUD when it is sufficient.',
            'model' => 'Resource-specific searches, filters, projections and relation-aware queries.',
            'caution' => 'Do not turn ordinary master-data maintenance into unnecessary workflows.',
        ],
        'transactional' => [
            'focus' => 'Lifecycle, state transitions, business operations and transaction boundaries.',
            'entity' => 'Local state checks, invariants and transition eligibility.',
            'service' => 'Own approved business use-cases, state transitions, transactions and cross-resource orchestration.',
            'model' => 'Queries by lifecycle/state, history and relation-aware transactional searches.',
            'caution' => 'Lifecycle fields are structural evidence only; do not infer an operation from their names alone.',
        ],
        'dependent' => [
            'focus' => 'Contextual resource whose meaning is strongly tied to parent resources.',
            'entity' => 'Only local checks or derived values that truly belong to this record.',
            'service' => 'Add operations only when this resource is explicitly the primary subject of the requirement.',
            'model' => 'Queries by parent, existence/availability checks and relation navigation.',
            'caution' => 'Before adding business logic here, verify whether responsibility actually belongs to a parent/root resource.',
        ],
        'lookup' => [
            'focus' => 'Reference data with intentionally small application behavior.',
            'entity' => 'Usually minimal; add record-local behavior only for an explicit requirement.',
            'service' => 'Normal CRUD is usually sufficient; add custom operations only for real reference-data rules.',
            'model' => 'Ordered/active reference lists and label/value lookups.',
            'caution' => 'Prefer simplicity. Do not introduce workflows by default.',
        ],
        'pivot' => [
            'focus' => 'Relationship management between parent resources.',
            'entity' => 'Usually minimal unless the relationship itself carries meaningful business attributes.',
            'service' => 'Prefer existing generated many-to-many APIs; add explicit attach/detach/sync behavior only when required.',
            'model' => 'Relation queries and filtering by either side of the relationship.',
            'caution' => 'Do not treat the pivot as an autonomous business resource by default.',
        ],
        'view' => [
            'focus' => 'Read-only projection supplied by the database.',
            'entity' => 'Normally no domain mutation behavior.',
            'service' => 'No write use-cases should target the SQL view directly.',
            'model' => 'Read/query access only, according to the generated view support.',
            'caution' => 'Apply writes to the underlying real resources, not to the projection.',
        ],
        default => [
            'focus' => 'No specific development guidance is available.',
            'entity' => 'Use only for record-local behavior.',
            'service' => 'Use for business operations.',
            'model' => 'Use for database queries and persistence.',
            'caution' => 'Confirm the application requirement before adding domain behavior.',
        ],
    };

    if ($isRoot) {
        $base['root'] = 'Structural root candidate: this resource may be a good application/use-case entry point when the requirement primarily changes it.';
    } else {
        $base['root'] = 'Not a structural root candidate: this does not forbid business logic, but the primary responsibility should be confirmed from the requirement.';
    }

    $base['relations'] = $parents !== [] || $children !== []
        ? 'Consider related resources when the use-case crosses these relations; writes to other resources should use their concrete Services.'
        : 'No FK-based cross-resource guidance is available.';
    $base['lifecycle'] = $lifecycle !== []
        ? 'Detected lifecycle/event fields: ' . implode(', ', $lifecycle) . '.'
        : 'No explicit lifecycle/event fields detected.';

    return $base;
};
?>

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="bi bi-bezier2 me-2"></i>Domain Analyzer</h1>
        <p class="text-muted mb-0">
            V2 structural analysis derived from PK, FK, relation direction, true lifecycle fields, autonomy and table shape.
            It does <strong>not</strong> invent business operations.
        </p>
    </div>
    <a href="<?= site_url('mycrud/tools/schema') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-diagram-3 me-1"></i>Database Schema
    </a>
</div>

<div class="alert alert-info d-flex gap-2 align-items-start" role="alert">
    <i class="bi bi-info-circle-fill mt-1"></i>
    <div>
        <strong>How to read this page.</strong>
        Classification and root candidates are structural hypotheses with visible evidence. A use-case primary resource
        still depends on the application requirement and must not be inferred from the database alone.
    </div>
</div>

<div class="row g-3 mb-4">
    <?php foreach ([
        'master' => ['Master', 'bi-box'],
        'transactional' => ['Transactional', 'bi-arrow-left-right'],
        'dependent' => ['Dependent', 'bi-diagram-2'],
        'lookup' => ['Lookup', 'bi-bookmark'],
        'pivot' => ['Pivot', 'bi-link-45deg'],
        'view' => ['Views', 'bi-eye'],
    ] as $key => [$label, $icon]): ?>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted"><?= esc($label) ?></div>
                            <div class="fs-3 fw-semibold"><?= (int) ($summary[$key] ?? 0) ?></div>
                        </div>
                        <i class="bi <?= esc($icon) ?> fs-3 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Resource map</strong>
                <span class="badge text-bg-light"><?= count($resources) ?> objects</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Resource</th>
                        <th>Classification</th>
                        <th>Parents</th>
                        <th>Children</th>
                        <th>Lifecycle</th>
                        <th>Confidence</th>
                        <th class="text-end">Root</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($resources as $resource): ?>
                        <tr>
                            <td>
                                <a class="fw-semibold text-decoration-none" href="#resource-<?= esc($resource['table']) ?>">
                                    <?= esc($resource['table']) ?>
                                </a>
                            </td>
                            <td><span class="badge <?= $badgeClass((string) $resource['classification']) ?>"><?= esc($resource['classificationLabel']) ?></span></td>
                            <td class="small"><?= esc(implode(', ', (array) $resource['parents']) ?: '—') ?></td>
                            <td class="small"><?= esc(implode(', ', (array) $resource['children']) ?: '—') ?></td>
                            <td class="small"><?= esc(implode(', ', (array) $resource['lifecycleFields']) ?: '—') ?></td>
                            <td><span class="badge <?= $confidenceClass((string) $resource['confidence']) ?>"><?= esc(strtoupper((string) $resource['confidence'])) ?></span></td>
                            <td class="text-end">
                                <?php $resourceIsRoot = $isPotentialRoot($resource); $resourceRootScore = $potentialRootScore($resource); ?>
                                <?php if ($resourceIsRoot): ?>
                                    <span class="badge rounded-pill text-bg-primary"><?= $resourceRootScore ?>/20</span>
                                <?php else: ?>
                                    <span class="text-muted small"><?= $resourceRootScore ?>/20</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header"><strong>Potential structural roots</strong></div>
            <div class="card-body">
                <p class="small text-muted">Candidates with structural autonomy. This is intentionally different from graph centrality and is not a use-case decision.</p>
                <?php if ($roots === []): ?>
                    <div class="text-muted">No strong candidates detected.</div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($roots as $root): ?>
                            <a href="#resource-<?= esc($root['table']) ?>" class="list-group-item list-group-item-action px-0 d-flex justify-content-between align-items-center">
                                <span>
                                    <strong><?= esc($root['table']) ?></strong>
                                    <small class="d-block text-muted"><?= esc($root['classification']) ?> · <?= esc($root['confidence']) ?></small>
                                </span>
                                <span class="badge text-bg-primary rounded-pill"><?= (int) $root['score'] ?>/20</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<h2 class="h4 mb-1">Resource analysis &amp; development guidance</h2>
<p class="text-muted mb-3">Structural Role + Structural Root + relations + lifecycle are translated into developer guidance. This preview does not modify generated code.</p>
<div class="row g-3 mb-4">
    <?php foreach ($resources as $resource): ?>
        <div class="col-lg-6" id="resource-<?= esc($resource['table']) ?>">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center gap-2">
                    <div>
                        <strong><?= esc($resource['table']) ?></strong>
                        <span class="badge <?= $badgeClass((string) $resource['classification']) ?> ms-1"><?= esc($resource['classificationLabel']) ?></span>
                    </div>
                    <span class="badge <?= $confidenceClass((string) $resource['confidence']) ?>"><?= esc(strtoupper((string) $resource['confidence'])) ?></span>
                </div>
                <div class="card-body">
                    <div class="row g-2 small mb-3">
                        <div class="col-6"><span class="text-muted">Parents:</span> <strong><?= (int) $resource['outgoingCount'] ?></strong></div>
                        <div class="col-6"><span class="text-muted">Children:</span> <strong><?= (int) $resource['incomingCount'] ?></strong></div>
                        <div class="col-6"><span class="text-muted">Root score:</span> <strong><?= $potentialRootScore($resource) ?>/20</strong></div>
                        <div class="col-6"><span class="text-muted">Rows est.:</span> <strong><?= number_format((int) $resource['rowEstimate']) ?></strong></div>
                    </div>

                    <div class="small fw-semibold mb-1">Evidence</div>
                    <ul class="small mb-3">
                        <?php foreach ((array) $resource['evidence'] as $evidence): ?>
                            <li><?= esc($evidence) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if ((array) $resource['parents'] !== []): ?>
                        <div class="small"><span class="text-muted">Parent resources:</span> <?= esc(implode(', ', (array) $resource['parents'])) ?></div>
                    <?php endif; ?>
                    <?php if ((array) $resource['children'] !== []): ?>
                        <div class="small"><span class="text-muted">Child resources:</span> <?= esc(implode(', ', (array) $resource['children'])) ?></div>
                    <?php endif; ?>
                    <?php if ((array) $resource['lifecycleFields'] !== []): ?>
                        <div class="small"><span class="text-muted">Lifecycle fields:</span> <?= esc(implode(', ', (array) $resource['lifecycleFields'])) ?></div>
                    <?php endif; ?>

                    <?php
                    $guidance = $developmentGuidance($resource);
                    $preview = $commentedCodePreview($resource);
                    $collapseId = 'guidance-' . preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $resource['table']);
                    $previewId = 'code-example-' . preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $resource['table']);
                    ?>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary text-start" type="button"
                                data-bs-toggle="collapse" data-bs-target="#<?= esc($collapseId) ?>"
                                aria-expanded="false" aria-controls="<?= esc($collapseId) ?>">
                            <i class="bi bi-chevron-down me-1"></i>Development guidance
                        </button>
                        <?php $resourceIsRoot = $isPotentialRoot($resource); $resourceRootScore = $potentialRootScore($resource); ?>
                        <span class="badge <?= $resourceIsRoot ? 'text-bg-primary' : 'text-bg-light' ?>">
                            Structural root: <?= $resourceIsRoot ? 'YES · ' . $resourceRootScore . '/20' : 'NO' ?>
                        </span>
                    </div>

                    <div class="collapse mt-3" id="<?= esc($collapseId) ?>">
                        <?php if (($resource['classification'] ?? '') === 'view'): ?>
                            <p class="small mb-2"><strong>Focus:</strong> <?= esc($guidance['focus']) ?></p>
                            <div class="small mb-1"><strong>Model/read layer:</strong> <?= esc($guidance['model']) ?></div>
                            <div class="alert alert-light border small py-2 px-3 mb-2 mt-2">
                                SQL View: no Entity mutation, Service write operation or business transition is suggested.
                                Apply writes to the underlying real resources.
                            </div>
                        <?php else: ?>
                            <p class="small mb-2"><strong>Focus:</strong> <?= esc($guidance['focus']) ?></p>
                            <div class="small mb-1"><strong>Entity:</strong> <?= esc($guidance['entity']) ?></div>
                            <div class="small mb-1"><strong>Service:</strong> <?= esc($guidance['service']) ?></div>
                            <div class="small mb-1"><strong>Model:</strong> <?= esc($guidance['model']) ?></div>
                            <div class="small mb-1"><strong>Controller:</strong> HTTP boundary for approved use-cases; keep business rules out of the Controller.</div>
                            <div class="small mb-1"><strong>Relations:</strong> <?= esc($guidance['relations']) ?></div>
                            <div class="small mb-2"><strong>Lifecycle:</strong> <?= esc($guidance['lifecycle']) ?></div>
                        <?php endif; ?>

                        <div class="alert alert-light border small py-2 px-3 mb-2">
                            <strong>Root guidance:</strong> <?= esc($guidance['root']) ?>
                        </div>
                        <div class="small text-muted mb-3"><strong>Caution:</strong> <?= esc($guidance['caution']) ?></div>

                        <button class="btn btn-sm btn-outline-primary" type="button"
                                data-bs-toggle="collapse" data-bs-target="#<?= esc($previewId) ?>"
                                aria-expanded="false" aria-controls="<?= esc($previewId) ?>">
                            <i class="bi bi-file-earmark-code me-1"></i>Commented code examples
                        </button>
                        <span class="small text-muted ms-2">Preview only — no PHP file is modified.</span>

                        <div class="collapse mt-3" id="<?= esc($previewId) ?>">
                            <div class="alert alert-info small py-2 mb-3">
                                These are anonymous, commented PHP examples showing how a developer could extend the resource. They are not written to disk and do not define required MyCrud APIs.
                            </div>
                            <?php foreach ($preview as $area => $code): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="small text-uppercase"><?= esc($area) ?></strong>
                                        <?php
                                        $previewFile = match ($area) {
                                            'entity' => $classBase((string) $resource['table']) . 'Entity.php',
                                            'service' => $classBase((string) $resource['table']) . 'Service.php',
                                            'model' => $classBase((string) $resource['table']) . 'Model.php',
                                            'controller' => $classBase((string) $resource['table']) . 'Controller.php',
                                            default => $classBase((string) $resource['table']) . '.php',
                                        };
                                        ?>
                                        <span class="badge text-bg-light"><?= esc($previewFile) ?></span>
                                    </div>
                                    <pre class="bg-body-tertiary border rounded p-3 small mb-0" style="white-space: pre-wrap;"><code><?= esc($code) ?></code></pre>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header"><strong>Foreign-key graph</strong></div>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light"><tr><th>Child</th><th>FK</th><th>Parent</th><th>DELETE</th><th>UPDATE</th></tr></thead>
            <tbody>
            <?php foreach ($relations as $relation): ?>
                <tr>
                    <td><?= esc($relation['childTable']) ?></td>
                    <td><code><?= esc($relation['childColumn']) ?></code></td>
                    <td><?= esc($relation['parentTable']) ?>.<code><?= esc($relation['parentColumn']) ?></code></td>
                    <td><span class="badge text-bg-light"><?= esc($relation['deleteRule'] ?: '—') ?></span></td>
                    <td><span class="badge text-bg-light"><?= esc($relation['updateRule'] ?: '—') ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
